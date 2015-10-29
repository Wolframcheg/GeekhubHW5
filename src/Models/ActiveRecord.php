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

}