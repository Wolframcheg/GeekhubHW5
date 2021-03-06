<?php
namespace wolfram\Controllers;

use wolfram\Models\Vendor;


class VendorController extends BaseController
{
    public function actionCreate()
    {
        $vendor = new Vendor();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $vendor = $vendor->fromArray($_POST);
            $vendor->save();
            header('Location: /');
        } else {
            $template = $this->twig->loadTemplate('vendor/create.tpl');
            echo $template->render(array(
                'model' => $vendor,
            ));
        }

    }

    public function actionUpdate($id)
    {
        $vendor = new Vendor();
        $vendor = $vendor->find($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $vendor = $vendor->fromArray($_POST);
            $vendor->save();
            header('Location: /');
        } else {
            $template = $this->twig->loadTemplate('vendor/update.tpl');
            echo $template->render(array(
                'model' => $vendor,
            ));
        }
    }

    public function actionViewTransports($id)
    {
        $vendor = new Vendor();
        $vendor = $vendor->find($id);
        $transports = $vendor->getRelateTransports();

        $template = $this->twig->loadTemplate('vendor/view_transports.tpl');
        echo $template->render(array(
            'model' => $vendor,
            'transports' => $transports
        ));

    }

    public function actionDelete($id)
    {
        $vendor = new Vendor();
        $vendor = $vendor->find($id);
        $vendor->remove();
        header('Location: /');
    }


}