<?php


    use Silex\Provider\AssetServiceProvider;
    use Silex\Provider\TwigServiceProvider;
    use Silex\Provider\ServiceControllerServiceProvider;
    use Silex\Provider\HttpFragmentServiceProvider;
    use Silex\Provider\DoctrineServiceProvider; // nécessaire pour utiliser DBAL de doctrine (accès à la bdd)
    use PHPMailer\PHPMailer\PHPMailer; // nécessaire pour envoyer des mails par phpmailer
    use PHPMailer\PHPMailer\Exception; // nécessaire pour envoyer des mails par phpmailer

    $app->register(new ServiceControllerServiceProvider()); // Chargement des Controleur Provider
    $app->register(new AssetServiceProvider()); // Chargement de la gestion des Asset
    $app->register(new TwigServiceProvider()); // Chargement de Twig
    $app->register(new HttpFragmentServiceProvider()); // Chargement des Fragment HTTP (Request, Response)
    $app->register(new DoctrineServiceProvider(), array( // chargement de DBAL
        'db.options' => array( // on rentre dans les options nos paramètres de connexion à la bdd
            'host'   => 'localhost',
            'user'     => 'root',
            'password'     => '',
            'dbname'     => 'marveldb',
        ),
    ));   



    $app['twig'] = $app->extend('twig', function ($twig, $app) {
        // add custom globals, filters, tags, ...

        return $twig;
    });

    $app['twig.path'] = array(__DIR__.'/../templates'); // Dossier des pages Twig
    // $app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig'); // Dossier des caches des pages Twig

    $app["mail"] = new PHPMailer(true); // pour l'accès à PHPMailer depuis n'importe quelle page du site