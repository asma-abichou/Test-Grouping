<?php

namespace App\Controller;

use App\Database;
use PDO;

class UserController
{
    public function checkIfAuthenticated()
    {
        if(!isset($_SESSION['user'])){
            header("Location: /login");
            die();
        }
    }
    public function myProfile($params){
        //show profile
        $this->checkIfAuthenticated();

        $db = Database::getDbConnection();
        $user = $_SESSION['user'];
        $idUser = $user['id'];
        $stmt = $db->prepare("SELECT full_name, email, profile_image FROM users WHERE id = :idUser");
        $stmt->execute([':idUser' => $idUser]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $fullName = $user['full_name'];
            $email = $user['email'];
            $pictureProfile = $user['picture_profile'];

            include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/user/my-profile.phtml";

        }
    }
}