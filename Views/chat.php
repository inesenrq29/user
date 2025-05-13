<body class="bg-light" style="background-image: url('<?= URL ?>public/assets/images/sneakers-bg.png')">
<div class="container mt-4">
    <!-- Votre contenu de page principal ici -->
</div>

<!-- Fenêtre de chat (cachée par défaut) -->
<div id="chatContainer" class="chat-container d-none">
    <div class="chat-header">
        <h5 class="mb-0">Chat Sneak-Me</h5>
        <button id="closeChat" class="close-chat">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="chat-messages">
        <?php if (!empty($responses)): ?>
            <?php foreach ($responses as $response): ?>
                <div class="message <?= $response['type'] === 'user' ? 'message-user' : 'message-bot'; ?>">
                    <div><?= htmlspecialchars($response['content'], ENT_QUOTES, 'UTF-8') ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center text-muted">
                Bienvenue ! Posez-moi vos questions sur les sneakers.
            </div>
        <?php endif; ?>
    </div>

    <div class="chat-input">
        <form method="POST" action="<?= URL ?>index.php" id="chatForm" class="d-flex">
            <input type="hidden" name="controller" value="message">
            <input type="hidden" name="action" value="message">
            <input type="text" name="message" class="form-control me-2" placeholder="Posez votre question..." required>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</div>

<!-- Bouton d’ouverture -->
<div class="open-btn">
    <img id="toggleChatBtn" src="<?= URL ?>public/assets/images/logo-blue.png" alt="Ouvrir le chat" style="cursor: pointer; width: 8.125em; height: auto;">
</div>

<script src="<?= URL ?>public/assets/js/chatbot.js"></script>
</body>
</html>