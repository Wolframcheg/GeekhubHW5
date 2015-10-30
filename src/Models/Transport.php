<?php
namespace wolfram\Models;

use PDO;
use wolfram\Entity\EntityTrait;
use wolfram\Layer\Manager\ManagerInterface;

class Transport extends ActiveRecord implements ManagerInterface
{
    use EntityTrait;

    const FIND_ALL = "SELECT * FROM transport";
    const INSERT_STMT = "INSERT INTO transport (model, max_speed, id_vendor, number_wheel, created_at,
                        updated_at) VALUES (:model, :max_speed, :id_vendor, :number_wheel, :created_at,
                        :updated_at)";
    const UPDATE_STMT = "UPDATE transport SET model = :model, max_speed = :max_speed, id_vendor = :id_vendor,
                         number_wheel = :number_wheel, updated_at = :updated_at  WHERE id = :id";
    const DELETE_STMT = "DELETE FROM transport WHERE id = :id";

    protected $id;
    protected $model;
    protected $max_speed;
    protected $id_vendor;
    protected $number_wheel;


    public function getId()
    {
        return $this->id;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($value)
    {
        $this->model = $value;
    }

    public function getMaxSpeed()
    {
        return $this->max_speed;
    }

    public function setMaxSpeed($value)
    {
        $this->max_speed = $value;
    }

    public function getIdVendor()
    {
        return $this->id_vendor;
    }

    public function setIdVendor($value)
    {
        $this->id_vendor = $value;
    }

    public function getNumberWheel()
    {
        return $this->number_wheel;
    }

    public function setNumberWheel($value)
    {
        $this->number_wheel = $value;
    }

    public function getRelateVendor()
    {
        return $this->hasOne('wolfram\Models\Vendor', ['id' => 'id_vendor']);
    }

    public function getVendor()
    {
        $relateModel = $this->getRelateVendor();
        return $relateModel->getName();
    }

    public function getRelatePassport()
    {
        return $this->hasOne('wolfram\Models\Passport', ['id_transport' => 'id']);
    }

    public function getRelateProperties()
    {
        return $this->hasManyViaTable('wolfram\Models\TransportProperties', ['id_transport' => 'id'], 'wolfram\Models\Properties', ['id' => 'id_properties']);
    }

    public function insert()
    {
        $time = time();
        $stmt = $this->pdo->prepare(self::INSERT_STMT);
        $stmt->bindParam(':model', $this->model, PDO::PARAM_STR);
        $stmt->bindParam(':max_speed', $this->max_speed, PDO::PARAM_STR);
        $stmt->bindParam(':id_vendor', $this->id_vendor, PDO::PARAM_INT);
        $stmt->bindParam(':number_wheel', $this->number_wheel, PDO::PARAM_INT);
        $stmt->bindParam(':created_at', $time, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $time, PDO::PARAM_INT);
        $stmt->execute();
        $this->id = $this->pdo->lastInsertId();
    }

    public function update()
    {
        if (!isset($this->id)) {
            throw new LogicException("Cannot update(): id is not defined");
        }
        $time = time();
        $stmt = $this->pdo->prepare(self::UPDATE_STMT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':model', $this->model, PDO::PARAM_STR);
        $stmt->bindParam(':max_speed', $this->max_speed, PDO::PARAM_STR);
        $stmt->bindParam(':id_vendor', $this->id_vendor, PDO::PARAM_INT);
        $stmt->bindParam(':number_wheel', $this->number_wheel, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $time, PDO::PARAM_INT);
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