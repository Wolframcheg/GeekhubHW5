<?php
namespace wolfram\Controllers;

use wolfram\Models\TablesData;
use wolfram\Models\Vendor;


class IndexController{

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
        if(!$exist){
            echo '<a href="/create-tables">Create Tables</a>';
            return false;
        }

        $loader = new \Twig_Loader_Filesystem(__DIR__.'/../views');
        $twig = new \Twig_Environment($loader);
        $template = $twig->loadTemplate('index/_item_vendor.tpl');

        $vendors = new Vendor();
        $vendors = $vendors->findAll();

        echo $template->render(array(
            'models' => $vendors,
        ));
    }


}

