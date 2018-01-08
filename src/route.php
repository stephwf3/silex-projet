<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));


/****************************** Route Login ***/
$app->get('/', function () use ($app) { // on mets toujours les pages get en premier, puis les pages en post
    return $app['twig']->render('basic/login.html.twig', array());
})->bind('login');

$app->post('/', function () use ($app) {
    return $app['twig']->render('basic/login.html.twig', array());
});


/***************************** Route Register ***/
$app->get('/register', function() use ($app){
    return $app['twig']->render('basic/register.html.twig');
})->bind('register');

$app->post('/register', 'Webforce\Controller\IndexController::registerAction');



/******************************* Route forgottenPassword ***/
$app->get('/forgottenPassword', function() use ($app){
    return $app['twig']->render('basic/forgotten.html.twig');
})->bind('forgotPassword'); // {{ path }} dans la view utilise le bind de la route pour appeler la page associée

$app->post('/forgottenPassword', function() use ($app){ // traitement du POST du formulaire (envoi d'un mail)
    sendMail('steph.wbf3@gmail.com', "Le message du mail en html", $app);
    return $app['twig']->render('basic/forgotten.html.twig'); // affichage de la page après envoi du mail
});



/**************************** Validate token email *********** */

$app->get("/verif/{token}/", 'Webforce\Controller\IndexController::verifEmailAction');
















/*** Route de test ***/

// $app->get("/test", function() use ($app){
//     $sql = "SELECT * FROM user WHERE id = ?";
//     $post = $app['db']->fetchAssoc($sql, array((int) 2));

//     return  "<h1>{$post['username']}</h1>". // en php on peut afficher les valeurs d'un tableau en échappant les [ ] avec des { } autour de la variable
//             "<p>{$post['email']}</p>";
// });

$app->get("/test", function(Request $request) use ($app){ 

    if($request->query->has("name")) // ->request ne marche pas en get, on utilise query à la place
        return "Votre nom est ".$request->query->get("name"); // has fonctionne comme un isset, get récupère la valeur associée à la clef en paramètre. Si dans l'url on entre "?name=jean_jacques" à la fin, on aura d'affiché "votre nom est jean_jacques"

    return "";
});


// $app->post("/test", function(Request $request) use ($app){ // on précise en param de la function que l'objet $request provient de la classe Request et non pas d'un éventuel {request} dans l'url. $request va contenir toutes les données envoyées, leurs sources... Elle est équivalente à $_REQUEST de php

//     if($request->request->has("name"))
//         return "Votre nom est ".$request->request->get("name"); // has fonctionne comme un isset, get récupère la valeur associée à la clef en paramètre

//     return "";
// });

$app->post("/test", function(Request $request) use ($app){ 
   
    var_dump($retour);
    if($request->request->has("name"))
        return "Votre nom est ".$request->request->get("name"); // has fonctionne comme un isset, get récupère la valeur associée à la clef en paramètre
    
    return "";
})
->before($verifParamLogin); // AVANT de lancer la route, on lance le middleware verifParamLogin



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
