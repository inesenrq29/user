<body class="bg-light" style="background-image: url('<?= URL ?>public/assets/images/sneakers-bg.png')">
    <div class="container mt-4">
        <div class="chat-container">
            <div class="chat-header">
                <h5 class="mb-0">Chat Sneak-Me</h5>
            </div>

            <div class="chat-messages">
                <?php if (!empty($responses)): ?>
                    <?php foreach ($responses as $response): ?>
                        <div class="message <?php echo $response['type'] === 'user' ? 'message-user' : 'message-bot'; ?>">
                            <div><?php echo htmlspecialchars($response['content']); ?></div>
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
    </div>
</body>
</html>