<body class="bg-light">
    <div class="container mt-4">
        <div class="chat-container">
            <div class="chat-header">
                <h5 class="mb-0">Chat Sneak-Me</h5>
            </div>
            
            <div class="chat-messages">
                <?php if (isset($messages) && is_array($messages)): ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="message <?php echo $message['type'] === 'user' ? 'message-user' : 'message-bot'; ?>">
                            <div><?php echo htmlspecialchars($message['content']); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted">
                        Bienvenue ! Posez-moi vos questions sur les sneakers.
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="chat-input">
                <form method="POST" action="" class="d-flex">
                    <input type="text" name="message" class="form-control me-2" placeholder="Posez votre question...">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</body>
