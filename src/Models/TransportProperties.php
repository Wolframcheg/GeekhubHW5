<?php
namespace wolfram\Models;

use PDO;
use wolfram\Layer\Manager\ManagerInterface;

class TransportProperties extends ActiveRecord implements ManagerInterface
{

    const FIND_ALL = "SELECT * FROM transport_properties";
    const INSERT_STMT = "INSERT INTO transport_properties (id_transport, id_properties) VALUES (:id_transport, :id_properties)";
    const UPDATE_STMT = "UPDATE transport_properties SET id_transport = :id_transport, id_properties = :id_properties WHERE id = :id";
    const DELETE_STMT = "DELETE FROM transport_properties WHERE id = :id";

    protected $id;
    protected $id_transport;
    protected $id_properties;

    public function getId()
    {
        return $this->id;
    }

    public function get($param)
    {
        return $this->$param;
    }

    public function getIdTransport()
    {
        return $this->id_transport;
    }

    public function setIdTransport($value)
    {
        $this->id_transport = $value;
    }

    public function getIdProperties()
    {
        return $this->id_properties;
    }

    public function setIdProperties($value)
    {
        $this->id_properties = $value;
    }


    public function insert()
    {
        $stmt = $this->pdo->prepare(self::INSERT_STMT);
        $stmt->bindParam(':id_transport', $this->id_transport, PDO::PARAM_INT);
        $stmt->bindParam(':id_properties', $this->id_properties, PDO::PARAM_INT);
        $stmt->execute();
        $this->id = $this->pdo->lastInsertId();
    }

    public function update()
    {
        if (!isset($this->id)) {
            throw new LogicException("Cannot update(): id is not defined");
        }
        $stmt = $this->pdo->prepare(self::UPDATE_STMT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':id_transport', $this->id_transport, PDO::PARAM_INT);
        $stmt->bindParam(':id_properties', $this->id_properties, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function save()
    {
        if (is_null($this->id) || empty($this->id)) {
            $this->insert();
        }
        $this->update();
    }

    public function remove()
    {
        if (!isset($this->id)) {
            throw new LogicException("Cannot delete(): id is not defined");
        }
        $stmt = $this->pdo->prepare(self::DELETE_STMT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $this->id = null;
    }

    public function find($id)
    {
        return $this->findBy(['id' => $id]);
    }

    public function findAll()
    {
        $stmt = $this->pdo->prepare(self::FIND_ALL);
        $stmt->execute();
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arrayObj = [];
        foreach ($all as $row) {
            array_push($arrayObj, self::load($row));
        }
        return !empty($arrayObj) ? $arrayObj : null;
    }

    public function findBy($criteria = [])
    {
        $param = key($criteria);
        $value = $criteria[$param];
        $stmt = $this->pdo->prepare(self::FIND_ALL . " WHERE $param = :value");
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? self::load($row) : null;
    }

    public function findAllBy($criteria = [])
    {
        $param = key($criteria);
        $value = $criteria[$param];
        $stmt = $this->pdo->prepare(self::FIND_ALL . " WHERE $param = :value");
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arrayObj = [];
        foreach ($all as $row) {
            array_push($arrayObj, self::load($row));
        }
        return !empty($arrayObj) ? $arrayObj : null;
    }

    public function findOneByQuery($query)
    {
        $stmt = $this->pdo->prepare(self::FIND_ALL . ' ' . $query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? self::load($row) : null;
    }

    public static function getTypes()
    {
        return [
            self::TYPE_POSITIVE,
            self::TYPE_NEGATIVE
        ];
    }
}