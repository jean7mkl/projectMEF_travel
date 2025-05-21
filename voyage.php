<?php
session_start();

include("header.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Voyages Disponibles</title>
    <link rel="stylesheet" href="sitedevoyage.css">
    <style>
        .voyages-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            padding: 40px;
        }
        .voyage-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s ease;
            text-decoration: none; 
            color: inherit;
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
        }
        .voyage-card:hover {
            transform: scale(1.05);
        }
        .voyage-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .voyage-card h3 {
            margin: 15px 0 5px 0; 
            font-size: 20px;
            color: #333;
        }
        .voyage-card p.prix-appel { 
            font-size: 16px;
            color: #555;
            margin: 0 0 15px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php

?>

<h1 style="text-align: center; margin-top: 30px;">Nos Voyages</h1>

<div style="text-align:center; margin: 20px auto;">
    <input type="text" id="searchVoyage" placeholder="🔍 Rechercher un voyage..."
           style="padding: 10px; width: 60%; font-size: 16px; border-radius: 8px; border: 1px solid #ccc;">
</div>

<div class="voyages-container">
    <?php
    $voyages = [
        ["nom" => "Le ski en Suisse", "image" => "photo/suisse.png", "slug" => "suisse"],
        ["nom" => "Barcelone", "image" => "photo/barcelone.png", "slug" => "barcelone"],
        ["nom" => "Courchevel", "image" => "photo/courchevel.png", "slug" => "courchevel"],
        ["nom" => "Chamonix", "image" => "photo/chamonix.png", "slug" => "chamonix"],
        ["nom" => "New York", "image" => "photo/ny.png", "slug" => "newyork"], 
        ["nom" => "Megève", "image" => "photo/megève.png", "slug" => "megeve"],
        ["nom" => "Les Maldives", "image" => "photo/maldives.png", "slug" => "maldives"],
        ["nom" => "Les Caraïbes", "image" => "photo/caraibes.png", "slug" => "caraibes"], 
        ["nom" => "La Côte d’Azur", "image" => "photo/cote-dazur.png", "slug" => "coteazur"] 
    ];

    
    $prix_de_base_calcul = 500;
    $prix_par_adulte = 100;
    $prix_a_partir_de = $prix_de_base_calcul + $prix_par_adulte; 

    foreach ($voyages as $voyage) {
        echo '<a class="voyage-card" href="detailvoyage.php?dest='.htmlspecialchars($voyage['slug']).'">';
        echo '<div>';
        echo '<img src="'.htmlspecialchars($voyage['image']).'" alt="'.htmlspecialchars($voyage['nom']).'">';
        echo '<h3>'.htmlspecialchars($voyage['nom']).'</h3>';
        echo '<p class="prix-appel">À partir de : ' . $prix_a_partir_de . ' €</p>'; 
        echo '</div>';
        echo '</a>';
    }
    ?>
</div>

<?php include 'footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchVoyage");
    const container = document.querySelector(".voyages-container");
    const cartes = Array.from(container.children);

    //  Trie par ordre alphabétique
    cartes.sort((a, b) => {
        const nomA = a.querySelector("h3").textContent.toLowerCase();
        const nomB = b.querySelector("h3").textContent.toLowerCase();
        return nomA.localeCompare(nomB);
    });

    // Applique le tri au conteneur
    cartes.forEach(carte => container.appendChild(carte));

    //  Filtrage en direct
    searchInput.addEventListener("input", () => {
        const filtre = searchInput.value.toLowerCase();

        cartes.forEach(carte => {
            const nom = carte.querySelector("h3").textContent.toLowerCase();
            carte.style.display = nom.includes(filtre) ? "block" : "none";
        });
    });
});
</script>

</body>
</html>