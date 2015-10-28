<?php
namespace wolfram\Controllers;

use wolfram\Models\TablesData;

class CreateTablesController
{

    public function actionIndex()
    {
        $tablesData = new TablesData();
        $tablesData->createVendor();
        $tablesData->createTransport();
        $tablesData->createFK(
            ['table' => 'transport', 'column' => 'id_vendor'],
            ['table' => 'vendor', 'column' => 'id']
        );
        $tablesData->createPassport();
        $tablesData->createFK(
            ['table' => 'passport', 'column' => 'id_transport'],
            ['table' => 'transport', 'column' => 'id']
        );
        $tablesData->createProperties();
        $tablesData->createTransportProperties();
        $tablesData->createFK(
            ['table' => 'transport_properties', 'column' => 'id_transport'],
            ['table' => 'transport', 'column' => 'id']
        );
        $tablesData->createFK(
            ['table' => 'transport_properties', 'column' => 'id_properties'],
            ['table' => 'properties', 'column' => 'id']
        );
        echo '<a href="/" >Main page</a>';


    }


}