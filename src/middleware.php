<?php

// éviter de faire des connexion à la bdd avec les middleware. C'est pas interdit mais ce n'est pas le but : le middleware est là pour contrôler l'intégrité des données

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$verifParamLogin = function (Request $request) {

    $retour = verifParam($request->request, array('email', 'password'));

    var_dump($retour);

};