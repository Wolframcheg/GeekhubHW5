<?php
namespace wolfram\Models;

use PDO;
use wolfram\Layer\Manager\ManagerInterface;

class Properties extends ActiveRecord implements ManagerInterface
{

    const FIND_ALL = "SELECT * FROM properties";
    const ORDER = "ORDER BY type";
    const INSERT_STMT = "INSERT INTO properties (name, type) VALUES (:name, :type)";
    const UPDATE_STMT = "UPDATE properties SET name = :name, type = :type WHERE id = :id";
    const DELETE_STMT = "DELETE FROM properties WHERE id = :id";

    const TYPE_POSITIVE = 'positive';
    const TYPE_NEGATIVE = 'negative';

    protected $id;
    protected $name;
    protected $type;

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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }


    public function insert()
    {
        $stmt = self::$pdo->prepare(self::INSERT_STMT);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
        $stmt->execute();
        $this->id = self::$pdo->lastInsertId();
    }

    public function update()
    {
        if (!isset($this->id)) {
            throw new LogicException("Cannot update(): id is not defined");
        }
        $stmt = self::$pdo->prepare(self::UPDATE_STMT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
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
        $stmt = self::$pdo->prepare(self::DELETE_STMT);
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
        $stmt = self::$pdo->prepare(self::FIND_ALL . ' ' . self::ORDER);
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
        $stmt = self::$pdo->prepare(self::FIND_ALL . " WHERE $param = :value");
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? self::load($row) : null;
    }

    public function findAllByQuery($query)
    {
        $stmt = self::$pdo->prepare(self::FIND_ALL . ' ' . $query . self::ORDER);
        $stmt->execute();
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arrayObj = [];
        foreach ($all as $row) {
            array_push($arrayObj, self::load($row));
        }
        return !empty($arrayObj) ? $arrayObj : null;
    }

    public function toArray()
    {
        $arrObj = get_object_vars($this);
        $output['id'] = $arrObj['id'];
        $output['type'] = $arrObj['type'];
        $output['name'] = $arrObj['name'];

        return $output;
    }


    public static function getTypes()
    {
        return [
            self::TYPE_POSITIVE,
            self::TYPE_NEGATIVE
        ];
    }
}