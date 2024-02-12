<?php

namespace App\Controller;

use App\Database;
use PDO;
use PDOException;

class MemberController
{
    public function checkIfAuthenticated()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            die();
        }
    }

    public function membersList()
    {
        //check if the user is authenticated
        $this->checkIfAuthenticated();
        $db = Database::getDbConnection();
        $query = "SELECT * FROM membre";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $member = $_SESSION['membre'];
        include_once $_SERVER["DOCUMENT_ROOT"] . '/templates/members/list.phtml';
    }

    public function editMemberTemplateShow($params)
    {
        $this->checkIfAuthenticated();
        $db = Database::getDbConnection();
        if (isset($_SESSION['user'])) {
            $loggedInUser = $_SESSION['user'];
            // Extract the member ID from the URL parameter
            $idMember = $params['id'];
            try {
                // Fetch information for the specified member using the extracted ID
                $stmt = $db->prepare("SELECT * FROM membre WHERE id = :idMember");
                $stmt->execute([':idMember' => $idMember]);
                $memberData = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($memberData) {
                    // Retrieve all information for the member
                    $type = $memberData['type'];
                    $actif = $memberData['actif'];
                    $nom = $memberData['nom'];
                    $prenom = $memberData['prenom'];
                    $adresse = $memberData['adresse'];
                    $codePostal = $memberData['code_postal'];
                    $fonction = $memberData['fonction'];
                    $biographie = $memberData['biographie'];
                    $pays = $memberData['pays'];
                    $pieceJustificative = $memberData['piece_justificative'];
                    $email = $memberData['email'];
                    include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/members/edit.phtml";
                } else {
                    echo "Member data not found.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Session variable 'user' not set.";
        }
    }
    public function validateMember($params)
    {
        $this->checkIfAuthenticated();
        $db = Database::getDbConnection();
        if (isset($params['id'])) {
            // Extract form data
            $idMember = $params['id'];
            try {
                // Update the "actif" field in the database
                $stmt = $db->prepare("UPDATE membre SET actif = :actif WHERE id = :idMember");
                $stmt->execute([':actif' => 1, ':idMember' => $idMember]);
                header("Location: /dashboard/members/list");
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
