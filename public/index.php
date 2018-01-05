<?php

    // ini_set('display_errors', 0); // Message d'erreur n'apparait pas

    require_once __DIR__.'/../vendor/autoload.php';

    use Silex\Application;
    $app = new Application();
    require __DIR__.'/../src/register.php';
    require __DIR__.'/../src/function.php';
    require __DIR__.'/../src/middleware.php';
    require __DIR__.'/../src/controller/Controller.php';
    require __DIR__.'/../src/controller/IndexController.php';


    require __DIR__.'/../src/route.php'; // on essaye de garder le require des routes à la fin de la liste
    $app->run();
