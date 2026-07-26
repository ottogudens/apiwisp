<?php
class McpService
{
    /**
     * Endpoint compatible con JSON-RPC 2.0 / MCP (Model Context Protocol)
     * Permite a Agentes de IA consultar y ejecutar acciones sobre Mikrowisp y la base local.
     */
    public static function handleRequest($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        $input = file_get_contents('php://input');
        $request = json_decode($input, true);

        if (!$request || !isset($request['jsonrpc']) || $request['jsonrpc'] !== '2.0') {
            echo json_encode([
                'jsonrpc' => '2.0',
                'error' => ['code' => -32600, 'message' => 'Invalid Request. Expected JSON-RPC 2.0 payload.'],
                'id' => $request['id'] ?? null
            ]);
            return;
        }

        $method = $request['method'] ?? '';
        $params = $request['params'] ?? [];
        $id = $request['id'] ?? null;

        $mysqlAdapter = $DATA['mysqlAdapter'];
        $infoDao = new InfoDao($mysqlAdapter);
        $apiAdapter = new ApiAdapter($infoDao->getAPI());
        $clientApi = new ClientApi($apiAdapter);
        $clientDao = new ClientDao($mysqlAdapter);
        $clientFileDao = new ClientFileDao($mysqlAdapter);

        try {
            switch ($method) {
                // Handshake & Metadatos
                case 'initialize':
                    $response = [
                        'protocolVersion' => '2024-11-05',
                        'capabilities' => [
                            'tools' => (object)[],
                            'resources' => (object)[]
                        ],
                        'serverInfo' => [
                            'name' => 'apiwisp-mcp-server',
                            'version' => '1.0.0'
                        ]
                    ];
                    break;

                // Listar Herramientas Disponibles
                case 'tools/list':
                    $response = [
                        'tools' => [
                            [
                                'name' => 'get_client_by_dni',
                                'description' => 'Obtiene los detalles del cliente en Mikrowisp y su estado de facturación por cédula/DNI.',
                                'inputSchema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'dni' => ['type' => 'string', 'description' => 'Cédula o DNI del cliente']
                                    ],
                                    'required' => ['dni']
                                ]
                            ],
                            [
                                'name' => 'get_client_invoices',
                                'description' => 'Obtiene el listado de facturas del cliente en Mikrowisp por su ID.',
                                'inputSchema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'client_id' => ['type' => 'string', 'description' => 'ID de cliente Mikrowisp']
                                    ],
                                    'required' => ['client_id']
                                ]
                            ],
                            [
                                'name' => 'list_local_clients',
                                'description' => 'Lista todos los clientes registrados localmente en la base de datos de API WISP.',
                                'inputSchema' => [
                                    'type' => 'object',
                                    'properties' => []
                                ]
                            ],
                            [
                                'name' => 'get_client_files',
                                'description' => 'Obtiene los documentos y archivos adjuntos del expediente de un cliente.',
                                'inputSchema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'client_id' => ['type' => 'string', 'description' => 'ID local del cliente']
                                    ],
                                    'required' => ['client_id']
                                ]
                            ]
                        ]
                    ];
                    break;

                // Ejecución de Herramientas
                case 'tools/call':
                    $toolName = $params['name'] ?? '';
                    $args = $params['arguments'] ?? [];

                    if ($toolName === 'get_client_by_dni') {
                        $client = $clientApi->selectByDni($args['dni'] ?? '');
                        if (!$client) {
                            $content = [['type' => 'text', 'text' => 'Cliente no encontrado en Mikrowisp.']];
                        } else {
                            $content = [['type' => 'text', 'text' => json_encode($client, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)]];
                        }
                    } elseif ($toolName === 'get_client_invoices') {
                        $invoices = $clientApi->getInvoices($args['client_id'] ?? '');
                        $content = [['type' => 'text', 'text' => json_encode($invoices, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)]];
                    } elseif ($toolName === 'list_local_clients') {
                        $clients = $clientDao->select();
                        $content = [['type' => 'text', 'text' => json_encode($clients, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)]];
                    } elseif ($toolName === 'get_client_files') {
                        $files = $clientFileDao->select();
                        $filtered = array_filter($files ?: [], fn($f) => (string)($f['client_id'] ?? '') === (string)($args['client_id'] ?? ''));
                        $content = [['type' => 'text', 'text' => json_encode(array_values($filtered), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)]];
                    } else {
                        throw new Exception("Herramienta no reconocida: {$toolName}");
                    }

                    $response = ['content' => $content];
                    break;

                default:
                    echo json_encode([
                        'jsonrpc' => '2.0',
                        'error' => ['code' => -32601, 'message' => "Method not found: {$method}"],
                        'id' => $id
                    ]);
                    return;
            }

            echo json_encode([
                'jsonrpc' => '2.0',
                'result' => $response,
                'id' => $id
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'jsonrpc' => '2.0',
                'error' => ['code' => -32603, 'message' => $e->getMessage()],
                'id' => $id
            ]);
        }
    }
}
