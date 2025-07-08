<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Reset Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */

    'password' => 'La contraseña debe tener al menos ocho caracteres y coincidir con la confirmación.',
    'reset' => '¡Su contraseña ha sido restablecida!',
    'sent' => '¡Recordatorio de contraseña enviado!',
    'token' => 'Este token de restablecimiento de contraseña es inválido.',
    'user' => 'No se ha encontrado un usuario con esa dirección de correo.',

    "reset_password" => [
        "subject" => "Solicitud de restablecimiento de contraseña",
        "greeting" => "¡Hola!",
        "intro" => "Recibiste este correo porque recibimos una solicitud para restablecer la contraseña de tu cuenta.",
        "expired" => "Este enlace de restablecimiento de contraseña caducará en 60 minutos.",
        "action" => "Restablecer contraseña",
        "outro" => "Si no solicitaste restablecer tu contraseña, no se requiere ninguna otra acción.",
        "regards" => "Saludos",
        'trouble_clicking_button' => "Si tienes problemas haciendo clic en el botón \":actionText\", copia y pega la URL a continuación\nen tu navegador web:",
    ]
];
