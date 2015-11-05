<?php
namespace wolfram\Layer\Connector;

use wolfram\Layer\Connector\ConnectorInterface;
use PDO;

class SinglePdoConnect implements ConnectorInterface
{
    private static $instance = NULL;
    private function __construct(){}
    private function __clone(){}

    public static function getInstance(){
        if(!self::$instance){
            $config = array_merge(
                require(__DIR__ . '/../../../config/config.php'),
                is_file(__DIR__ . '/../../../config/config-local.php') ?
                    require(__DIR__ . '/../../../config/config-local.php') : []

            );

            self::$instance = new PDO("mysql:host={$config['host']}",$config['username'],
                $config['password']);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_SILENT);//PDO::ERRMODE_EXCEPTION ERRMODE_SILENT

            $dbname = "`" . str_replace("`", "``",$config['dbname']) . "`";
            self::$instance->query("CREATE DATABASE IF NOT EXISTS $dbname");
            self::$instance->query("use $dbname");
        }
        return self::$instance;
    }

    public function connect(){}


    public function connectClose()
    {
        $this->pdo = null;
    }

    public function __destruct()
    {
        $this->connectClose();
    }
}