<?php
$_TEMPLATE_SERVICES_PATH = './src/services/';
$radapter = new RAdapter($router, $_TEMPLATE_SERVICES_PATH, $_ENV['HTTP_DOMAIN']);

// CONFIGURATION
$radapter->getHTML('/services/configuration', 'configuration');

// INFO
$radapter->post('/services/info/select', fn (...$args) => InfoService::select(...$args));
$radapter->post('/services/info/update', fn (...$args) => InfoService::update(...$args));

// USER
$radapter->post('/services/user/login', fn (...$args) => UserService::login(...$args));
$radapter->post('/services/user/logout', fn () => UserService::logout());
$radapter->post('/services/user/select', fn (...$args) => UserService::select(...$args));
$radapter->post('/services/user/insert', fn (...$args) => UserService::insert(...$args));
$radapter->post('/services/user/update', fn (...$args) => UserService::update(...$args));
$radapter->post('/services/user/delete', fn (...$args) => UserService::delete(...$args));

// CLIENT 
$radapter->post('/services/client/select_by_dni', fn (...$args) => ClientService::selectByDni(...$args));
$radapter->post('/services/client/select', fn (...$args) => ClientService::select(...$args));
$radapter->post('/services/client/insert', fn (...$args) => ClientService::insert(...$args));
$radapter->post('/services/client/update', fn (...$args) => ClientService::update(...$args));
$radapter->post('/services/client/delete', fn (...$args) => ClientService::delete(...$args));

// CLIENT FILE
$radapter->post('/services/client_file/select', fn (...$args) => ClientFileService::select(...$args));
$radapter->post('/services/client_file/insert', fn (...$args) => ClientFileService::insert(...$args));
$radapter->post('/services/client_file/update', fn (...$args) => ClientFileService::update(...$args));
$radapter->post('/services/client_file/delete', fn (...$args) => ClientFileService::delete(...$args));

// MCP SERVER ENDPOINT
$radapter->post('/services/mcp', fn (...$args) => McpService::handleRequest(...$args));

