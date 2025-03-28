<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bienvenido</title>
    <style type="text/css">
        body {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
            line-height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        table {
            border-collapse: collapse;
        }

        .welcome-container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .welcome-header {
            background-color: #4CAF50;
            color: #ffffff;
            text-align: center;
            padding: 30px 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .welcome-body {
            padding: 30px 20px;
            line-height: 1.6;
        }

        .welcome-footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
            background-color: #f9f9f9;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
    </style>
</head>
<body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="welcome-container" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                    <tr>
                        <td class="welcome-header">
                            <h1 style="margin: 0; font-size: 28px; font-weight: bold;">¡Hola, {{ $user->name }}!</h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="welcome-body">
                            <p style="margin: 0 0 20px 0; font-size: 16px; color: #333;">Gracias por registrarte en nuestra plataforma. Estamos encantados de tenerte con nosotros.</p>
                            <p style="margin: 20px 0; font-size: 16px; color: #333;">Explora nuestras características y comienza a disfrutar de todos los beneficios que tenemos para ti.</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="welcome-footer">
                            <p style="margin: 0;">&copy; {{ date('Y') }} Handiman. Todos los derechos reservados.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>