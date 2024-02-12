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

    public function showTable()
    {
        //check if the user is authenticated
        $this->checkIfAuthenticated();
        $db = Database::getDbConnection();
        $query = "SELECT * FROM membre";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $member = $_SESSION['membre'];
        include_once $_SERVER["DOCUMENT_ROOT"] . '/templates/tables.phtml';
    }

    public function showMember()
    {
        $this->checkIfAuthenticated();
        include_once $_SERVER["DOCUMENT_ROOT"] . '/templates/editingMember.phtml';
    }

    public function editMember($params)
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
                    include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/editingMember.phtml";
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
        if (isset($_POST['validateMemberBtn'])) {
            // Extract form data
            $idMember = $params['id'];
            try {
                // Check if the form is validated
                $actifValue = isset($_POST['actif']) ? 1 : 0;
                // Update the "actif" field in the database
                $stmt = $db->prepare("UPDATE membre SET actif = :actif WHERE id = :idMember");
                $stmt->execute([':actif' => $actifValue, ':idMember' => $idMember]);
               // include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/tables.phtml";
                header("Location: /dashboard/members");
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
