<?php

namespace App\Http\Controllers\store;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

// Modelos
use App\Models\Keys;
use App\Models\KeyDetalle;
use App\Models\Producto;

// Carrito
use Darryldecode\Cart\Cart;
use App\Mail\PurchaseResponse;
use Illuminate\Support\Facades\Mail;

// Paypal
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\Item;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

class PagoController extends Controller
{	
	private $apiContext;
	private $idPerfil;

	// Esta funcion crea el contexto que necesita la API de PayPal
	public function __construct()
	{
		$paypalConfig = Config::get('paypal');

		$this->apiContext = new ApiContext(
			new OAuthTokenCredential(
				$paypalConfig['client_id'],
				$paypalConfig['secret']
			)
		);
	}

	public function index(Request $item)
	{

		$cartCollection = \Cart::getContent();

		foreach ($cartCollection as $producto) {
			
			$estado = DB::table('producto')
			->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
			->select('estado')
			->where('idProducto', 'Like', '%' . $producto->idProducto . '%')
			->first();

			/* Si el producto se inactiva en el momento de hacer la compra
			se removera de la lista del carrito y por ende de la compra*/
			if ($estado->estado == "Inactivo") {

				\Cart::remove($producto->idProducto);
			}
		}

		return view('store/metodo')->with(['cartCollection' => $cartCollection]);

	}

	// Esta funcion es para el boton de PayPal (redireccionar al usuario a paypal)
	public function store(Request $request)
	{

		$cartCollection = \Cart::getContent();
		$cartTotal = \Cart::getTotal();

		foreach ($cartCollection as $producto) {
			
			$estado = DB::table('producto')
			->join('estado', 'estado_idEstado', '=', 'idEstado')
			->select('estado')
			->where('idProducto', 'Like', '%' . $producto->idProducto . '%')
			->first();

			/* Si el producto se inactiva en el momento de hacer la compra
			se removera de la lista del carrito y por ende de la compra*/
			if ($estado->estado == "Inactivo") {

				\Cart::remove($producto->idProducto);

				$cartCollection = \Cart::getContent();
				$cartTotal = \Cart::getTotal();
			}
		}

		if (Auth::check()) {

			$datosContacto = Auth::user();

			$usuario = DB::table('perfil')
			->join('usuario', 'usuario_idUsuario', '=', 'idUsuario')
			->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto')
			->join('estado', 'estado_idEstado', '=', 'idEstado')
			->select('idPerfil', 'estado')
			->where('idContacto', $datosContacto['idContacto'])
			->first();

			if ($usuario->estado == "Activo") {

				$this->idPerfil = $usuario->idPerfil;

				$payer = new Payer();
				$payer->setPaymentMethod('paypal');

				$amount = new Amount();
				$amount->setTotal($cartTotal);
				$amount->setCurrency('USD');

				$itemList = new ItemList();

				foreach ($cartCollection as $producto) {

					$item = new Item();
					$item->setName($producto->titulo);
					$item->setQuantity($producto->quantity);
					$item->setPrice($producto->valor);
					$item->setCurrency("USD");

					$itemList->addItem($item);
				}

				$transaction = new Transaction();
				$transaction->setAmount($amount);
				$transaction->setItemList($itemList);

				$statusUrl = url('/checkout/status');
				$redirectUrls = new RedirectUrls();
				$redirectUrls->setReturnUrl($statusUrl)
					->setCancelUrl($statusUrl);

				$payment = new Payment();
				$payment->setIntent('sale')
				->setPayer($payer)
				->setTransactions(array($transaction))
				->setRedirectUrls($redirectUrls);

				try {

					$payment->create($this->apiContext);
					return redirect()->away($payment->getApprovalLink());
				
				} catch (PayPalConnectionException $ex) {

					$status = "false";
					$cartCollection = \Cart::getContent();
					return redirect('/checkout')->with(['status' => $status, 'cartCollection' => $cartCollection]);
				}
			} else {

				return redirect('/logout');
			}

		} else {

			return redirect()->route('Login.index');
		}
	}

	// Esta funcion valida si la compra se realizo correctamente.
	public function show(Request $request)
	{
		$paymentId = $request->input('paymentId');
		$payerId = $request->input('PayerID');
		$token = $request->input('token');

		if (!$paymentId || !$payerId || !$token)
		{
			$status = "false";
			$cartCollection = \Cart::getContent();
			return redirect('/checkout')->with(['status' => $status, 'cartCollection' => $cartCollection]);
		}

		$payment = Payment::get($paymentId, $this->apiContext);

		$execution = new PaymentExecution();
		$execution->setPayerId($payerId);

		$result = $payment->execute($execution, $this->apiContext);

		if ($result->getState() === 'approved')
		{

			$datosContacto = Auth::user();

			$usuario = DB::table('perfil')
			->join('usuario', 'usuario_idUsuario', '=', 'idUsuario')
			->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto')
			->select('idPerfil', 'email')
			->where('idContacto', $datosContacto['idContacto'])
			->first();

			// Se registra la venta en la base de datos
			$venta = DB::table('venta')->insertGetId([
				'fecha' => date("y-m-d"),
				'total' => \Cart::getTotal(),
				'metodo_pago_idMetodo' => 2, // 2 es PayPal
				'perfil_idPerfil' => $usuario->idPerfil,
			]);

			$cartCollection = \Cart::getContent();
			$cartTotal = \Cart::getTotal();

			foreach ($cartCollection as $producto) {

				$ventaDetalle = DB::table('venta_detalle')->insertGetId([
					'venta_idVenta' => $venta,
					'producto_idProducto' => $producto->idProducto,
					'cantidad' => $producto->quantity,
					'total' => $producto->valor * $producto->quantity,
				]);

				$cantidad = DB::table('producto')
				->select('idProducto', 'cantidad')
				->where('idProducto', $producto->idProducto)
				->first();

				Producto::where('idProducto', '=', $producto->idProducto)->update([
					'cantidad' => intval($cantidad->cantidad - $producto->quantity)
				]);

				$keys = Keys::where('producto_idProducto', '=', $producto->idProducto)->first();

				$keysDisponibles = DB::table('key_detalle')
				->join('keys', 'keys_idKey', '=', 'idKey')
				->join('producto', 'producto_idProducto', '=', 'idProducto')
				->select('idDetalle', 'key')
				->where('keys_idKey', $keys->idKey)
				->whereNull('key_detalle.perfil_idPerfil')
				->get();

				$quantity = intval($producto->quantity);
				$keysCompradas = [];

				foreach ($keysDisponibles as $key) {

					if ($quantity > 0) {
						
						KeyDetalle::where('idDetalle', '=', $key->idDetalle)->update([
							'perfil_idPerfil' => $usuario->idPerfil,
						]);
					}

					$quantity = $quantity - 1;
				}
			}

			$correo = new PurchaseResponse;
			Mail::to($usuario->email)->send($correo);

			\Cart::clear();

			$status = "true";
			$cartCollection = \Cart::getContent();

			return redirect('/checkout')->with(['status' => $status, 'cartCollection' => $cartCollection]);
		}

		$status = "false";
		$cartCollection = \Cart::getContent();
		return redirect('/checkout')->with(['status' => $status, 'cartCollection' => $cartCollection]);
	}
}