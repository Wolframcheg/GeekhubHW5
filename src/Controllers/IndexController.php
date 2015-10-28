<?php
namespace wolfram\Controllers;

use wolfram\Models\PdoConnect;


class IndexController{

    public function actionIndex()
    {
        $pdo = new PdoConnect();
        $pdo->connect();
        
        if(!$pdo->tableExists('transport')){
            echo 'Table "transport" not exist. <a href="/create-table/transport">Create</a><br>';
        }


    }

    public function actionTransports()
    {
        echo 'transports page';
    }

}

