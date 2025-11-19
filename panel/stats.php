<?php
include_once __DIR__ . '/assets/src/conn.php';
$allowed_roles = [1, 2, 3, 4, 5];

if (!in_array($role_id, $allowed_roles)) {
    header('Location: ?view=accueil'); 
    exit;
}

$line_chart_data = [
    'Jan' => [2, 0, 1, 0], 'Feb' => [4, 2, 3, 1], 'Mar' => [8, 5, 6, 2],
    'Apr' => [10, 8, 9, 5], 'May' => [12, 11, 11, 8], 'Jun' => [15, 14, 13, 11],
    'Jul' => [16, 15, 14, 13], 'Aug' => [18, 17, 16, 15], 'Sep' => [19, 18, 17, 16],
    'Oct' => [21, 20, 19, 18], 'Nov' => [23, 22, 21, 20], 'Dec' => [24, 23, 22, 21],
];

$donut_data = [
    ['label' => 'IUT Le Mans', 'value' => 28, 'color' => '#f2994a'],
    ['label' => 'IUT Laval', 'value' => 9, 'color' => '#eb5757'],
    ['label' => 'ENSIM', 'value' => 11, 'color' => '#56ccf2'],
    ['label' => 'Faculté des Lettres, Langues & Sciences Humaines', 'value' => 22, 'color' => '#6f42c1'],
    ['label' => 'Faculté des Droits, Sciences Économiques & de Gestion', 'value' => 17, 'color' => '#d45d7d'],
    ['label' => 'Faculté des Sciences & Techniques', 'value' => 13, 'color' => '#2d9cdb'],
];
?>

<div class="page-header">
    <h2>Statistiques</h2>
</div>

<section class="stat-charts-row">
    
    <div class="stat-cards-group">
        <div class="stat-card">
            <h3>Objets recyclés ce mois-ci</h3>
            <div class="stat-value"><?= $objets_recycles ?> <i class="fas fa-arrow-up green"></i></div>
            <p class="stat-detail"><span class="green">15 de plus</span> que le mois dernier</p>
        </div>

        <div class="stat-card">
            <h3>Nouveaux objets enregistrés ce mois-ci</h3>
            <div class="stat-value"><?= $nouveaux_objets ?> <i class="fas fa-arrow-down red"></i></div>
            <p class="stat-detail"><span class="red">9 de moins</span> que le mois dernier</p>
        </div>

        <div class="stat-card composante-card">
            <h3>Composante la plus active</h3>
            <p class="composante-name-full"><?= htmlspecialchars($composante_active) ?></p>
            <p class="composante-details"><?= $objets_recycles_composante ?> objets recyclés ce mois ci <i class="fas fa-arrow-up green"></i></p>
        </div>
    </div>

    <div class="chart-container donut-chart-card">
        <h3>Répartition des recyclages par composante de l'université</h3>
        <div class="chart-and-legend-wrapper">
            <div class="donut-chart-wrapper">
                <canvas id="donutChart"></canvas>
            </div>
            <div class="chart-legend">
                <h4>Légende</h4>
                <?php foreach ($donut_data as $item): ?>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: <?= $item['color'] ?>;"></span>
                        <span class="legend-percentage"><?= $item['value'] ?>%</span>
                        <span class="legend-label"><?= htmlspecialchars($item['label']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</section>

<section class="line-chart-row">
    <div class="chart-container">
        <canvas id="lineChart"></canvas>
    </div>
</section>

<section class="rapport-section">
    <h3>Rapport</h3>
    <div class="rapport-controls">
        <p>Générer un rapport du</p>
        <input type="text" placeholder="jj/mm/aaaa" class="date-input">
        <p>au</p>
        <input type="text" placeholder="jj/mm/aaaa" class="date-input">
        <button class="button blue">Générer</button>
    </div>
</section>

<script>
    const donutData = <?= json_encode($donut_data) ?>;
    const lineChartData = <?= json_encode($line_chart_data) ?>;

    const donutCtx = document.getElementById('donutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: donutData.map(d => d.label),
            datasets: [{
                data: donutData.map(d => d.value),
                backgroundColor: donutData.map(d => d.color),
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    display: false 
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.formattedValue + '%';
                        }
                    }
                }
            }
        }
    });

    const lineCtx = document.getElementById('lineChart').getContext('2d');
    const labels = Object.keys(lineChartData);
    const datasets = [
        { label: 'Ligne 1', data: Object.values(lineChartData).map(v => v[0]), borderColor: '#f2994a', tension: 0.3 },
        { label: 'Ligne 2', data: Object.values(lineChartData).map(v => v[1]), borderColor: '#eb5757', tension: 0.3 },
        { label: 'Ligne 3', data: Object.values(lineChartData).map(v => v[2]), borderColor: '#56ccf2', tension: 0.3 },
        { label: 'Ligne 4', data: Object.values(lineChartData).map(v => v[3]), borderColor: '#6f42c1', tension: 0.3 }
    ];

    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false 
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Objet ajoutés (jour)'
                    }
                }
            }
        }
    });
</script>