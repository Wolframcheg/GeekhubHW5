<?php
namespace wolfram\Controllers;

use wolfram\Models\TablesData;
use wolfram\Models\Properties;


class PropertiesController extends BaseController
{
    public function actionCreate()
    {
        $properties = new Properties();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $properties = $properties->fromArray($_POST);
            $properties->save();
            header('Location: /');
        } else {
            $template = $this->twig->loadTemplate('properties/create.tpl');
            echo $template->render(array(
                'model' => $properties,
                'types' => Properties::getTypes()
            ));
        }
    }

    public function actionUpdate($id)
    {
        $properties = new Properties();
        $properties = $properties->find($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $properties = $properties->fromArray($_POST);
            $properties->save();
            header('Location: /');
        } else {
            $template = $this->twig->loadTemplate('properties/update.tpl');
            echo $template->render(array(
                'model' => $properties,
                'types' => Properties::getTypes()
            ));
        }
    }

    public function actionDelete($id)
    {
        $properties = new Properties();
        $properties = $properties->find($id);
        $properties->remove();
        header('Location: /');
    }

}