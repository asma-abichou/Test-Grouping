<?php

namespace App\Controller;


use App\Database;
use Exception;
use PDO;

class RegistrationController
{
    public function showRegistrationPage($params)
    {
        /*var_dump($params);*/
         include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/security/sign-up.phtml";
    }
    function validateUserInput($params)
    {
        $errors = [];
        // Validate fields
        $fullName = $params['fullName'];
        $email = $params['email'];
        $password = $params['password'];
        $confirmPassword = $params['password2'];
        // Validate full name
        if (empty($fullName)) {
            $errors[] = 'Full name is required';
        }
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address';
        }
        if (empty($password) || strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long';
        }
        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }
        // If there are errors, throw an exception
        if (!empty($errors)) {
            throw new Exception(implode('<br>', $errors));
        }

        // Validation passed
        return true;
    }

   public function processRegistration($params)
   {
        try {
            $this->validateUserInput($params); //["Passwords do not match"]
            $db = Database::getDbConnection();
            $role = 'ROLE_ADMIN';
            $fullName = $params['fullName'];
            $email = $params['email'];
            /*var_dump($validationResult);
            die();*/
            //hash password
            $hashedPassword = password_hash($params['password'], PASSWORD_DEFAULT);
            /*var_dump($hashedPassword);
            die();*/
            $query = "INSERT INTO users (email, password, role, full_name) VALUES (:email, :password, :role, :fullName)";
            $stmt = $db->prepare($query);
            $stmt->execute(['email' => $email, 'password' => $hashedPassword, 'role' => $role, 'fullName' => $fullName]);
            // $registeredUserId = $db->lastInsertId();
            // Redirect to the dashboard
            header("Location: /login");
            exit();
        }catch(Exception $e) {
            // Handle the exception (display error messages, log, etc.)
            $errorMessages = $e->getMessage();
            include $_SERVER["DOCUMENT_ROOT"] . "/templates/security/sign-up.phtml";
            exit();

        }
   }


}