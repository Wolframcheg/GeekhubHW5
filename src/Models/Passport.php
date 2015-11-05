<?php
namespace wolfram\Models;

use PDO;
use wolfram\Entity\EntityTrait;
use wolfram\Layer\Manager\ManagerInterface;

class Passport extends ActiveRecord implements ManagerInterface
{

    const FIND_ALL = "SELECT * FROM passport";
    const INSERT_STMT = "INSERT INTO passport (manufactured_at, id_transport, personal_number, price)
                        VALUES (:manufactured_at, :id_transport, :personal_number, :price)";
    const UPDATE_STMT = "UPDATE passport SET manufactured_at = :manufactured_at, id_transport = :id_transport,
                        personal_number = :personal_number,price = :price  WHERE id = :id";
    const DELETE_STMT = "DELETE FROM passport WHERE id = :id";

    protected $id;
    protected $manufactured_at;
    protected $id_transport;
    protected $personal_number;
    protected $price;


    public function getId()
    {
        return $this->id;
    }

    public function getManufacturedAt()
    {
        return $this->manufactured_at;
    }

    public function setManufacturedAt($value)
    {
        $this->manufactured_at = $value;
    }

    public function getIdTransport()
    {
        return $this->id_transport;
    }

    public function setIdTransport($value)
    {
        $this->id_transport = $value;
    }

    public function getPersonalNumber()
    {
        return $this->personal_number;
    }

    public function setPrice($value)
    {
        $this->price = $value;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function insert()
    {
        $time = time();
        $stmt = self::$pdo->prepare(self::INSERT_STMT);
        $stmt->bindParam(':manufactured_at', $this->manufactured_at, PDO::PARAM_STR);
        $stmt->bindParam(':id_transport', $this->id_transport, PDO::PARAM_STR);
        $stmt->bindParam(':personal_number', $this->personal_number, PDO::PARAM_INT);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
        $stmt->execute();
        $this->id = self::$pdo->lastInsertId();
    }

    public function update()
    {
        if (!isset($this->id)) {
            throw new LogicException("Cannot update(): id is not defined");
        }
        $time = time();
        $stmt = self::$pdo->prepare(self::UPDATE_STMT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':manufactured_at', $this->manufactured_at, PDO::PARAM_STR);
        $stmt->bindParam(':id_transport', $this->id_transport, PDO::PARAM_STR);
        $stmt->bindParam(':personal_number', $this->personal_number, PDO::PARAM_INT);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
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
        $stmt = self::$pdo->prepare(self::FIND_ALL);
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


}