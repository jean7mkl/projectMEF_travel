<?php
header('Content-Type: application/json');
sleep(2); //

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'], $data['login'], $data['email'], $data['role'])) {
    echo json_encode(['success' => false]);
    exit;
}

$fichier = 'voyageurs.json';
$utilisateurs = json_decode(file_get_contents($fichier), true);
$id = (int)$data['id'];
$success = false;
$ancien = null;

foreach ($utilisateurs as &$utilisateur) {
    if ((int)$utilisateur['id'] === $id) {
        $ancien = [
            "login" => $utilisateur['login'],
            "email" => $utilisateur['informations']['email'] ?? "",
            "role" => $utilisateur['role']
        ];
        $utilisateur['login'] = htmlspecialchars($data['login']);
        $utilisateur['informations']['email'] = htmlspecialchars($data['email']);
        $utilisateur['role'] = htmlspecialchars($data['role']);
        $success = true;
        break;
    }
}

if ($success) {
    file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT));
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "old" => $ancien]);
}
