<?php


class InfoDao
{
    private MysqlAdapter $mysqlAdapter;
    public function __construct(MysqlAdapter $mysqlAdapter)
    {
        $this->mysqlAdapter = $mysqlAdapter;
    }

    public function select()
    {
        $resultset = ($this->mysqlAdapter)->query("SELECT * FROM info");
        $row = mysqli_fetch_assoc($resultset);
        return $this->schematize($row);
    }

    public function getAPI()
    {
        $resultset = ($this->mysqlAdapter)->query("SELECT * FROM info");
        $row = mysqli_fetch_assoc($resultset);
        return [
            'api_url' => $row['info_mkw_api_url'],
            'api_token' => $row['info_mkw_api_token']
        ];
    }

    public function update(
        string $info_nombre,
        string $info_mkw_api_url,
        string $info_mkw_api_token
    ): bool {
        $info_nombre = addslashes($info_nombre);
        $info_mkw_api_url = addslashes($info_mkw_api_url);
        $info_mkw_api_token = addslashes($info_mkw_api_token);
        $last = date("Y-m-d H:i:s");
        $resultset = ($this->mysqlAdapter)->query("
            UPDATE info SET     
                info_nombre = '$info_nombre', 
                info_mkw_api_url = '$info_mkw_api_url', 
                info_mkw_api_token = '$info_mkw_api_token',
                info_last = '$last'
            WHERE info_id = 1
            ");
        return (bool)$resultset;
    }

    public function schematize($row)
    {
        return $row;
    }
}
