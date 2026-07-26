<?php
class ApiAdapter
{
    private $api_url;
    private $api_token;

    function __construct($API)
    {
        $this->api_url = $API['api_url'];
        $this->api_token = $API['api_token'];
    }

    public function request(string $method, string $comand, array $data)
    {
        $URL = $this->api_url . $comand;
        $postFields = array_merge(
            [
                "token" => $this->api_token
            ],
            $data
        );

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            error_log("Mikrowisp cURL Error: " . $err . " en URL: " . $URL);
            return false;
        }
        return json_decode($response, true);
    }
}
