const form = document.getElementById('searchForm');

// Écoute de l'événement input sur les champs de formulaire pertinents
const inputFields = form.querySelectorAll('input, textarea');
inputFields.forEach(field => {
    field.addEventListener('input', event => {
        event.preventDefault();
        const data = new FormData(form);
        fetch('traitement.php', {
            method: 'POST',
            body: data
        })
        .then(response => response.text())
        .then(result => {
            document.getElementById('result').innerHTML = result;
        })
        .catch(error => {
            console.error(error);
        });
    });
});