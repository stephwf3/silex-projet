<?php
 
    namespace Webforce\Controller;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;

    class IndexController { // par convention, on va nommer les classes xxxxController

        public function loginAction() { // par convention, on va nommer les méthodes xxxxAction

        }

        public function registerAction(Application $app, Request $request){
            
            $email = htmlspecialchars(trim($request->request->get("email"))); 
            $password = strip_tags(trim($request->request->get("password")));
            $username = strip_tags(trim($request->request->get("username")));
    
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { // si l'email n'est pas au bon format (verif de la syntaxe avec la fonction de la classe)
                return $app['twig']->render('basic/register.html.twig'); // on redirige vers register
            }
    
            $app['db']->insert('user', array(
                'username' => $username,
                'email' =>  $email,
                'password' => $password // on peut crypter avec la fonction crypt() en php et qui est indechiffrable
            ));
            
            return $app['twig']->render('basic/register.html.twig');
        }

    }
