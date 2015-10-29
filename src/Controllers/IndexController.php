<?php
namespace wolfram\Controllers;

use wolfram\Models\Properties;
use wolfram\Models\TablesData;
use wolfram\Models\Vendor;


class IndexController extends BaseController
{

    public function actionIndex()
    {
        $tablesData = new TablesData();
        $exist = $tablesData->checkTablesExist([
            'transport',
            'passport',
            'vendor',
            'properties',
            'transport_properties'
        ]);
        if(is_array($exist)){
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
    }


}

