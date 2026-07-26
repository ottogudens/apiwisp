<?php
$_TEMPLATE_PANEL_PATH = './src/templates/panel.pages/';
$radapter = new RAdapter($router, $_TEMPLATE_PANEL_PATH, $_ENV['HTTP_DOMAIN']);

// LOGIN & LOGOUT
$radapter->getHTML('/panel/login', 'login', fn () => middlewareSessionLogout());

// HOME / DASHBOARD
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
    ];
});

// CLIENTES MIKROWISP
$radapter->getHTML('/panel/clientes', 'client', fn () => middlewareSessionLogin(), function ($DATA) {
    $mysqlAdapter = $DATA['mysqlAdapter'];
    $clientDao = new ClientDao($mysqlAdapter);
    $clients = $clientDao->select();

    return [
        'clientes' => $clients ?: []
    ];
});

// EXPEDIENTES / ARCHIVOS CLIENTES
$radapter->getHTML('/panel/expedientes', 'client_file', fn () => middlewareSessionLogin(), function ($DATA) {
    $mysqlAdapter = $DATA['mysqlAdapter'];
    $clientDao = new ClientDao($mysqlAdapter);
    $clientFileDao = new ClientFileDao($mysqlAdapter);

    $clients = $clientDao->select();
    $archivos = $clientFileDao->select();

    return [
        'clientes' => $clients ?: [],
        'archivos' => $archivos ?: []
    ];
});

// CONFIGURACION API & SISTEMA
$radapter->getHTML('/panel/info', 'info', fn () => middlewareSessionLogin(), function ($DATA) {
    $mysqlAdapter = $DATA['mysqlAdapter'];
    $infoDao = new InfoDao($mysqlAdapter);
    $info = $infoDao->select();
    return [
        'info' => $info ?: []
    ];
});

// USUARIOS
$radapter->getHTML('/panel/user', 'user', fn () => middlewareSessionLogin(), function ($DATA) {
    $mysqlAdapter = $DATA['mysqlAdapter'];
    $userDao = new UserDao($mysqlAdapter);
    $users = $userDao->select();
    return [
        'users' => $users ?: []
    ];
});
