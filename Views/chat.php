<body class="bg-light" style="background-image: url('<?= URL ?>public/assets/images/sneakers-bg.png')">
<div class="container mt-4">
</div>

<div id="chatContainer" class="chat-container d-none">
    <div class="chat-header">
        <h5>Chat Sneak-Me</h5>
        <button id="finishChat" class="btn btn-sm btn-outline-secondary me-2">
            Terminer le chat
        </button>
        <button id="closeChat" class="close-chat">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="chat-messages">
        <?php if (!empty($responses)): ?>
            <?php foreach ($responses as $msg): ?>
                <div class="message <?= $msg['type'] === 'user' ? 'message-user' : 'message-bot' ?>">
                    <?= htmlspecialchars($msg['content'], ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center text-muted">
                Bienvenue ! Posez-moi vos questions sur les sneakers.
            </div>
        <?php endif; ?>
    </div>

    <div class="chat-input d-flex">
        <input
                type="text"
                id="chatMessage"
                class="form-control me-2"
                placeholder="Posez votre question…"
                autocomplete="off"
        />
        <button id="sendChat" class="btn btn-primary">Envoyer</button>
    </div>
</div>

<div class="open-btn">
    <img
            id="toggleChatBtn"
            src="<?= URL ?>public/assets/images/logo-blue.png"
            alt="Ouvrir le chat"
            style="cursor: pointer; width: 10em; height: auto;"
    >
</div>

<script>
    const BASE_URL = "<?= URL ?>";
</script>
<script src="<?= URL ?>public/assets/js/chatbot.js"></script>
</body>
</html>