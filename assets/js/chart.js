
    const couleurs = ['#f7b760', '#9d3363', '#457b9d', '#546b8b', '#e63946', '#4cc9f0']; 
    const composantes = ['IUT Le Mans', 'IUT Laval', 'ENSIM', 'Faculté des Lettres, Langues & Sciences Humaines', 'Faculté des Droit, Sciences Économiques & de Gestion', 'Faculté des Sciences & Techniques'];
    const pourcentages = [28, 9, 11, 22, 34, 13]; 
    const lineData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
            {
                label: 'IUT Le Mans',
                data: [3, 4, 6, 8, 10, 11, 12, 14, 15, 16, 18, 19],
                borderColor: couleurs[0],
                tension: 0.4,
                fill: false
            },
            {
                label: 'Faculté des Lettres, Langues & Sciences Humaines',
                data: [1, 2, 3, 5, 8, 9, 11, 13, 15, 17, 18, 20],
                borderColor: couleurs[3],
                tension: 0.4,
                fill: false
            },
            {
                label: 'Faculté des Sciences & Techniques',
                data: [2, 3, 5, 7, 9, 10, 11, 12, 13, 15, 16, 18],
                borderColor: couleurs[5],
                tension: 0.4,
                fill: false
            }
        ]
    };

    const ctxPie = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctxPie, {
        type: 'doughnut', 
        data: {
            labels: composantes,
            datasets: [{
                data: pourcentages,
                backgroundColor: couleurs,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += context.parsed + '%';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    const ctxLine = document.getElementById('lineChart').getContext('2d');
    const lineChart = new Chart(ctxLine, {
        type: 'line',
        data: lineData,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom', 
                    labels: {
                        boxWidth: 20,
                    }
                },
                title: {
                    display: true,
                    text: 'Objets ajoutés (journalier)',
                    position: 'left',
                    align: 'start',
                    font: {
                        size: 14,
                        weight: 'normal'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Objets ajoutés (par jour)', 
                        font: {
                            size: 12
                        }
                    },
                    max: 25, 
                },
                x: {
                    title: {
                        display: false,
                    }
                }
            }
        }
    });