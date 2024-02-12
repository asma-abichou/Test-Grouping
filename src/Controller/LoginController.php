<?php

namespace App\Controller;

use App\Database;
use PDO;

class LoginController
{
    public function showLoginPage()
    {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/security/login.phtml";
    }
    public function logOut()
    {
        unset($_SESSION['user']);
        header("Location: /login");
        die();
    }

    public function getUserByEmail($email){
        $db = Database::getDbConnection();
        $query = $db->prepare('SELECT * FROM users WHERE email = :email AND (role = :admin_role OR role = :user_role)');
        $query->execute(['email' => $email, 'admin_role' => 'ROLE_ADMIN', 'user_role' => 'ROLE_USER']);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
        public function validationInputFields($params){
            $email = $params['email'];
            $password = $params['password'];
            if (empty($email) || empty($password)) {
                $_SESSION["login_fail_message"] = "Email and password are required!";
                header('location: login.php');
                die();
            }

        }
    public function processLogin($params){
        $email = $params['email'];
        $password = $params['password'];
        $user = $this->getUserByEmail($email);
        var_dump($user);

        if ($user && password_verify($password, $user['password'])) {
            // Valid login credentials
            $this->validationInputFields($params);

            if ($user['role'] === 'ROLE_ADMIN') {
                // Redirect admin to dashboard
                $_SESSION['user'] = $user;
                header("Location: /dashboard/members/list");
                exit();
            } else {
                // Display a specific error message for users with other roles
                $_SESSION["login_fail_message"] = "Invalid credentials for user role.";
                header("Location: /login");
                exit();
            }
        } else {
            // Invalid login credentials
            $_SESSION["login_fail_message"] = "Incorrect email or password. Please try again.";
            header("Location: /login");
            exit();
        }
    }

}