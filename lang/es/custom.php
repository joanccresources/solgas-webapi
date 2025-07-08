<?php

return [
    'attribute' => [
        'plan' => 'El plan',
        'session' => 'La sesión',
        'message' => 'El mensaje',
        'user' => 'El usuario',
        'personal_information' => 'La información personal',
        'change_password' => 'La contraseña',
        'image' => 'La imagen',
        'profile' => 'El perfil del usuario',
        'file' => 'El archivo',
        'element-order' => 'El orden de los elementos',
        'payment' => 'El pago',
        'role' => 'El rol',
        'element' => 'El elemento',

        'permission' => 'El permiso',
        'module' => 'El módulo',
        'submodule' => 'El submódulo',

        'page' => 'La página',
        'page_section' => 'La sección',
        'page_field' => 'El campo',
        'page_multiple_field' => 'El elemento',
        'page_multiple_field_data' => 'El campo',
        'page_multiple_field_section' => 'El elemento',

        'content_social_network' => 'La red social',
        'content_seo' => 'El seo de la página',
        'content_page' => 'El contenido de la página',
        'content_multiple_page' => 'El contenido de la página',

        'attribute' => 'El atributo',

        'tag' => 'La etiqueta',
        'category' => 'La categoría',
        'post' => 'La publicación',

        'employment' => 'El empleo',
        'employment_type' => 'El tipo de empleo',
        'employment_area' => 'El área de empleo',

        'general_information' => 'La información general',
        'image_post' => 'La imagen',

        'comment' => 'El comentario',

        'cookie_consent' => 'El consentimiento de cookie',
    ],
    'title' => [
        'error' => 'Error',
        'warning' => 'Advertencia',
        'success' => 'Éxito',
    ],
    'errors' => [
        'image' => 'Ocurrió un error al momento de subir la imagen. Por favor, inténtelo nuevamente.',
        'file' => 'Ocurrió un error al momento de subir el archivo. Por favor, inténtelo nuevamente.',
        'video' => 'Ocurrió un error al momento de subir el video. Por favor, inténtelo nuevamente.',
    ],
    'message' => [
        'disable' => [
            'success' => ':name se ha deshabilitado.',
            'error' => 'Lo sentimos. :name no se pudo deshabilitar debido a un error.',
        ],
        'resend' => [
            'success' => 'El email se ha reenviado.',
            'error' => 'Lo sentimos. El email no se pudo reenviar debido a un error.',
        ],
        'create' => [
            'success' => ':name se ha creado.',
            'error' => 'Lo sentimos. :name no se pudo crear debido a un error.',
        ],
        'update' => [
            'success' => ':name se ha actualizado.',
            'error' => 'Lo sentimos. :name no se pudo actualizar debido a un error.',
            'plural' => [
                'success' => ':name se han actualizado.',
                'error' => 'Lo sentimos. :name no se pudieron actualizar debido a un error.',
            ],
        ],
        'delete' => [
            'success' => ':name se ha eliminado.',
            'error' => 'Lo sentimos, :name no se pudo eliminar debido a un error.',
        ],
        'sendtosupervision' => [
            'success' => ':name se ha enviado a supervisión.',
            'error' => 'Lo sentimos, :name no se pudo enviar a supervisión debido a un error.',
        ],
        'approve' => [
            'success' => ':name se ha aprobado.',
            'error' => 'Lo sentimos, :name no se pudo aprobar debido a un error.',
        ],
        'disapprove' => [
            'success' => ':name se ha desaprobado.',
            'error' => 'Lo sentimos, :name no se pudo desaprobar debido a un error.',
        ],
        'withobservation' => [
            'success' => ':name se ha observado.',
            'error' => 'Lo sentimos, :name no se pudo observar debido a un error.',
        ],
        'generatenewversion' => [
            'success' => 'Se ha generado una nueva versión.',
            'error' => 'Lo sentimos, no se pudo generar una nueva versión debido a un error.',
        ],
        'export' => [
            'success' => 'El archivo se ha exportado.',
            'no_data' => [
                'range' => 'No se encontraron resultados en la fecha especificada',
                'total' => 'No se encontraron resultados',
            ],
        ],
        'order'  => 'Arrastre los elementos en el orden que desee mostrarlos',
        'cant_delete'  => 'No se puede eliminar debido a que está anidado en al menos un proyecto',
        'cant_delete_post'  => 'No se puede eliminar debido a que está anidado en al menos un Post',
    ],
    'order' => [
        'timeline' => [
            'reserve' => 'El cliente registro la reserva.',
            'order_received' => 'Se envió el email sobre: Espera de confirmación de pago de la reserva a :name (:email).',
            'order_paid' => 'Se envió el email sobre: Pago confirmado de la reserva a :name (:email).',
            'order_not_paid' => 'Se envió el email sobre: Pago rechazado de la reserva a :name (:email).',

            'resend_order_received' => 'Se reenvió el email sobre: Espera de confirmación de pago de la reserva a :name (:email).',
            'resend_order_paid' => 'Se reenvió el email sobre: Pago confirmado de la reserva a :name (:email).',
            'resend_order_not_paid' => 'Se reenvió el email sobre: Pago rechazado de la reserva a :name (:email).',
        ],
    ],
    'mail' => [
        'subjects' => [
            'order_received' => ':name, Hemos hecho la reserva de tu Depa',
            'order_paid' => ':name, el pago de la reserva de tu Depa ha sido confirmado',
            'order_not_paid' => ':name, No se pudo completar la reserva de tu Depa',
        ],
    ],
];
