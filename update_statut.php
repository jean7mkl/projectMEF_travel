<?php
header("Content-Type: application/json");

$donnees = json_decode(file_get_contents("php://input"), true);
$user_id = (int)($donnees['user_id'] ?? 0);
$action = $donnees['action'] ?? '';

$fichier = 'utilisateurs.json';
$utilisateurs = file_exists($fichier) ? json_decode(file_get_contents($fichier), true) : [];
$trouve = false;
$nouveau_statut = '';

foreach ($utilisateurs as &$u) {
    if ($u['id'] === $user_id) {
        switch ($action) {
            case 'vip':
            case 'normal':
            case 'banni':
                $u['statut'] = $action;
                $nouveau_statut = $action;
                $trouve = true;
                break;
        }
        break;
    }
}

if ($trouve) {
    file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true, 'new_statut' => $nouveau_statut]);
} else {
    echo json_encode(['success' => false]);
}
