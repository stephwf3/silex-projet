<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

/*** Route Login ***/
$app->get('/', function () use ($app) { // on mets toujours les pages get en premier, puis les pages en post
    return $app['twig']->render('basic/login.html.twig', array());
});

$app->post('/', function () use ($app) {
    return $app['twig']->render('basic/login.html.twig', array());
});

/*** Route Register ***/
$app->get('/register', function() use ($app){
    return $app['twig']->render('basic/register.html.twig');
});







$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
