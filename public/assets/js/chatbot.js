// Attendre que le DOM (la page) soit complètement chargé avant d'exécuter le code
document.addEventListener('DOMContentLoaded', function() {
    // Récupération de tous les éléments HTML dont nous avons besoin
    // Ces éléments sont définis dans le fichier chat.php
    const chatBox     = document.getElementById('chatContainer');    // Le conteneur principal du chat
    const toggleBtn   = document.getElementById('toggleChatBtn');    // Le bouton pour ouvrir le chat
    const finishBtn   = document.getElementById('finishChat');       // Le bouton pour terminer la conversation
    const closeBtn    = document.getElementById('closeChat');        // Le bouton pour fermer le chat
    const sendBtn     = document.getElementById('sendChat');         // Le bouton pour envoyer un message
    const input       = document.getElementById('chatMessage');      // Le champ de texte pour écrire
    const messagesDiv = document.querySelector('.chat-messages');    // La zone où s'affichent les messages

    // Initialisation du chat
    // Stocke l'état du chat dans le localStorage (persiste même après fermeture du navigateur). 
    // ca veut dire due quand on charge le DOM la fenêtre est bien fermée
    localStorage.setItem('chatOpen', 'false');
    // Cache le chat au démarrage
    chatBox.classList.add('d-none');        // Ajoute la classe 'd-none' qui cache l'élément. La fenêtre est masquée
    toggleBtn.classList.remove('d-none');   // Enlève la classe 'd-none' pour afficher le bouton. Le bouton est visible

    // Gestion de l'ouverture du chat
    toggleBtn.addEventListener('click', function() {
        chatBox.classList.remove('d-none');     // Affiche le chat
        toggleBtn.classList.add('d-none');      // Cache le bouton d'ouverture
        localStorage.setItem('chatOpen', 'true'); // Met à jour l'état dans le localStorage
    });

    // Gestion de la fermeture du chat
    closeBtn.addEventListener('click', function() {
        chatBox.classList.add('d-none');        // Cache le chat 
        toggleBtn.classList.remove('d-none');   // Affiche le bouton d'ouverture
        localStorage.setItem('chatOpen', 'false'); // Met à jour l'état dans le localStorage
    });

    // Gestion de la fin de conversation
    finishBtn.addEventListener('click', function() {
        // Création d'un objet FormData pour envoyer les données au serveur
        const fd = new FormData();
        fd.append('controller', 'message');  // Indique quel contrôleur utiliser
        fd.append('action', 'clear');        // Indique quelle action effectuer

        // Envoi de la requête au serveur pour effacer l'historique
         fetch(BASE_URL + 'index.php', {
            method: 'POST',                  // Méthode HTTP POST
            body: fd,                        // Les données à envoyer
            headers: {'X-Requested-With': 'XMLHttpRequest'} // Indique que c'est une requête AJAX
        })
            .then(r => r.json())            // Convertit la réponse en JSON. normalement un tableau vide car on a clear
            .then(() => {
                // Réinitialise la fenêtre de chat
                messagesDiv.innerHTML = '<div class="text-center text-muted">Bienvenue ! Posez-moi vos questions sur les sneakers.</div>';
                chatBox.classList.add('d-none');
                toggleBtn.classList.remove('d-none');
                localStorage.setItem('chatOpen', 'false');
            })
            .then(() => {window.location.reload();}) // Recharge la page et s'assurer ainsi que la session est bien clear
            .catch(console.error);           // Affiche les erreurs dans la console
    });

    // Fonction pour faire défiler la conversation vers le bas = clean code (on crée la fonction pour eviter de mettre 
    // messagesDiv.scrollTop = messagesDiv.scrollHeight à chaque fois qu'on veut scroller. 
    // Le jour ou j'ai besoin de modifier, il me suffira de modifier la fonction au lieu de rechercher les croll dans tout le code )
    function scrollBottom() {
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
    scrollBottom(); // Défile vers le bas au chargement

    // Fonction principale pour envoyer un message
    function sendMessage() {
        const text = input.value.trim(); // Récupère et nettoie le texte
        if (!text) return; // Ne fait rien si le message est vide

        // Ajoute le message de l'utilisateur
        const u = document.createElement('div');
        u.className = 'message message-user';
        u.textContent = text;
        messagesDiv.appendChild(u);
        scrollBottom();

        // Ajoute un indicateur de chargement 
        const loadingDiv = document.createElement('div')
        loadingDiv.className = 'message message-bot'
        loadingDiv.innerHTML = '<div class="typing-indicator"></div>'
        messagesDiv.appendChild(loadingDiv)
        scrollBottom();

        // Prépare les données à envoyer
        const fd = new FormData();
        fd.append('controller', 'message');
        fd.append('action', 'message');
        fd.append('message', text);

        // Mesure le temps pour assurer un délai minimum
        const start = Date.now(), MIN = 600; // 600ms de délai minimum

        // Envoie la requête au serveur
         fetch(BASE_URL + 'index.php', {
            method: 'POST',
            body: fd,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
            .then(r => r.json())            // Convertit la réponse en JSON
            .then(chat => {
                console.log(chat)            // Affiche la réponse du serveur dans la console (utile pour le débogage)
                // Calcule le temps d'attente pour respecter le délai minimum
                const wait = Math.max(0, MIN - (Date.now() - start));
                setTimeout(() => {
                    // Efface tous les messages
                    messagesDiv.innerHTML = '';
                    // Ajoute chaque message de la conversation
                    chat.forEach(m => {
                        const d = document.createElement('div');
                        // Choisit la classe CSS selon le type de message (user ou bot)
                        d.className = 'message ' + (m.type === 'user' ? 'message-user' : 'message-bot');
                        d.textContent = m.content;
                        //affichage du message
                        messagesDiv.appendChild(d); 
                    });
                    scrollBottom();
                }, wait);
            })
            .catch(err => {
                console.error(err);
                loadingDiv.innerHTML = 'Erreur réseau…';
            });

        input.value = ''; // Vide le champ de texte
    }

    // Événements pour envoyer un message
    sendBtn.addEventListener('click', sendMessage); // Clic sur le bouton d'envoi
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') { // Appui sur la touche Entrée
            e.preventDefault();   // Empêche le comportement par défaut
            sendMessage();
        }
    });
});