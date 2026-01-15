document.addEventListener('DOMContentLoaded', function() {
    console.log("Script Panier AJAX (Error Feedback) chargé !");

    const forms = document.querySelectorAll('.ajax-cart-form');

    forms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault(); 

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            
            // Sauvegarde du contenu original (si pas déjà fait)
            if (!submitBtn.dataset.originalContent) {
                submitBtn.dataset.originalContent = submitBtn.innerHTML;
            }

            // --- ÉTAT 1 : CHARGEMENT ---
            submitBtn.disabled = true;
            submitBtn.classList.add('btn-loading');
            submitBtn.innerHTML = '<span class="loading-dots">...</span>';

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const data = await response.json();

                // On retire le chargement
                submitBtn.classList.remove('btn-loading');

                if (data.status === 'success') {
                    // --- ÉTAT 2A : SUCCÈS (Vert) ---
                    submitBtn.classList.add('btn-success');
                    submitBtn.innerHTML = '✔ AJOUTÉ'; 

                    // Mise à jour du compteur
                    const cartCounter = document.getElementById('nav-cart-count');
                    if (cartCounter) {
                        cartCounter.innerText = data.total;
                        cartCounter.style.display = 'inline-block';
                        cartCounter.classList.add('bounce');
                        setTimeout(() => cartCounter.classList.remove('bounce'), 500);
                    }

                } else {
                    // --- ÉTAT 2B : ERREUR (Rouge) ---
                    // C'est ici que ça change : plus d'alert(), on modifie le bouton
                    submitBtn.classList.add('btn-error');
                    
                    // On affiche le message (ex: "Stock épuisé !")
                    // Si le message est trop long, le bouton s'agrandira ou on peut tronquer
                    submitBtn.innerHTML = `${data.message}`; 
                }

            } catch (error) {
                console.error('Erreur:', error);
                submitBtn.classList.remove('btn-loading');
                submitBtn.classList.add('btn-error');
                submitBtn.innerHTML = 'ERREUR RÉSEAU';
            } finally {
                // --- ÉTAT 3 : RETOUR À LA NORMALE (Après 3 secondes) ---
                // On laisse un peu plus de temps (3s) pour lire l'erreur
                setTimeout(() => {
                    submitBtn.classList.remove('btn-success', 'btn-error');
                    submitBtn.innerHTML = submitBtn.dataset.originalContent;
                    submitBtn.disabled = false;
                }, 1500); 
            }
        });
    });
});

