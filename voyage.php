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
            margin: 15px 0;
            font-size: 20px;
            color: #333;
        }
    </style>
</head>
<body>

<h1 style="text-align: center; margin-top: 30px;">Nos Voyages</h1>

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

    foreach ($voyages as $voyage) {
        echo '<a class="voyage-card" href="detailvoyage.php?dest='.$voyage['slug'].'">';
        echo '<img src="'.$voyage['image'].'" alt="'.$voyage['nom'].'">';
        echo '<h3>'.$voyage['nom'].'</h3>';
        echo '</a>';
    }
    ?>
</div>

</body>
</html>