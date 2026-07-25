<?php
$_TEMPLATE_PANEL_PATH = './src/templates/panel.pages/';
$radapter = new RAdapter($router, $_TEMPLATE_PANEL_PATH, $_ENV['HTTP_DOMAIN']);

// HOME
$radapter->getHTML('/panel/login', 'login', fn () => middlewareSessionLogout());

$radapter->getHTML('/panel', 'home', fn () => middlewareSessionLogin(), function ($DATA) {
    $mysqlAdapter = $DATA['mysqlAdapter'];
    $clientDao = new ClientDao($mysqlAdapter);
    $userDao = new UserDao($mysqlAdapter);
    $infoDao = new InfoDao($mysqlAdapter);

    $info = $infoDao->select();
    $clients = $clientDao->select();
    $users = $userDao->select();

    return [
        'info' => $info ?: [],
        'clientes_total' => is_array($clients) ? count($clients) : 0,
        'user_total' => is_array($users) ? count($users) : 0,
        'slider_total' => 0,
        'social_total' => 0,
        'horas_total' => 0,
        'servicios_total' => 0,
        'citas_total' => 0,
        'mensajes_total' => 0,
    ];
});
