<?php
class InfoService
{
    public static function select($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $infoDao = new InfoDao($adapter);
        $info = $infoDao->select();
        $result = [
            'status' => 'success',
            'message' => 'Información obtenida correctamente',
            'response' => true,
            'data' => $info
        ];
        echo json_encode($result);
    }

    public static function update($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $result = [
            'status' => 'error',
            'message' => 'Faltan datos para actualizar la información',
            'response' => false,
            'data' => null
        ];
        if (isset($_POST['info_nombre'], $_POST['info_mkw_api_url'], $_POST['info_mkw_api_token'])) {
            $adapter = $DATA['mysqlAdapter'];
            $infoDao = new InfoDao($adapter);
            $info_nombre = $_POST['info_nombre'];
            $info_mkw_api_url = $_POST['info_mkw_api_url'];
            $info_mkw_api_token = $_POST['info_mkw_api_token'];

            $res = $infoDao->update($info_nombre, $info_mkw_api_url, $info_mkw_api_token);
            if (!$res) {
                $result['message'] = 'Error al actualizar la información en la base de datos';
                echo json_encode($result);
                return;
            }

            $result['status'] = 'success';
            $result['message'] = 'Información de Mikrowisp actualizada correctamente';
            $result['response'] = true;
        }
        echo json_encode($result);
    }
}
