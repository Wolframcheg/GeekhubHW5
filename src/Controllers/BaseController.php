<?php
namespace wolfram\Controllers;

use Twig_Loader_Filesystem;
use Twig_Environment;

class BaseController
{
    protected $twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../views');
        $this->twig = new Twig_Environment($loader);
    }

    public function getArrayFromArrayOfObject($array)
    {
        $output = [];

        if ($array) foreach ($array as $key => $item) {
            array_push($output, $item->toArray());
        }
        return $output;
    }

    public function arrayOfObjectDifference($arrayBig, $arraySmall)
    {
        $arrB = $this->getArrayFromArrayOfObject($arrayBig);
        $arrS = $this->getArrayFromArrayOfObject($arraySmall);

        $outArray = [];
        foreach ($arrB as $item) {
            if (!in_array($item, $arrS)) {
                array_push($outArray, $item);
            }
        }
        return $outArray;
    }


}