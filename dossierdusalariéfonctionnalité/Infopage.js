const mois = [
    "Janvier", 
    "Fevrier", 
    "Mars",
    "Avril",
    "Mai", 
    "Juin", 
    "Juillet",
    "Aout", 
    "Septembre", 
    "Octobre", 
    "Novembre", 
    "Decembre"
];
function getWeek(date) {
    // Copier la date pour ne pas la modifier
    var target = new Date(date.valueOf());

    // Réinitialiser au début de l'année
    target.setHours(0, 0, 0, 0);
    target.setDate(target.getDate() + 4 - (target.getDay() || 7));

    // Calculer le numéro de la semaine
    var yearStart = new Date(target.getFullYear(), 0, 1);
    var weekNumber = Math.ceil((((target - yearStart) / 86400000) + 1) / 7);

    return weekNumber;
}

var conge_liste = [];
var horaires_liste = [];
var absence_liste =[]
var bool1 = false;
var bool2 = false;
var bool3 = false;
var nb_de_conge = 0;
var nbjours_du_mois = new Date();
var mois_actuel = nbjours_du_mois.getMonth();
var annee = nbjours_du_mois.getFullYear();
var jour_de_la_semaine = 0;
var ligne_du_mois = 1;
function getCookie(name) {
    let value = `; ${document.cookie}`;
    let parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}


function lireCSVcongés(url,callback) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            const joursConges = data.split(',').map(conge => {
                const [mois, jour] = conge.split('-');
                return { mois: parseInt(mois), jour: parseInt(jour) };
            });
            conge_liste = joursConges;
           
            callback(joursConges);
           
        });
}

lireCSVcongés('congés.csv', function(joursConges) {
    bool1 =true
    verifAffichage();
});


function lireCSV_horaires(url, callback) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            // Séparer les lignes du CSV
            const lignes = data.split('\n');

            // Initialiser un tableau pour les horaires
            const horaires = [];

            // Traiter chaque ligne
            lignes.forEach(ligne => {
                // Séparer les horaires de chaque jour
                const horairesJour = ligne.split(',');

                // Ajouter les horaires de la ligne actuelle au tableau des horaires
                horaires.push(horairesJour);
            });
            //console.log(horaires)
            horaires_liste = horaires;
            // Appeler le callback avec les horaires
            callback(horaires);
        });
}
    lireCSV_horaires('horaires.csv', function(heure) {
        bool2 = true;
    verifAffichage();
});


function lireCSV_absence(url, callback) {
    fetch(url)
    .then(response => response.text())
    .then(data => {
        const absence = data.split(',').map(abs => {
            const [mois, jour] = abs.split('-');
            return { mois: parseInt(mois), jour: parseInt(jour) };
        });
        absence_liste = absence;
        console.log(absence_liste)
        callback(absence);
       
    });
}

lireCSV_absence('Absences.csv', function(absence) {
    bool3 = true;
verifAffichage();
});

function verifAffichage() 
{
    if (bool1 & bool2 & bool3) 
    {
        afficheCalendrier();
    }
}

function afficheCalendrier() {
    var premier_jour = new Date(annee, mois_actuel, 1).getDay();
    const dernier_numj_mois_actuel = new Date(annee, mois_actuel + 1, 0).getDate();
    const dernier_numj_mois_precedent = new Date(annee, mois_actuel, 0).getDate();

    // Mise à jour du mois affiché
    document.getElementById("mois").innerHTML = mois[mois_actuel];

    // Réinitialiser les lignes du calendrier
    for (let a = 1; a <= 6; a++) {
        document.getElementById("ligne" + a).innerHTML = '';
    }

    var j = 0;
    var l = 1;
    var ligne = document.getElementById("ligne" + l);

    // Ajouter les jours du mois précédent
    for (let i = premier_jour; i > 0; i--) {
        j += 1;
        var newday = document.createElement("div");
        newday.className = 'day';
        newday.innerHTML = dernier_numj_mois_precedent - i + 1;
        ligne.appendChild(newday);
    }

    // Calcul du numéro de semaine pour le premier jour du mois
    var maDate = new Date(annee, mois_actuel, 1);
    var numeroSemaine = getWeek(maDate) ; // Ajouter +1 si nécessaire en fonction de votre définition de semaine
    console.log("Numéro de semaine:", numeroSemaine);

    // Ajouter les jours du mois actuel
    for (let i = 1; i <= dernier_numj_mois_actuel; i++) {
        j += 1;
        var newday = document.createElement("div");
        newday.innerHTML = i;

        if (conge_liste.some(conge => conge.jour === i && conge.mois === mois_actuel + 1)) {
            newday.classList.add('conge');
        } else if (absence_liste.some(abs => abs.jour === i && abs.mois === mois_actuel + 1)) {
            newday.classList.add('Absence');
        }else if (horaires_liste[numeroSemaine] && horaires_liste[numeroSemaine][j - 1] !== '0' && horaires_liste[numeroSemaine][j - 1] !== 'pi') {
            newday.innerHTML += " <svg width='8' height='8' viewBox='0 0 100 100'><circle cx='50' cy='50' r='50' fill='#7293DA' /></svg>";
            newday.classList.add('jourhoraire');
        } else if (horaires_liste[numeroSemaine] && horaires_liste[numeroSemaine][j - 1] === 'pi') {
            newday.classList.add('pi');
        } 

        ligne.appendChild(newday);

        // Incrémenter le numéro de semaine correctement
        if (j === 7) {
            j = 0;
            l += 1;
            ligne = document.getElementById("ligne" + l);
            numeroSemaine += 1; // Incrémenter seulement à la fin de chaque semaine
        }
    }

    var nb_de_conge = conge_liste.length -30;
    var pourcentage = nb_de_conge / 30 ; // Supposons que la base est 30
    pourcentage = pourcentage*100;
    var element = document.getElementById("jauge");
    if (element) {
        element.style.width = pourcentage + "%";
    } else {
        console.error("L'élément avec l'ID 'jauge' n'existe pas.");
    }

    var conge_utilse = document.getElementById("utilise");
    if (conge_utilse) 
        conge_utilse.innerHTML = nb_de_conge;
  
}

function envoyerMoisAuServeur(mois, annee) {
        const formData = new FormData();
        formData.append('mois', mois + 1); // Mois en format 1-12
        formData.append('annee', annee);
        console.log(formData.get('mois'));
        fetch('calendrier.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log("arrive au bout");
            console.log(data);
            document.querySelector('.infotext').innerHTML = data;
        })
        .catch(error => console.error('Erreur:', error));
    }

document.addEventListener('DOMContentLoaded', (event) => {
    const buttons = document.querySelectorAll('button');

    buttons.forEach(button => {
        button.addEventListener('click', (event) => {
            if (event.target.id === 'prev') {
                if (mois_actuel === 0) {
                    annee--;
                    mois_actuel = 11;
                } else {
                    mois_actuel--;
                }
            } else if (event.target.id === 'next') {
                if (mois_actuel === 11) {
                    annee++;
                    mois_actuel = 0;
                } else {
                    mois_actuel++;
                }
            }

            nbjours_du_mois = new Date(annee, mois_actuel, new Date().getDate());
            envoyerMoisAuServeur(mois_actuel,annee);
            afficheCalendrier();
        });
    });

    afficheCalendrier();
});
