<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gracias por contactarnos</title>
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
			font-size: 24px;
			font-weight: bold;
		}

		.header img {
			margin-top: 10px;
			max-width: 120px;
			border-radius: 5px;
		}

		.content {
			padding: 20px 30px;
		}

		.content h2 {
			font-size: 20px;
			color: rgba(33, 42, 92, 0.9);
			margin-top: 0;
		}

		.content p {
			margin: 12px 0;
			font-size: 16px;
			line-height: 1.5;
		}

		.content a {
			display: inline-block;
			margin-top: 15px;
			padding: 10px 20px;
			background-color: #2563eb;
			color: #ffffff;
			text-decoration: none;
			border-radius: 5px;
			font-size: 16px;
		}

		.content a:hover {
			background-color: #1d4ed8;
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
			<h1>¡Gracias por contactarnos!</h1>
			<img src="{{ $logo_email }}" alt="Logo Solgas">
		</div>
		<div class="content">
			<h2>Hola {{ $lead->full_name }},</h2>
			<p>Gracias por llenar nuestro formulario. Hemos recibido tu información y uno de nuestros representantes se pondrá en contacto contigo muy pronto.</p>
			<p>Mientras tanto, si tienes alguna consulta adicional, no dudes en contactarnos a través de nuestro sitio web.</p>
			<a href="{{ $url_fronted }}" target="_blank">Visita nuestro sitio web</a>
		</div>
		<div class="footer">
			<p>© {{ date('Y') }} Solgas. Todos los derechos reservados.</p>
		</div>
	</div>
</body>

</html>
