<?php

$vars = $_ENV['APP_ENV'];

$params = ['general' => [

        'ambiente' =>$_ENV['APP_ENV']

    ]
];
switch ($vars) {
    case'local':
        $params['services'] = [
            'url_vinculacion' => 'http://co-portal-compra.com/',
            'url_recompra' => 'http://co-portal-recompra.com/',
            'url' => 'http://co-portal-comercial.com/',
        ];
        $params['credentials'] = [
            'ws_x_api_key' => '',
            'audience' => '',
            'client_id' => '',
            'client_secret' => '',
        ];
        $params['emails'] = [
            'ventas_co'=> '',
        ];
        break;

}

return $params;
