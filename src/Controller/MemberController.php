<?php

namespace App\Controller;

use App\Database;
use PDO;

class MemberController
{
    public function checkIfAuthenticated()
    {
        if(!isset($_SESSION['user'])){
            header("Location: /login");
            die();
        }
    }
    public function showTable(){
        //check if the user is authenticated
        $this->checkIfAuthenticated();
        $db = Database::getDbConnection();
        $query = "SELECT * FROM membre";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include_once  $_SERVER["DOCUMENT_ROOT"] . '/templates/tables.phtml';
    }
    public function showMember(){
        $this->checkIfAuthenticated();
        include_once  $_SERVER["DOCUMENT_ROOT"] . '/templates/editingMember.phtml';
    }
    public function editMember(){
        $this->checkIfAuthenticated();
        $db = Database::getDbConnection();
        $member = $_SESSION['member'];
        $idMember = $member['id'];
        $stmt = $db->prepare("SELECT * FROM member WHERE id = :idMember");
        $stmt->execute([':idMember' => $idMember]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($member) {
            $fullName = $user['full_name'];
            $email = $user['email'];
            $pictureProfile = $user['picture_profile'];

            include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/profile.phtml";

        }
    }

}
