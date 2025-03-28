<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Código de Verificación</title>
    <style type="text/css">
        body {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
            line-height: 100%;
        }

        table {
            border-collapse: collapse;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f9; font-family: Arial, sans-serif;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f4f4f9;">
        <tr>
            <td align="center">
                <table class="email-container" align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="width: 100%; max-width: 600px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center" style="background-color: #4CAF50; padding: 30px 20px; color: #ffffff; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                            <h1 style="margin: 0; font-size: 28px; font-weight: bold;">Código de Verificación</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px 20px; line-height: 1.6;">
                            <p style="margin: 0 0 20px 0; padding: 0; font-size: 16px; color: #333;">Hola <strong style="font-weight: bold;">{{ $user->name }}</strong>,</p>
                            <p style="margin: 0 0 20px 0; padding: 0; font-size: 16px; color: #333;">Gracias por registrarte en nuestra plataforma. Para completar el proceso de verificación, utiliza el siguiente código:</p>
                            <div style="display: inline-block; background-color: #e6f7eb; color: #4CAF50; font-weight: bold; padding: 12px 25px; border: 1px solid #4CAF50; border-radius: 6px; font-size: 20px; margin: 20px 0;">{{ $code }}</div>
                            <p style="margin: 0 0 20px 0; padding: 0; font-size: 16px; color: #333;">Por favor, ingresa este código en la página de verificación para confirmar tu correo electrónico.</p>
                            <p style="margin: 0; padding: 0; font-size: 16px; color: #333;"><strong style="font-weight: bold;">Nota:</strong> Este código expirará en 60 minutos.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px; font-size: 14px; color: #777; background-color: #f9f9f9; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                            <p style="margin: 0; padding: 0;">Si no solicitaste este correo, puedes ignorarlo de manera segura.</p>
                            <p style="margin: 10px 0 0 0; padding: 0;">&copy; {{ date('Y') }} Handiman. Todos los derechos reservados.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>