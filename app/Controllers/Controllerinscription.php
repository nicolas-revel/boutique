<?php

namespace app\controllers;


class Controllerinscription extends \app\models\Modelinscription
{

    // Properties

    // Methods

    /**
     * insertUser
     *
     * @param string $email
     * @param string $password
     * @param string $c_password
     * @param string $firstname
     * @param string $lastname
     * @param array $avatar
     * @param string $birthdate
     * @param string $gender
     * @return void
     */
    public function insertUser(string $email, string $password, string $c_password)
    {

        if (empty($email) || empty($password) || empty($c_password)) {
            throw new \Exception("Merci de bien remplir tous les champs obligatoires.");
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \Exception("Merci de rentrer une adresse email valide");
        }
        if ($c_password !== $password) {
            throw new \Exception("Merci de bien confirmer votre mot de passe");
        }
        if (preg_match('#^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$#', $password) === 0 || preg_match('#^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$#', $password) === false) {
            throw new \Exception("Merci de fournir un mot de passe au format demandé");
        }
        $email = htmlspecialchars(trim($email));
        $password = htmlspecialchars(trim(password_hash($password, PASSWORD_DEFAULT)));
        $this->insertUserDB($email, $password, 1);
        try {
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

}
