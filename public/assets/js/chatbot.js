document.addEventListener('DOMContentLoaded', function() { //permet de ne pas recharger la page
    //récupère les éléments de la page
    const chatBox     = document.getElementById('chatContainer');
    const toggleBtn   = document.getElementById('toggleChatBtn');
    const finishBtn   = document.getElementById('finishChat'); //bouton pour terminer le chat
    const closeBtn    = document.getElementById('closeChat');
    const sendBtn     = document.getElementById('sendChat');
    const input       = document.getElementById('chatMessage');
    const messagesDiv = document.querySelector('.chat-messages');

    localStorage.setItem('chatOpen', 'false'); //au chargement de la page: la fenetre de chat est fermée
    chatBox.classList.add('d-none');
    toggleBtn.classList.remove('d-none');

    toggleBtn.addEventListener('click', function() { //au clic du bouton pour ouvrir le chat
        chatBox.classList.remove('d-none'); //enlève la propriété display none à la fenetre de chat
        toggleBtn.classList.add('d-none'); //on ajoute la propriété display none au logo pour ouvrir le chat
        localStorage.setItem('chatOpen', 'true'); //on associe chatOpen à true (donc fenetre ouverte = true en gros)
    });

    closeBtn.addEventListener('click', function() { //au clic du bouton pour fermer le chat
        chatBox.classList.add('d-none'); //on display none la fenetre de chat
        toggleBtn.classList.remove('d-none'); //on enleve la propriété display none au logo pour ouvrir le chat
        localStorage.setItem('chatOpen', 'false'); //on met chatOpen à false pour indiquer que la fenetre de chat est fermée
    });

    finishBtn.addEventListener('click', function() { //au clic du bouton terminer le chat
        const fd = new FormData(); //création de l'objet FormData qui permet de construire un ensemble de paires clé-valeur, idéal pour envoyer des données de formulaire via des requêtes HTTP
        fd.append('controller', 'message'); //la clé controller est associée à la valeur message
        fd.append('action', 'clear'); //la clé action est associée à la valeur clear (présent dans messageController)

        fetch(BASE_URL + 'index.php', {
            method: 'POST',
            body: fd,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
            .then(r => r.json()) //résultat en json (ici r serait un tableau vide)
            .then(() => {

                messagesDiv.innerHTML =
                    '<div class="text-center text-muted">Bienvenue ! Posez-moi vos questions sur les sneakers.</div>'; //ajout d'une div contenant du texte (en réalité la fenetre contenant les messages)

                chatBox.classList.add('d-none'); //ajout de la propriété display none à la fenetre de chat
                toggleBtn.classList.remove('d-none'); //on retire la proriété display none au logo pour ouvrir le chat
                localStorage.setItem('chatOpen', 'false'); //la fenetre de chat est donc à false car elle est fermée
            })
            .then(() => {window.location.reload();}) //recharge la page pour s'assurer que la session est bien purgée
            .catch(console.error); //sinon => affiche une erreur
    });

    function scrollBottom() { //fonction pour scroller vers le bas
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
    scrollBottom();

    function sendMessage() { //fonction pour envoyer un message
        const text = input.value.trim(); //saisie du texte contenu dans l'input
        if (!text) return; //si pas de texte dans zone de saisie, on s'arrete la

        const u = document.createElement('div'); //u => une div créée
        u.className = 'message message-user'; //on appelle cette div par une classe message message-user
        u.textContent = text; //permet de définir ou obtenir le contenu texte brut de la div
        messagesDiv.appendChild(u); //permet d'intégrer la div u dans la div messagesDiv (donc on intègre les messages dans la fenetre de chat)
        scrollBottom(); //on scroll

        const loadingDiv = document.createElement('div'); //on créé une div qui permettra de faire le loading
        loadingDiv.className = 'message message-bot'; //on appelle cette div par une classe
        loadingDiv.innerHTML = '<div class="typing-indicator"></div>'; //ajoute du contenu dans la div loading 
        messagesDiv.appendChild(loadingDiv);//permet d'intégrer la div de loading dans la div messagesDiv
        scrollBottom(); //on scroll

        const fd = new FormData(); //création d'un formData
        fd.append('controller', 'message'); //la clé controller est associée à la valeur message
        fd.append('action', 'message'); //la clé action est associée à la valeur message
        fd.append('message', text); //la clé message est associée à un texte

        const start = Date.now(), MIN = 600; //retourne un nombre de milliseconde
        fetch(BASE_URL + 'index.php', { //effectue une requete contenant l'URL de base
            method: 'POST',
            body: fd,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
            .then(r => r.json()) //réponse en json
            .then(chat => {
                console.log(chat)
                const wait = Math.max(0, MIN - (Date.now() - start)); //calcule le temps restant avant d'atteindre un certain délai
                setTimeout(() => { //utilisé pour exécuter une fonction après un certain délai
                    messagesDiv.innerHTML = ''; //on vide le contenu actuel de la div
                    chat.forEach(m => { // pour chaque message dans le chat
                        const d = document.createElement('div'); // on va créer une div
                        d.className = 'message ' + (m.type === 'user' ? 'message-user' : 'message-bot'); //on ajoute une classe en fonction de si c'est le user ou le bot
                        d.textContent = m.content; //définit le texte du message à afficher et m.content représente le contenu du message
                        messagesDiv.appendChild(d); //on ajoute les messages dans la div de la fenetre de chat
                    });
                    scrollBottom(); //on scroll
                }, wait); //calcule le temps restant avant d'atteindre un certain délai
            })
            .catch(err => { //sinon on affiche une erreur réseau
                console.error(err);
                loadingDiv.innerHTML = 'Erreur réseau…';
            });

        input.value = ''; //on réinit l'input à un champ vide
    }

    sendBtn.addEventListener('click', sendMessage); //au clic du bouton envoyer, on effectue la fonction sendMessage du dessus
    input.addEventListener('keypress', function(e) { //au ENTER dans input, on ne recherche pas la page et on effectue la fonction sendMessage
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });
});
