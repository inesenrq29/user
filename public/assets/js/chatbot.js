document.querySelector('input[name="message"]').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();

        const input = this;
        const chatMessages = document.querySelector('.chat-messages');
        const message = input.value.trim();

        if (message === '') return;


        const userDiv = document.createElement('div');
        userDiv.className = 'message message-user';
        userDiv.textContent = message;
        chatMessages.appendChild(userDiv);


        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'message message-bot';
        loadingDiv.innerHTML = '<div class="typing-indicator"></div>';
        chatMessages.appendChild(loadingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;


        setTimeout(() => {
            document.getElementById('chatForm').submit();
        }, 300); 
    }
});