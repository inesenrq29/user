<!-- 
    Page principale du chat
    Cette page contient :
    - Un fond d'image de sneakers
    - Un conteneur pour le chat
    - Un bouton pour ouvrir le chat
-->

<!-- 
    Le body a une classe 'bg-light' pour un fond clair
    et une image de fond de sneakers en arrière-plan
-->
<body class="bg-light" style="background-image: url('<?= URL ?>public/assets/images/sneakers-bg.png')">

<!-- Conteneur principal de la page (vide pour l'instant) -->
<div class="container mt-4">
</div>

<!-- 
    Conteneur principal du chat
    La classe 'd-none' le cache par défaut (sera affiché en cliquant sur le logo)
    Toute la conversation se passe dans ce conteneur
-->
<div id="chatContainer" class="chat-container d-none">
    <!-- 
        En-tête du chat
        Contient le titre, le bouton pour terminer et le bouton pour fermer
    -->
    <div class="chat-header">
        <h5>Chat Sneak-Me</h5>
        <!-- Bouton pour terminer la conversation (efface l'historique) -->
        <button id="finishChat" class="btn btn-sm btn-outline-secondary me-2">
            Terminer le chat
        </button>
        <!-- Bouton pour fermer le chat (le cache) -->
        <button id="closeChat" class="close-chat">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <!-- 
        Zone des messages
        Affiche tous les messages de la conversation
        Les messages peuvent être de type 'user' (utilisateur) ou 'bot' (réponses)
    -->
    <div class="chat-messages">
        <?php if (!empty($responses)): ?>
            <!-- 
                Si il y a des messages dans l'historique ($responses)
                On les affiche un par un
            -->
            <?php foreach ($responses as $msg): ?>
                <!-- 
                    Chaque message a une classe différente selon son type
                    message-user : messages de l'utilisateur (à droite)
                    message-bot : réponses du bot (à gauche)
                -->
                <div class="message <?= $msg['type'] === 'user' ? 'message-user' : 'message-bot' ?>">
                    <!-- 
                        htmlspecialchars() protège contre les injections XSS
                        ENT_QUOTES : convertit les guillemets
                        UTF-8 : assure l'encodage correct des caractères spéciaux
                    -->
                    <?= htmlspecialchars($msg['content'], ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- 
                Si il n'y a pas de messages, on affiche un message de bienvenue
                La classe text-muted rend le texte en gris clair
            -->
            <div class="text-center text-muted">
                Bienvenue ! Posez-moi vos questions sur les sneakers.
            </div>
        <?php endif; ?>
    </div>

    <!-- 
        Zone de saisie des messages
        Contient le champ de texte et le bouton d'envoi
        d-flex : utilise flexbox pour aligner les éléments horizontalement
    -->
    <div class="chat-input d-flex">
        <!-- 
            Champ de texte pour écrire les messages
            autocomplete="off" : désactive l'auto-complétion
            me-2 : marge à droite pour l'espacement avec le bouton
        -->
        <input
                type="text"
                id="chatMessage"
                class="form-control me-2"
                placeholder="Posez votre question…"
                autocomplete="off"
        />
        <!-- Bouton pour envoyer le message -->
        <button id="sendChat" class="btn btn-primary">Envoyer</button>
    </div>
</div>

<!-- 
    Bouton pour ouvrir le chat (logo)
    Toujours visible sur la page
    Le style définit la taille et le curseur
-->
<div class="open-btn">

    <img
            id="toggleChatBtn"
            src="<?= URL ?>public/assets/images/logo-blue.png"
            alt="Ouvrir le chat"
            style="cursor: pointer; width: 10em; height: auto;"
    >

</div>

<!-- 
    Inclusion du fichier JavaScript qui gère le chat
    Ce script contient toute la logique d'interaction
-->
<script>
    const BASE_URL = "<?= URL ?>";
</script> 
<script src="<?= URL ?>public/assets/js/chatbot.js"></script>
<script src="<?= URL ?>public/assets/js/modal.js"></script>
</body>
</html>