<?php
namespace wolfram\Models;

use PDO;
use wolfram\Layer\Manager\ManagerInterface;

class Vendor extends ActiveRecord implements ManagerInterface
{

    const FIND_ALL = "SELECT * FROM vendor";
    const INSERT_STMT = "INSERT INTO vendor (name) VALUES (:name)";
    const UPDATE_STMT = "UPDATE vendor SET name = :name WHERE id = :id";
    const DELETE_STMT = "DELETE FROM vendor WHERE id = :id";

    protected $id;
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getRelateTransports()
    {
        return $this->hasMany('wolfram\Models\Transport', ['id_vendor' => 'id']);
    }

    public function insert()
    {
        $stmt = $this->pdo->prepare(self::INSERT_STMT);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
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
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function save()
    {
        if (empty($this->id)) {
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
}