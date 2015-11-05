<?php
namespace wolfram\Models;

use wolfram\Layer\Connector\PdoConnect;

class TablesData
{
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function tableExists($table)
    {
        $tableExists = $this->pdo->query("SHOW TABLES LIKE '{$table}'")->rowCount() > 0;
        return $tableExists;
    }

    public function checkTablesExist($arrTables)
    {
        $errorTableExist = [];
        foreach ($arrTables as $table) {
            if (!$this->tableExists($table)) {
                array_push($errorTableExist, 'Table "' . $table . '" not exist.');
            }
        }
        if (!empty($errorTableExist)) {
            return $errorTableExist;
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
        if ($result !== false) {
            return 'Table "vendor" was created.';
        }
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
            created_at INT NOT NULL,
            updated_at INT NOT NULL,
            PRIMARY KEY (id))
            CHARACTER SET utf8 COLLATE utf8_general_ci
            ";
        $result = $this->pdo->exec($query);
        if ($result !== false) {
            return 'Table "transport" was created.';
        }
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
        if ($result !== false) {
            return 'Table "passport" was created.';
        }
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
        if ($result !== false) {
            return 'Table "properties" was created.';
        }
    }

    public function createTransportProperties()
    {
        $query = "
            CREATE TABLE IF NOT EXISTS transport_properties (
            id INT AUTO_INCREMENT NOT NULL,
            id_transport INT,
            id_properties INT,
            PRIMARY KEY (id))
            CHARACTER SET utf8 COLLATE utf8_general_ci
            ";
        $result = $this->pdo->exec($query);
        if ($result !== false) {
            return 'Table "transport_properties" was created.';
        }
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
        if ($result !== false) {
            return "FK for {$child['table']}.{$child['column']} created.";
        } else {
            return "FK for {$child['table']}.{$child['column']} already exist.";
        }

    }

}