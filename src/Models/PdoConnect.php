<?php
namespace wolfram\Models;

use wolfram\Layer\Connector\ConnectorInterface;
use PDO;

class PdoConnect implements ConnectorInterface{

    protected $config;
    protected $pdo;

    public function __construct()
    {
        $this->config = array_merge(
            require(__DIR__ . '/../../config/config.php'),
            require(__DIR__ . '/../../config/config-local.php')
        );
    }

    public function connect()
    {
        $this->pdo = new PDO("mysql:host={$this->config['host']}", $this->config['username'], $this->config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connectToDb();
    }

    protected function connectToDb()
    {
        $dbname = "`".str_replace("`","``",$this->config['dbname'])."`";
        $this->pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");
        $this->pdo->query("use $dbname");
    }

    public function tableExists($table)
    {
        $tableExists = $this->pdo->query("SHOW TABLES LIKE '{$table}'")->rowCount() > 0;
        return $tableExists;
    }


    public function connectClose()
    {
        // TODO: Implement connectClose() method.
    }
}