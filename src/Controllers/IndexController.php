<?php
namespace wolfram\Controllers;

use wolfram\Layer\Connector\SinglePdoConnect;
use wolfram\Models\Properties;
use wolfram\Models\TablesData;
use wolfram\Models\Transport;
use wolfram\Models\Vendor;


class IndexController extends BaseController
{

    public function actionIndex()
    {
        $connect = SinglePdoConnect::getInstance();
        $tablesData = new TablesData($connect);
        $exist = $tablesData->checkTablesExist([
            'transport',
            'passport',
            'vendor',
            'properties',
            'transport_properties'
        ]);
        if (is_array($exist)) {
            $template = $this->twig->loadTemplate('index/tables_not_exist.tpl');
            echo $template->render(array(
                'messages' => $exist,
            ));
            return false;
        }

        $vendors = new Vendor();
        $vendors = $vendors->findAll();
        $template = $this->twig->loadTemplate('index/_item_vendor.tpl');
        echo $template->render(array(
            'models' => $vendors,
        ));

        $properties = new Properties();
        $properties = $properties->findAll();
        $template = $this->twig->loadTemplate('index/_item_properties.tpl');
        echo $template->render(array(
            'models' => $properties,
        ));

        $transports = new Transport();
        $transports = $transports->findAll();
        $template = $this->twig->loadTemplate('index/_item_transports.tpl');
        echo $template->render(array(
            'models' => $transports,
        ));
    }


}

