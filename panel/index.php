<?php
include(dirname(__FILE__, 2) . '/assets/src/files_header.php');
include(dirname(__FILE__, 2) . '/assets/src/conn.php');

// Auth Check
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: /login/');
    exit;
}

// Fetch User Data
$stmt = $pdo->prepare("SELECT u.nom_utilisateur, u.prenom_utilisateur, u.mail_univ, r.id_role, r.nom_role FROM utilisateur u JOIN role r on u.id_role = r.id_role WHERE u.id_utilisateur = :u;");
$stmt->bindParam(':u', $_SESSION["user_id"]);
$stmt->execute();
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user_data) {
    $_SESSION["user"]["nom_role"] = $user_data['nom_role'];
    $_SESSION["user"]["id_role"] = $user_data['id_role'];
    $_SESSION["user"]["prenom_utilisateur"] = $user_data['prenom_utilisateur'];
    $_SESSION["user"]["nom_utilisateur"] = $user_data['nom_utilisateur'];
}

// Dashboard Statistics (Hardcoded for now as per original)
$objets_recycles = 345;
$nouveaux_objets = 67;
$composante_active = "Faculté des Lettres, Langues & Sciences Humaines";
$objets_recycles_composante = 43;

// Fetch Demandes (Moved from view)
$demandes = [];
try {
    $sql = "
        SELECT
            O.nom_objet AS nom,
            SUM(O.quantity) AS quantite, 
            COALESCE(COM.nom_composante, 'Non assignée') AS composante 
        FROM OBJET O
        
        JOIN AGENCER A ON O.id_objet = A.id_objet
        JOIN INVENTAIRE INV ON A.id_inventaire = INV.id_inventaire
        LEFT JOIN DEPARTEMENT D ON INV.id_inventaire = D.id_inventaire
        LEFT JOIN SERVICE S ON INV.id_inventaire = S.id_inventaire
        LEFT JOIN COMPOSANTE COM ON D.id_composante = COM.id_composante OR S.id_composante = COM.id_composante
        
        GROUP BY O.nom_objet, COM.nom_composante 
        
        ORDER BY O.id_objet ASC
    ";

    $stmt = $pdo->query($sql);
    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    error_log("Erreur de requête BDD: " . $e->getMessage());
}

// View Logic & Routing
$base_url = '/panel';
$linkMapping = [
    'index' => 'accueil',
    'statistics' => 'statistiques',
    'server' => 'serveur',
    'inventory' => 'inventaire',
    'communications' => 'communiques',
    'settings' => 'parametres',
    'odds' => 'odd',
    'history' => 'historique'
];

$uri = $_SERVER['REQUEST_URI'] ?? '/panel/index';
$path = parse_url($uri, PHP_URL_PATH);
$segments = array_filter(explode('/', $path));
$uriSegment = strtolower(end($segments));
$activeKey = ($uriSegment === 'panel' || $uriSegment === '') ? 'index' : $uriSegment;
$currentPage = $linkMapping[$activeKey] ?? 'accueil';

function isActive(string $linkName, string $currentPage): string
{
    return $linkName === $currentPage ? ' active' : '';
}

function getPageTitle(string $page): string
{
    $titles = [
        'accueil' => 'Accueil',
        'statistiques' => 'Statistiques',
        'serveur' => 'Serveur',
        'inventaire' => 'Inventaire',
        'communiques' => 'Communiqués',
        'parametres' => 'Paramètres',
        'odd' => '17 ODD',
        'historique' => 'Historique'
    ];
    return $titles[$page] ?? 'Page Inconnue';
}

$pageTitle = getPageTitle($currentPage);

// Include the View
include(dirname(__FILE__, 2) . '/assets/view/panel.php');
?>