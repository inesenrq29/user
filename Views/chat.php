<body class="bg-light" style="background-image: url('<?= URL ?>public/assets/images/sneakers-bg.png')">
    <div class="container mt-4"> 
        <div id="chatContainer" class="chat-container d-none">
            <div class="chat-header">
                <h5 class="mb-0">Chat Sneak-Me</h5>
                <button id="closeChat" class="close-chat"><i class="fa-solid fa-xmark" style="align-content: center" ></i></button>
            </div>

            <div class="chat-messages">
                <?php if (!empty($responses)): ?>
                    <?php foreach ($responses as $response): ?>
                        <div class="message <?php echo $response['type'] === 'user' ? 'message-user' : 'message-bot'; ?>">
                            <div><?php echo $response['content']; ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted">
                        Bienvenue ! Posez-moi vos questions sur les sneakers.
                    </div>
                <?php endif; ?>
            </div>

            <div class="chat-input">
                <form method="POST" action="<?= URL ?>index.php" class="d-flex" id="chatForm">
                    <input type="hidden" name="controller" value="message">
                    <input type="hidden" name="action" value="message">
                    <input type="text" name="message" class="form-control me-2" placeholder="Posez votre question..." required>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
        <div class="open-btn"><img id="toggleChatBtn" src='<?= URL ?>public/assets/images/logo-blue.png' style="cursor: pointer; width: 100px; height: auto;"> 
        </div> 
    </div>

    <script src="<?= URL ?>public/assets/js/chatbot.js"></script>
</body>
</html>