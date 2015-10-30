<?php
namespace wolfram\Controllers;


use wolfram\Models\Passport;
use wolfram\Models\Properties;
use wolfram\Models\Transport;
use wolfram\Models\TransportProperties;
use wolfram\Models\Vendor;


class TransportController extends BaseController
{
    public function actionCreate()
    {

        $model = new Transport();
        $passport = new Passport();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = $model->fromArray($_POST);
            $model->save();
            $passport = $passport->fromArray($_POST);
            $passport->setIdTransport($model->getId());
            $passport->save();
            header('Location: /');
        } else {
            $vendors = new Vendor();
            $vendors = $vendors->findAll();

            $template = $this->twig->loadTemplate('transport/create.tpl');
            echo $template->render(array(
                'model' => $model,
                'vendors' => $vendors,
                'passport' => $passport
            ));
        }

    }

    public function actionUpdate($id)
    {
        $model = new Transport();
        $model = $model->find($id);
        $passport = $model->getRelatePassport();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            $model = $model->fromArray($data);
            $model->save();
            $data['id'] = $passport->getId();
            $data['id_transport'] = $model->getId();
            $passport = $passport->fromArray($data);
            $passport->save();
            header('Location: /');
        } else {
            $vendors = new Vendor();
            $vendors = $vendors->findAll();

            $properties = new Properties();
            $allProperties = $properties->findAll();
            $transportProperties = $model->getRelateProperties();

            $propDiff = $this->arrayOfObjectDifference($allProperties, $transportProperties);

            $template = $this->twig->loadTemplate('transport/update.tpl');
            echo $template->render(array(
                'model' => $model,
                'vendors' => $vendors,
                'passport' => $passport,
                'propDiff' => $propDiff,
                'transportProperties' => $transportProperties
            ));
        }

    }

    public function actionDelete($id)
    {
        $model = new Transport();
        $model = $model->find($id);
        $model->remove();
        header('Location: /');
    }

    public function actionDeleteProperty($id_transport, $id_properties)
    {
        $query = "WHERE id_transport = {$id_transport} AND id_properties = {$id_properties}";
        $model = new TransportProperties();
        $model = $model->findOneByQuery($query);
        $model->remove();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function actionAddProperty()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new TransportProperties();
            $model->setIdProperties($_POST['id_properties']);
            $model->setIdTransport($_POST['id_transport']);
            var_dump($model);
            $model->save();
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }

}