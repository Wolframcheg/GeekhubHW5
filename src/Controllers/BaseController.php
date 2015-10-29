<?php
namespace wolfram\Controllers;

use Twig_Loader_Filesystem;
use Twig_Environment;

class BaseController
{
    protected $twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__.'/../views');
        $this->twig = new Twig_Environment($loader);
    }


}