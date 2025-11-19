<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ?view=inventory');
    exit;
}
$allowed_roles = ['admin', 'inventory_manager', 'responsable']; // ajuster selon projet
if (!in_array($_SESSION['role'] ?? '', $allowed_roles, true)) {
    header('HTTP/1.1 403 Forbidden');
    echo 'Accès non autorisé';
    exit;
}
require_once __DIR__ . '/../includes/db.php'; // doit définir $pdo ou $conn
$sql = "
    SELECT
      i.id,
      i.name AS nom,
      i.quantity AS quantite,
      i.component AS composante,
      c.name AS categorie,
      i.cond AS etat,
      i.status AS statut
    FROM inventory i
    LEFT JOIN categories c ON i.category_id = c.id
    ORDER BY c.name, i.name
";

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
        case 'hors service': return '<span class="badge badge-danger">Hors service</span>';
        default: return '<span class="badge badge-secondary">'.esc($etat).'</span>';
    }
}
function labelStatut($s) {
    $st = strtolower($s ?? '');
    switch ($st) {
        case 'disponible': return '<span class="badge badge-success">Disponible</span>';
        case 'emprunte': return '<span class="badge badge-warning">Emprunté</span>';
        case 'perdu': return '<span class="badge badge-danger">Perdu</span>';
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
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <style>
    body { padding: 20px; }
    .table-fixed { table-layout: fixed; word-wrap: break-word; }
  </style>
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
          <th style="width:35%;">Nom</th>
          <th style="width:8%;">Quantité</th>
          <th style="width:15%;">Composante</th>
          <th style="width:15%;">Catégorie</th>
          <th style="width:12%;">État</th>
          <th style="width:15%;">Statut</th>
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
              <td><?php echo esc($it['composante']); ?></td>
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