<?php
/**
 * Retourne true si l'utilisateur donné est banni.
 */
function isUserBanned(int $idUtilisateur): bool
{
    $chemin = __DIR__ . '/utilisateurs.json';
    if (! file_exists($chemin)) {
        return false;
    }

    $data = json_decode(file_get_contents($chemin), true);
    if (! is_array($data)) {
        return false;
    }

    foreach ($data as $user) {
        // on s'assure que la clé 'id_utilisateur' et 'statut' existent
        if (isset($user['id'], $user['statut'])
            && (int)$user['id'] === $idUtilisateur
        ) {
            // comparaison insensible à la casse
            return strtolower(trim($user['statut'])) === 'banni';
        }
    }

    return false;
}
