<?php
namespace wolfram\Models;

use wolfram\Layer\Connector\ConnectorInterface;
use PDO;

class TablesData extends PdoConnect{

    public function tableExists($table)
    {
        $tableExists = $this->pdo->query("SHOW TABLES LIKE '{$table}'")->rowCount() > 0;
        return $tableExists;
    }

    public function checkTablesExist($arrTables)
    {
        $errorTableExist = [];
        foreach ($arrTables as $table){
            if(!$this->tableExists($table)){
                array_push($errorTableExist,'Table "' . $table .'" not exist.</a><br>');
            }
        }
        if(!empty($errorTableExist)){
            foreach ($errorTableExist as $item){
                echo $item;
            }
            return false;
        }
        return true;
    }

    public function createVendor()
    {
        $query = "
            CREATE TABLE IF NOT EXISTS vendor (
            id INT AUTO_INCREMENT NOT NULL,
            name varchar(200) NOT NULL,
            PRIMARY KEY (id))
            CHARACTER SET utf8 COLLATE utf8_general_ci
            ";
        $result = $this->pdo->exec($query);
        if ($result !== false)
            echo 'Table "vendor" was created.<br>';
    }

    public function createTransport()
    {
        $query = "
            CREATE TABLE IF NOT EXISTS transport (
            id INT AUTO_INCREMENT NOT NULL,
            model varchar(200) NOT NULL,
            max_speed varchar(200),
            id_vendor INT,
            number_wheel SMALLINT,
            type_by_number_wheel varchar(30),
            status enum('active','deleted') NOT NULL DEFAULT 'active',
            created_at INT NOT NULL,
            updated_at INT NOT NULL,
            deleted_at INT,
            PRIMARY KEY (id))
            CHARACTER SET utf8 COLLATE utf8_general_ci
            ";
        $result = $this->pdo->exec($query);
        if ($result !== false)
            echo 'Table "transport" was created.<br>';
    }

    public function createPassport()
    {
        $query = "
            CREATE TABLE IF NOT EXISTS passport (
            id INT AUTO_INCREMENT NOT NULL,
            manufactured_at INT,
            id_transport INT,
            personal_number varchar(100),
            price INT,
            PRIMARY KEY (id))
            CHARACTER SET utf8 COLLATE utf8_general_ci
            ";
        $result = $this->pdo->exec($query);
        if ($result !== false)
            echo 'Table "passport" was created.<br>';
    }

    public function createProperties()
    {
        $query = "
            CREATE TABLE IF NOT EXISTS properties (
            id INT AUTO_INCREMENT NOT NULL,
            name varchar(200) NOT NULL,
            type enum('positive','negative') NOT NULL DEFAULT 'positive',
            PRIMARY KEY (id))
            CHARACTER SET utf8 COLLATE utf8_general_ci
            ";
        $result = $this->pdo->exec($query);
        if ($result !== false)
            echo 'Table "properties" was created.<br>';
    }

    public function createTransportProperties()
    {
        $query = "
            CREATE TABLE IF NOT EXISTS transport_properties (
            id_transport INT,
            id_properties INT)
            CHARACTER SET utf8 COLLATE utf8_general_ci
            ";
        $result = $this->pdo->exec($query);
        if ($result !== false)
            echo 'Table "transport_properties" was created.<br>';
    }

    public function createFK($child, $parent)
    {
        $query = "
            ALTER TABLE {$child['table']}
            ADD CONSTRAINT fk_{$child['table']}_{$parent['table']}
            FOREIGN KEY ({$child['column']})
            REFERENCES {$parent['table']}({$parent['column']})
            ON DELETE CASCADE
        ";
        $result = $this->pdo->exec($query);
        if ($result !== false)
            echo "FK for {$child['table']}.{$child['column']} created.<br>";
        else echo "FK for {$child['table']}.{$child['column']} already exist.<br>";

    }

}