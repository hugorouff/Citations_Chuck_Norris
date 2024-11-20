<?php
header('Content-Type: application/json');

$citations = [
    ["id" => 1, "texte" => "Chuck Norris ne ment pas, c'est la vérité qui se trompe.", "Auteur" => "Inconnu"],
    ["id" => 2, "texte" => "Chuck Norris a déjà compté jusqu'à l'infini. Deux fois.", "Auteur" => "Inconnu"],
    ["id" => 3, "texte" => "Quand Chuck Norris marche sur un râteau, le râteau se prend Chuck Norris dans la gueule.", "Auteur" => "Inconnu"],
    ["id" => 4, "texte" => "Chuck Norris peut t'étrangler avec un téléphone sans fil.", "Auteur" => "Inconnu"],
    ["id" => 5, "texte" => "Une larme de Chuck Norris peut guérir du cancer, malheureusement Chuck Norris ne pleure pas.", "Auteur" => "Inconnu"],
    ["id" => 6, "texte" => "Chuck Norris ne porte pas de montre. Il décide de l'heure qu'il est.", "Auteur" => "Inconnu"],
    ["id" => 7, "texte" => "Quand Chuck Norris fait une poussée, il ne se soulève pas, il pousse la Terre vers le bas.", "Auteur" => "Inconnu"],
    ["id" => 8, "texte" => "Chuck Norris peut faire du feu en frottant deux glaçons.", "Auteur" => "Inconnu"],
    ["id" => 9, "texte" => "Chuck Norris peut taguer le mur du son.", "Auteur" => "Inconnu"],
    ["id" => 10, "texte" => "Chuck Norris connaît la dernière décimale de Pi, et celle d'après aussi.", "Auteur" => "Inconnu"]
];

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $citation = array_filter($citations, fn($c) => $c['id'] === $id);
            echo json_encode(array_values($citation));
        } else {
            echo json_encode($citations);
        }
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $newCitation = [
            "id" => end($citations)['id'] + 1,
            "texte" => $input['texte'],
            "Auteur" => $input['Auteur']
        ];
        $citations[] = $newCitation;
        echo json_encode($newCitation);
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        $id = intval($input['id']);
        foreach ($citations as &$citation) {
            if ($citation['id'] === $id) {
                $citation['texte'] = $input['texte'];
                $citation['Auteur'] = $input['Auteur'];
                echo json_encode($citation);
                break;
            }
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $citations = array_filter($citations, fn($c) => $c['id'] !== $id);
            echo json_encode(["message" => "Citation supprimée"]);
        }
        break;

    default:
        echo json_encode(["message" => "Méthode non supportée"]);
        break;
}
?>