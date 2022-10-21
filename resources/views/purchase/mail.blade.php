<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Purchase State</title>
</head>

<body>

	<h2>Su compra se ha realizado con exito</h2>
	<div>
		<h3>Lista de compra:</h3>

		<br>
		<ol>
			@foreach($cartCollection as $item)
				<li>{{ $item->titulo }} ( x{{ $item->quantity }} ): {{ $item->valor }}</li>
			@endforeach
		</ol>
		<br>

		<h4>Total: {{ \Cart::getTotal() }}</h4>

	</div>

</body>
</html>