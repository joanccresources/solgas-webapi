<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $title }}</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f6f8;
			margin: 0;
			padding: 0;
			color: #374151;
		}

		.container {
			max-width: 600px;
			margin: 50px auto;
			background-color: #ffffff;
			border-radius: 10px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			overflow: hidden;
			border: 1px solid #e5e7eb;
		}

		.header {
			background-color: rgba(33, 42, 92, 0.59);
			color: #ffffff;
			text-align: center;
			padding: 20px 30px;
		}

		.header h1 {
			margin: 0;
			font-size: 22px;
			font-weight: bold;
		}

		.header img {
			margin-top: 15px;
			max-width: 120px;
			border-radius: 5px;
		}

		.content {
			padding: 20px 30px;
		}

		.content p {
			margin: 12px 0;
			font-size: 16px;
			line-height: 1.5;
		}

		.content p strong {
			display: inline-block;
			min-width: 200px;
			font-weight: bold;
			color: #1f2937;
		}

		.content a {
			color: #2563eb;
			text-decoration: none;
		}

		.content a:hover {
			text-decoration: underline;
		}

		.footer {
			background-color: #f9fafb;
			text-align: center;
			padding: 15px;
			font-size: 12px;
			color: #6b7280;
			border-top: 1px solid #e5e7eb;
		}

		.footer p {
			margin: 0;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="header">
			<h1>{{ $title }}</h1>
			<img src="{{ $logo_email }}" alt="Solgas">
		</div>
		<div class="content">
			<p><strong>Nombre:</strong> {{ $lead->full_name }}</p>
			<p><strong>DNI o RUC:</strong> {{ $lead->dni_or_ruc }}</p>
			<p><strong>Teléfono 1:</strong> {{ $lead->phone_1 }}</p>
			<p><strong>Teléfono 2:</strong> {{ $lead->phone_2 }}</p>
			<p><strong>Email:</strong> <a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></p>
			<p><strong>Dirección:</strong> {{ $lead->address }}</p>
			<p><strong>Departamento:</strong> {{ $lead->codeUbigeoRel->department }}</p>
			<p><strong>Provincia:</strong> {{ $lead->codeUbigeoRel->province }}</p>
			<p><strong>Distrito:</strong> {{ $lead->codeUbigeoRel->district }}</p>
			<p><strong>¿Tiene local?:</strong> {{ $lead->has_store ? 'Sí' : 'No' }}</p>
			<p><strong>¿Vende balones de gas?:</strong> {{ $lead->sells_gas_cylinders ? 'Sí' : 'No' }}</p>
			<p><strong>Marcas que vende:</strong> {{ $lead->brands_sold }}</p>
			<p><strong>Tiempo vendiendo balones:</strong> {{ $lead->selling_time }}</p>
			<p><strong>Balones vendidos al mes:</strong> {{ $lead->monthly_sales }}</p>
		</div>
		<div class="footer">
			<p>Este es un mensaje automático, no es necesario responder.</p>
		</div>
	</div>
</body>

</html>
