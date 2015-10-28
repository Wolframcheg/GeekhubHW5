<?php

namespace wolfram\Layer\Connector;

/**
 * Interface ConnectorInterface
 * @package Layer\Connector
 */
interface ConnectorInterface
{
    /**
     * @return mixed
     */
    public function connect();

    /**
     * @param $db
     * @return mixed
     */
    public function connectClose();
}