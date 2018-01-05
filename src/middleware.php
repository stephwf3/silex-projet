<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$verifParamLogin = function (Request $request) {

    $retour = verifParam($request->request, array('email', 'password'));

    var_dump($retour);

};