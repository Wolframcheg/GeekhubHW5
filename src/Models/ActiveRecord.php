<?php
namespace wolfram\Models;

use wolfram\Layer\Connector\PdoConnect;
use PDO;

class ActiveRecord
{


    protected static $pdo = null;

    public static function setPDO($pdo)
    {
        self::$pdo = $pdo;
    }

    public static function load(array $resultset)
    {
        $instance = new static;
        foreach ($resultset as $key => $value) {
            if (property_exists($instance, $key) && !empty($value)) {
                $instance->$key = $value;
            }
        }
        return $instance;
    }

    public function fromArray($array)
    {
        return self::load($array);
    }

    public function hasOne($class, $link)
    {
        $param = key($link);
        $param_for_value = $link[$param];
        $model = new $class();
        $model = $model->findBy([$param => $this->$param_for_value]);
        return $model;
    }

    public function hasMany($class, $link)
    {
        $param = key($link);
        $param_for_value = $link[$param];
        $model = new $class();
        $models = $model->findAllBy([$param => $this->$param_for_value]);
        return $models;
    }

    public function hasManyViaTable($class, $link, $endClass, $endLink)
    {
        $param = key($link);
        $param_for_value = $link[$param];
        $model = new $class();
        $models = $model->findAllBy([$param => $this->$param_for_value]);

        if ($models) {
            $param = key($endLink);
            $param_for_array = $endLink[$param];
            $values = '';
            foreach ($models as $key => $item) {
                if ($key) {
                    $values .= ',' . $item->get($param_for_array);
                } else {
                    $values .= $item->get($param_for_array);
                }
            }
            $query = "WHERE {$param} IN ({$values})";

            $endModels = new $endClass();
            $endModels = $endModels->findAllByQuery($query);
            return $endModels;
        }

        return $models;
    }


}