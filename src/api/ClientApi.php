<?php
class ClientApi
{
    // LISTA DE COMANDOS
    const COMANDO_GET_CLIENTS_DETAILS = 'GetClientsDetails';
    const COMANDO_GET_INVOICES = 'GetInvoices';
    const COMANDO_GET_TICKETS = 'GetTickets';
    const COMANDO_SET_STATUS = 'SetClientStatus';

    private ApiAdapter $apiAdapter;
    public function __construct(ApiAdapter $apiAdapter)
    {
        $this->apiAdapter = $apiAdapter;
    }

    public function selectById(string $client_id)
    {
        $result = ($this->apiAdapter)->request('POST', self::COMANDO_GET_CLIENTS_DETAILS, [
            "idcliente" => $client_id
        ]);

        if (!$result || empty($result['datos'])) return false;
        return $this->schematize($result['datos'][0]);
    }

    public function selectByDni(string $dni)
    {
        $result = ($this->apiAdapter)->request('POST', self::COMANDO_GET_CLIENTS_DETAILS, [
            "cedula" => $dni
        ]);

        if (!$result || empty($result['datos'])) return false;
        return $this->schematize($result['datos'][0]);
    }

    public function getInvoices(string $client_id)
    {
        $result = ($this->apiAdapter)->request('POST', self::COMANDO_GET_INVOICES, [
            "idcliente" => $client_id
        ]);
        return $result ? ($result['datos'] ?? []) : [];
    }

    public function getTickets(string $client_id)
    {
        $result = ($this->apiAdapter)->request('POST', self::COMANDO_GET_TICKETS, [
            "idcliente" => $client_id
        ]);
        return $result ? ($result['datos'] ?? []) : [];
    }

    private function schematize($row)
    {
        // esto es un contrato de datos para que el front no se rompa
        // en el momento que la api cambie de estructura
        // se debe cambiar este contrato

        $servicios = $row['servicios'][0];
        $facturacion = $row['facturacion'];
        return [
            "id" => $row['id'],
            "nombre" => $row['nombre'],
            "estado" => $row['estado'],
            "correo" => $row['correo'],
            "telefono" => $row['telefono'],
            "movil" => $row['movil'],
            "cedula" => $row['cedula'],
            "pasarela" => $row['pasarela'],
            "codigo" => $row['codigo'],
            "direccion_principal" => $row['direccion_principal'],
            "mantenimiento" => $row['mantenimiento'],
            "fecha_suspendido" => $row['fecha_suspendido'],
            "servicios" => [
                [
                    "id" => $servicios['id'],
                    "idperfil" => $servicios['idperfil'],
                    "nodo" => $servicios['nodo'],
                    "costo" => $servicios['costo'],
                    "ipap" => $servicios['ipap'],
                    "mac" => $servicios['mac'],
                    "ip" => $servicios['ip'],
                    "instalado" => $servicios['instalado'],
                    "pppuser" => $servicios['pppuser'],
                    "ppppass" => $servicios['ppppass'],
                    "emisor" => $servicios['emisor'],
                    "tiposervicio" => $servicios['tiposervicio'],
                    "status_user" => $servicios['status_user'],
                    "coordenadas" => $servicios['coordenadas'],
                    "direccion" => $servicios['direccion'],
                    "snmp_comunidad" => $servicios['snmp_comunidad'],
                    "firewall_state" => $servicios['firewall_state'],
                    "smartolt" => $servicios['smartolt'],
                    "limitado" => $servicios['limitado'],
                    "ppp_routes" => $servicios['ppp_routes'],
                    "ppp_localaddress" => $servicios['ppp_localaddress'],
                    "idnap" => $servicios['idnap'],
                    "portnap" => $servicios['portnap'],
                    "onu_sn" => $servicios['onu_sn'],
                    "onu_ssid_wifi" => $servicios['onu_ssid_wifi'],
                    "onu_password_wifi" => $servicios['onu_password_wifi'],
                    "personalizados" => $servicios['personalizados'],
                    "smartolt_catv" => $servicios['smartolt_catv'],
                    "ipv6" => $servicios['ipv6'],
                    "ipv6_duid" => $servicios['ipv6_duid'],
                    "perfil" => $servicios['perfil']
                ]
            ],
            "facturacion" => [
                "facturas_nopagadas" => $facturacion['facturas_nopagadas'],
                "total_facturas" => $facturacion['total_facturas']
            ]
        ];
    }
}
