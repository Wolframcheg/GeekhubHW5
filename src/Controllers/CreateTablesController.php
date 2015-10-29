<?php
namespace wolfram\Controllers;

use wolfram\Models\TablesData;

class CreateTablesController extends BaseController
{

    public function actionIndex()
    {
        $messages = [];
        $tablesData = new TablesData();
        $messages[] = $tablesData->createVendor();
        $messages[] = $tablesData->createTransport();
        $messages[] = $tablesData->createFK(
            ['table' => 'transport', 'column' => 'id_vendor'],
            ['table' => 'vendor', 'column' => 'id']
        );
        $messages[] = $tablesData->createPassport();
        $messages[] = $tablesData->createFK(
            ['table' => 'passport', 'column' => 'id_transport'],
            ['table' => 'transport', 'column' => 'id']
        );
        $messages[] = $tablesData->createProperties();
        $messages[] = $tablesData->createTransportProperties();
        $messages[] = $tablesData->createFK(
            ['table' => 'transport_properties', 'column' => 'id_transport'],
            ['table' => 'transport', 'column' => 'id']
        );
        $messages[] = $tablesData->createFK(
            ['table' => 'transport_properties', 'column' => 'id_properties'],
            ['table' => 'properties', 'column' => 'id']
        );

        $template = $this->twig->loadTemplate('create-tables/index.tpl');

        echo $template->render(array(
            'messages' => $messages,
        ));

    }


}