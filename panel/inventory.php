<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ?view=inventory');
    exit;
}
$allowed_role_ids = [1, 2, 3, 4, 5]; 

if (!in_array($_SESSION['role_id'] ?? 0, $allowed_role_ids, true)) {
    header('HTTP/1.1 403 Forbidden');
    echo 'Accès non autorisé';
    exit;
}
require_once __DIR__ . '/../includes/db.php';

$sql_path = __DIR__ . '/../sae301.sql';
if (!is_readable($sql_path)) {
    die('Fichier SQL introuvable: ' . htmlspecialchars($sql_path));
}
$sql = file_get_contents($sql_path);
if ($sql === false) {
    die('Impossible de lire le fichier SQL.');
}
$sql = trim($sql);

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('Erreur BDD: ' . htmlspecialchars($e->getMessage()));
}
function esc($s) { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
function labelEtat($etat) {
    $e = strtolower($etat ?? '');
    switch ($e) {
        case 'neuf': return '<span class="badge badge-success">Neuf</span>';
        case 'bon': return '<span class="badge badge-primary">Bon</span>';
        case 'mauvais': return '<span class="badge badge-warning">Mauvais</span>';
        case 'hs':
        case 'hors service': return '<span class="badge badge-danger">Hors service</span>';
        default: return '<span class="badge badge-secondary">'.esc($etat).'</span>';
    }
}
function labelStatut($s) {
    $st = strtolower($s ?? '');
    switch ($st) {
        case 'en attente': return '<span class="badge badge-warning">En attente</span>';
        case 'en réutilisation': return '<span class="badge badge-success">En réutilisation</span>';
        case 'en élimination': return '<span class="badge badge-danger">En élimination</span>';
        default: return '<span class="badge badge-secondary">'.esc($s).'</span>';
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Inventaire - EcoGestUM</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../assets/css/panel-inventory.css">
</head>
<body>
<?php
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container">
  <h1 class="mb-3">Inventaire des objets</h1>
  <p class="text-muted">Liste des objets disponibles à l'université avec leur catégorie, état et statut.</p>

  <div class="table-responsive">
    <table class="table table-striped table-bordered table-fixed">
      <thead class="thead-dark">
        <tr>
          <th1>Nom</th1>
          <th2>Quantité</th2>
          <th3>Composante</th3>
          <th4>Catégorie</th4>
          <th5>État</th5>
          <th6>Statut</th6>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($items)): ?>
          <tr><td colspan="6" class="text-center">Aucun élément trouvé.</td></tr>
        <?php else: ?>
          <?php foreach ($items as $it): ?>
            <tr>
              <td><?php echo esc($it['nom']); ?></td>
              <td class="text-center"><?php echo esc($it['quantite']); ?></td>
              <td><?php echo esc($it['composante'] ?? '—'); ?></td>
              <td><?php echo esc($it['categorie'] ?? '—'); ?></td>
              <td><?php echo labelEtat($it['etat']); ?></td>
              <td><?php echo labelStatut($it['statut']); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>