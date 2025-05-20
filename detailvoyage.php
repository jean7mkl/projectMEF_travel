<?php include("header.php"); ?>




    <style>
        .detail-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .detail-container img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .detail-container h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .detail-container p {
            font-size: 18px;
            line-height: 1.8;
            text-align: left;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #0077cc;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #005fa3;
        }
    </style>

<body>

<?php
$voyages = [
    "barcelone" => [
        "titre" => "Barcelone",
        "image" => "photo/barcelone.png",
        "description" => "Située entre mer et montagne, Barcelone est une ville vibrante qui mêle culture, architecture et farniente. Promenez-vous sur la célèbre Rambla, découvrez les œuvres de Gaudí comme la Sagrada Família ou le parc Güell, et flânez dans le quartier gothique aux ruelles étroites et pleines de charme. En été, profitez des plages animées pour vous détendre ou pratiquer des sports nautiques. Le soir, goûtez à la cuisine catalane et profitez de la vie nocturne dans les bars et rooftops animés. Barcelone est une destination idéale pour une escapade culturelle et festive."
    ],
    "suisse" => [
        "titre" => "Le ski en Suisse",
        "image" => "photo/suisse.png",
        "description" => "La Suisse vous accueille dans un décor de carte postale. Ses stations de ski réputées comme Zermatt, Verbier ou Saint-Moritz offrent un enneigement exceptionnel et des paysages alpins grandioses. Dévalez les pistes, relaxez-vous dans un spa avec vue sur les sommets enneigés, ou faites une balade en raquettes au cœur de la nature. En dehors du ski, découvrez les villages typiques suisses, goûtez à une fondue traditionnelle et profitez de l’ambiance chaleureuse des chalets en bois. Un séjour idéal pour les amoureux de l’hiver et des grands espaces."
    ],
    "courchevel" => [
        "titre" => "Courchevel",
        "image" => "photo/courchevel.png",
        "description" => "Courchevel est l'une des stations les plus prestigieuses des Alpes. Elle fait partie du domaine des Trois Vallées, le plus grand domaine skiable du monde. Outre ses pistes parfaitement entretenues, la station propose un large choix de restaurants étoilés, de boutiques de luxe et d’hôtels haut de gamme. Vous pourrez également profiter de nombreuses activités : motoneige, parapente, randonnées en raquettes, ou encore détente dans des spas somptueux. Courchevel est la destination parfaite pour ceux qui recherchent sport, élégance et confort au sommet."
    ],
    "chamonix" => [
        "titre" => "Chamonix",
        "image" => "photo/chamonix.png",
        "description" => "Chamonix, au pied du Mont-Blanc, est une destination mythique pour les amoureux de montagne. Été comme hiver, la station offre un cadre naturel exceptionnel. Vous pouvez y pratiquer le ski, bien sûr, mais aussi l’alpinisme, la randonnée, l’escalade ou le parapente. Ne manquez pas le téléphérique de l’Aiguille du Midi pour une vue spectaculaire sur les Alpes. Le centre-ville, authentique et vivant, propose de nombreux restaurants, bars et boutiques. Chamonix est un lieu de séjour unique où aventure et détente se conjuguent parfaitement."
    ],
    "newyork" => [
        "titre" => "New York",
        "image" => "photo/bgphoto.png",
        "description" => "New York est une ville fascinante, à la fois intense et inspirante. De Central Park à Times Square, en passant par le pont de Brooklyn, la Statue de la Liberté et les musées comme le MoMA ou le MET, la ville regorge de lieux emblématiques à découvrir. Montez en haut de l’Empire State Building ou du One World Observatory pour admirer la skyline. Assistez à un spectacle à Broadway et laissez-vous tenter par les multiples cuisines du monde dans les restaurants branchés. Un voyage à New York, c’est plonger dans un film grandeur nature."
    ],
    "megeve" => [
        "titre" => "Megève",
        "image" => "photo/megeve.png",
        "description" => "Megève est une station chic et traditionnelle des Alpes françaises. Entre les chalets en bois, les calèches dans les rues enneigées, et le charme d’un village d’exception, Megève séduit les amateurs de ski et de raffinement. Le domaine skiable est varié et adapté à tous les niveaux. Après une journée de glisse, profitez d’un chocolat chaud dans un café cosy, d’un spa ou d’un dîner gastronomique. Megève est l’endroit idéal pour un séjour hiver authentique et reposant."
    ],
    "maldives" => [
        "titre" => "Les Maldives",
        "image" => "photo/maldives.png",
        "description" => "Les Maldives sont un véritable paradis terrestre. Cet archipel de l’océan Indien vous offre des plages de sable blanc, une mer turquoise, et des lagons exceptionnels. Séjournez dans un bungalow sur pilotis, faites du snorkeling parmi les poissons tropicaux, partez en excursion sur une île déserte ou admirez le coucher de soleil depuis un bateau. C’est la destination parfaite pour une lune de miel, un voyage romantique ou tout simplement une pause bien-être loin du monde."
    ],
    "caraibes" => [
        "titre" => "Les Caraïbes",
        "image" => "photo/pexels-pixabay-62623.png",
        "description" => "Offrez-vous un voyage inoubliable dans les îles des Caraïbes. Que vous choisissiez la Guadeloupe, la Martinique, la République dominicaine ou Saint-Barth, vous y trouverez plages de rêve, lagons translucides, forêts tropicales et musique créole. Les Caraïbes, c’est aussi des marchés colorés, des rhums locaux, des randonnées dans la nature luxuriante et une ambiance chaleureuse qui vous fera tout oublier. Idéal pour se ressourcer et vivre au rythme des îles."
    ],
    "coteazur" => [
        "titre" => "La Côte d’Azur",
        "image" => "photo/pexels-gantas-4484243.png",
        "description" => "La Côte d’Azur, entre mer et collines, est une destination de charme et de prestige. Profitez du soleil à Nice, flânez sur la Croisette à Cannes, explorez les ruelles de Saint-Tropez ou visitez les musées de Monaco. La région propose aussi de magnifiques villages perchés comme Èze ou Saint-Paul-de-Vence. Plages, marchés provençaux, cuisine méditerranéenne et ambiance chic : tout est réuni pour un séjour inoubliable sur la Riviera française."
    ]
];

$slug = $_GET['dest'] ?? 'barcelone';

if (isset($voyages[$slug])) {
    $voyage = $voyages[$slug];
    echo '<div class="detail-container">';
    echo '<img src="'.$voyage['image'].'" alt="'.$voyage['titre'].'">';
    echo '<h1>'.$voyage['titre'].'</h1>';
    echo '<p>'.$voyage['description'].'</p>';
    echo '<a class="btn" href="formulaire.php?dest='.$slug.'">Réserver ce voyage</a><br>';
    echo '<a class="btn" href="voyage.php">← Retour aux voyages</a>';
    echo '</div>';
} else {
    echo '<div class="detail-container"><p>Voyage non trouvé.</p></div>';
}
?>

</body>
</html>


