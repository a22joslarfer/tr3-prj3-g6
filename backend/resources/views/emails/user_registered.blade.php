<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a ELYSIUM</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;   
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333333;
        }
       
        .container {
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }


        /* Encabezado */
        .header {
            text-align: center;
            padding: 20px;
            background-color: #007bff;
            color: #ffffff;
        }


        /* Logo */
        .logo {
            max-width: 100%;
            border-radius: 8px 8px 0 0;
        }


        /* Título */
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }


        /* Texto */
        .text {
            font-size: 16px;
            line-height: 1.5;
            padding: 20px;
        }


        /* Botón */
        .button {
            display: block;
            width: 100%;
            padding: 12px 0;
            text-align: center;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border: none;
            border-radius: 0 0 8px 8px;
        }


        .button:hover {
            background-color: #0056b3;
        }


        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
            color: #666666;
            font-size: 14px;
        }


        /* Enlaces */
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .ii a[href] {
    color: #fff;
    text-decoration: none;
}
    </style>
</head>


<body>
    <div class="container">
        <div class="header">
            <img src="../../../public/1349393-min.png" alt="Logo de la empresa" class="logo">
            <h1 class="title">¡Bienvenido a ELYSIUM, {{ $user->name }}!</h1>
        </div>
        <div class="text">
            <p>Gracias por registrarte en nuestra plataforma. Estamos emocionados de tenerte como parte de nuestra comunidad.</p>
            <p>Te ofrecemos herramientas innovadoras y recursos útiles para que saques el máximo provecho de nuestra plataforma.</p>
        </div>
        <a href="http://elysium.daw.inspedralbes.cat/" class="button">Visita nuestra web!</a>
        <div class="footer">
            <p>Este correo electrónico fue enviado desde una dirección no monitoreada. Por favor, no respondas a este mensaje.</p>
        </div>
    </div>
</body>


</html>
