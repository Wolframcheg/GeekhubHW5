<?php
namespace wolfram\Models;

class ActiveRecord extends PdoConnect{

    public static function load(array $resultset) {
        $instance = new static;
        foreach ($resultset as $key => $value) {
            if (property_exists($instance, $key) && !empty($value)) {
                $instance->$key = $value;
            }
        }
        return $instance;
    }
    
    public function fromArray($array){
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

}