<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');


define('MYSQL_HOST', '192.168.56.12');
define('MYSQL_USERNAME', 'hugorouff');
define('MYSQL_PASSWORD', 'hugorouff');
define('MYSQL_DATABASE', 'chuck_citation');

$mysqli = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

if ($mysqli->connect_error) {
    die(json_encode(["message" => "Erreur de connexion à la base de données : " . $mysqli->connect_error]));
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $mysqli->prepare('SELECT * FROM citations WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $citation = $result->fetch_assoc();
            echo json_encode($citation);
        } else {
            $result = $mysqli->query('SELECT * FROM citations');
            $citations = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($citations);
        }
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $mysqli->prepare('INSERT INTO citations (texte, auteur) VALUES (?, ?)');
        $stmt->bind_param('ss', $input['texte'], $input['auteur']);
        $stmt->execute();
        $newCitation = [
            "id" => $mysqli->insert_id,
            "texte" => $input['texte'],
            "auteur" => $input['auteur']
        ];
        echo json_encode($newCitation);
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $mysqli->prepare('UPDATE citations SET texte = ?, auteur = ? WHERE id = ?');
        $stmt->bind_param('ssi', $input['texte'], $input['auteur'], intval($input['id']));
        $stmt->execute();
        echo json_encode($input);
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $mysqli->prepare('DELETE FROM citations WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            echo json_encode(["message" => "Citation supprimée"]);
        }
        break;

    default:
        echo json_encode(["message" => "Méthode non supportée"]);
        break;
}

$mysqli->close();
?>