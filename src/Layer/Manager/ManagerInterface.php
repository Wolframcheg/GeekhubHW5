<?php

namespace wolfram\Layer\Manager;

/**
 * Interface ManagerInterface
 * @package Layer\Manager
 */
interface ManagerInterface
{
    /**
     * Insert new entity data to the DB
     * @param mixed $entity
     * @return mixed
     */
    public function insert();

    /**
     * Update exist entity data in the DB
     * @param $entity
     * @return mixed
     */
    public function update();

    /**
     * Delete entity data from the DB
     * @param $entity
     * @return mixed
     */
    public function remove();

    /**
     * Search entity data in the DB by Id
     * @param $entityName
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Search all entity data in the DB
     * @param $entityName
     * @return array
     */
    public function findAll();

    /**
     * Search all entity data in the DB like $criteria rules
     * @param $entityName
     * @param array $criteria
     * @return mixed
     */
    public function findBy($criteria = []);
}