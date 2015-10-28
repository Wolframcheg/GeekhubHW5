<?php
namespace wolfram\Models;

class ActiveRecord extends PdoConnect{

    public static function load(array $resultset) {
        $instance = new static;
        foreach ($resultset as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->$key = $value;
            }
        }
        return $instance;
    }

}