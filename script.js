document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('citation-form');
    const addCitationButton = document.getElementById('add-citation');
    const showCitationsButton = document.getElementById('show-citations');
    const citationsList = document.getElementById('citations-list');

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const auteur = document.getElementById('auteur').value.trim();
        const citation = document.getElementById('citation').value.trim();

        if (!auteur || !citation) {
            alert('Veuillez remplir tous les champs.');
            return;
        }

        fetch('http://localhost:8000/api_bdd.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ auteur: auteur, texte: citation })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP : ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                alert('Citation ajoutée avec succès !');
                form.reset();
            })
            .catch(error => {
                console.error('Erreur lors de l\'ajout de la citation :', error);
                alert('Une erreur est survenue lors de l\'ajout.');
            });
    });

    showCitationsButton.addEventListener('click', () => {
        setInterval(() => {
            fetch('http://localhost:8000/api_bdd.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Erreur HTTP : ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.length === 0) {
                        citationsList.innerHTML = `<p>Aucune citation trouvée.</p>`;
                        return;
                    }
        
                    const citationsHtml = data.map(citation => `
                        <div class="citation-item">
                            <p><strong>Auteur :</strong> ${citation.auteur}</p>
                            <p><strong>Citation :</strong> ${citation.texte}</p>
                        </div>
                    `).join('');
                    citationsList.innerHTML = citationsHtml;
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des citations :', error);
                    citationsList.innerHTML = `<p>Une erreur est survenue. Veuillez réessayer plus tard.</p>`;
                });
        }, 1000);
    });
});