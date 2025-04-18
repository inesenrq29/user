<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Sneak-Me</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/chat.css" rel="stylesheet">
</head>
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
                <form method="POST" action="chat.php" class="d-flex">
                    <input type="text" name="message" class="form-control me-2" placeholder="Posez votre question...">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 