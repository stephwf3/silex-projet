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

/*** Route forgottenPassword ***/
$app->get('/forgottenPassword', function() use ($app){
    return $app['twig']->render('basic/forgotten.html.twig');
});

$app->post('/forgottenPassword', function() use ($app){ // traitement du formulaire (envoi d'un mail)
    try {
        $mail = $app["mail"];
        //Server settings (à récupéer depuis les informations de notre serveur/hébergeur)
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'provolone.o2switch.net';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'eleve@lyknowledge.fr';                 // SMTP username
        $mail->Password = 'zoubida22?';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // mode de sécurité
        $mail->Port = 465;                                    // TCP port to connect to
    
        //Recipients (qui est l'expéditeur)
        $mail->setFrom('eleve@lyknowledge.fr', 'Webforce3'); // l'adresse de l'expéditeur (nous). Le 2ème argument est un alias qui s'affichera dans le mail
        $mail->addAddress('steph.wbf3@gmail.com', 'Un alias random'); // l'adresse du destinataire. + alias en 2ème arg
        
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>'; // contenu du mail en html
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; // contenu du mail en texte simple (très rare, en général, on n'envoit que body en html)
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
    return $app['twig']->render('basic/forgotten.html.twig'); // affichage de la page après envoi du mail
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
