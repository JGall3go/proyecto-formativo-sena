<?php

namespace App\Http\Controllers\store;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

// Paypal
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

class PagoController extends Controller
{	
	private $apiContext;

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
		//dump($item);
		$cartCollection = \Cart::getContent();
		// dd($cartCollection);
		return view('store/metodo')->with(['cartCollection' => $cartCollection]);
	}

	// Esta funcion es para el boton de PayPal (redireccionar al usuario a paypal)
	public function store(Request $request)
	{
		$cartCollection = \Cart::getContent();
		$cartTotal = \Cart::getTotal();

		$payer = new Payer();
		$payer->setPaymentMethod('paypal');

		$amount = new Amount();
		$amount->setTotal($cartTotal);
		$amount->setCurrency('USD');

		$transaction = new Transaction();
		$transaction->setAmount($amount);

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
		}
		catch (PayPalConnectionException $ex) {
			// This will print the detailed information on the exception.
			//REALLY HELPFUL FOR DEBUGGING
			echo $ex->getData();
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

		if($result->getState() === 'approved')
		{
			$status = "true";
			$cartCollection = \Cart::getContent();
			return redirect('/checkout')->with(['status' => $status, 'cartCollection' => $cartCollection]);
		}

		$status = "false";
		$cartCollection = \Cart::getContent();
		return redirect('/checkout')->with(['status' => $status, 'cartCollection' => $cartCollection]);
	}
}