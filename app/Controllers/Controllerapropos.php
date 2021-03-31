<?php

namespace app\Controllers;

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;
use \PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

class Controllerapropos
{

    /**
     * Permet de traiter le formulaire de contact.
     * @return \Exception|string
     * @throws \Exception
     */
    public function formContact ()
    {
        $msg = "";

        if(empty($_POST['nom']) && ($_POST['prenom']) && ($_POST['mail']) && ($_POST['message'])){
            throw new \Exception("* Merci de remplir les champs du formulaire.");
        }

        try {
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $email = htmlspecialchars(trim($_POST['mail']));
            $message = htmlspecialchars(trim($_POST['message']));

            $this->Mail($nom, $prenom, $email, $message);
            return $msg = "Votre message à bien été envoyé.";

        }catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Configuration de PHPMailer avec les valeurs du formulaire.
     * @param $nom
     * @param $prenom
     * @param $email
     * @param $message
     * @throws Exception
     */
    public function Mail ($nom, $prenom, $email, $message) {

            $mail = new PHPMailer(true);

            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'laprevote.emma@gmail.com';                     //SMTP username
            $mail->Password = 'lkanizmbebajdkmn';                               //SMTP password
            $mail->SMTPSecure = 'ssl';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 465;                                  //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('laprevote.emma@gmail.com', 'JUNGLE GARDENER');
            $mail->addAddress('emma.laprevote@laplateforme.io');     //Add a recipient


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'CONTACT - JUNGLE GARDENER';
            $mail->Body = '<div>
                              <span><b>Nom</b> : '.$nom.'</span><br>
                              <span><b>Prenom</b> : '.$prenom.'</span><br>
                              <span><b>Email</b> : '.$email.'</span><br>
                              <span><b>Message</b> : '.$message.'</span>
                          </div>';

            $mail->send();

    }
}