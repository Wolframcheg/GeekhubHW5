<?php

namespace wolfram\Entity;

/**
 * Class EntityTrait
 * @package Entity
 */
trait EntityTrait
{

    protected $created_at;


    protected $updated_at;


    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

}