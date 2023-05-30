// Contenu du fichier athlete-parametres.js
const blocSuiviBestPerfs1 = document.getElementById("bloc-suivi-bestperfs-1");
const blocSuiviPoids = document.getElementById("bloc-suivi-poids");
const blocSuiviForce = document.getElementById("bloc-suivi-force");
const blocSuiviBestPerfs2 = document.getElementById("bloc-suivi-bestperfs-2");

const elements = [blocSuiviBestPerfs1, blocSuiviPoids, blocSuiviForce, blocSuiviBestPerfs2];
const popups = document.querySelectorAll(".popup");
const popupContents = document.querySelectorAll(".popup-content");
const closes = document.querySelectorAll(".close");
const popupCharts = [];

elements.forEach((element, i) => {
    element.addEventListener("click", () => {
        // Création du graphique de la fenêtre pop-up
        popupCharts[i] = new Chart(
            document.getElementById(`popup-chart${i + 1}`),
            {
                type: "line",
                data: {
                    labels: ['date1', 'date2', 'date3', 'date4', 'date5'], // Remplacer les dates par celles souhaitées.
                    datasets: [{
                        label: `Graphique ${i + 1}`,
                        backgroundColor: 'rgb(54, 162, 235)',
                        borderColor: 'rgb(54, 162, 235)',
                        data: [10, 10, 12.5, 15, 15], // Remplacer les valeurs par celles souhaitées.
                        tension: 0.5,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Force (kg)'
                            }
                        },
                        x: {
                            title: {
                                display: true
                            }
                        }
                    }
                }
            }
        );

        // Affichage de la fenêtre pop-up
        popupContents[i].style.width = "calc(16 / 9 * 80vh)";
        popupContents[i].style.height = "80vh";
        popupContents[i].style.top = "50%";
        popupContents[i].style.left = "50%";
        popupContents[i].style.transform = "translate(-50%, -50%)";
        popups[i].style.display = "block";
        document.body.classList.add('no-scroll');
        window.scrollTo(0, 0);

        // Fermeture de la fenêtre pop-up lorsqu'on clique en dehors
        window.onclick = (event) => {
            if (event.target === popups[i]) {
                // Réinitialisation du contenu de la fenêtre pop-up
                popupCharts[i].destroy();
                popups[i].style.display = "none";
                document.body.classList.remove('no-scroll');
            }
        }
    });

    closes[i].addEventListener("click", () => {
        // Réinitialisation du contenu de la fenêtre pop-up
        popupCharts[i].destroy();
        popups[i].style.display = "none";
        document.body.classList.remove('no-scroll');
    });
});