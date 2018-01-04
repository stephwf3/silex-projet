<?php

    function sendMail($address, $message, $app){
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
            $mail->addAddress($address, 'Un alias'); // l'adresse du destinataire. + alias en 2ème arg (en général le nom)
            
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = $message; // contenu du mail en html
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; // contenu du mail en texte simple (très rare, en général, on n'envoit que body en html)
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }



    function register(array $user, $app) { 

        if(!isset($user["email"]) || !isset($user["password"]) || !isset($user["username"])) {// si les variables n'existent pas...
            return false;
        }

        if(empty(trim($user["email"])) || empty(trim($user["password"])) || empty(trim($user["username"]))) {
            return false;
        }

        // si tout va bien, on sécurise les infos...
            $email = htmlspecialchars(trim($user["email"])); 
            $password = strip_tags(trim($user["password"]));
            $username = strip_tags(trim($user["username"]));

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { // si l'email n'est pas au bon format (verif de la syntaxe avec la fonction de la classe)
            return false; // on redirige vers register
        }

        $app['db']->insert('user', array(
            'username' => $username,
            'email' =>  $email,
            'password' => $password
        ));

    }