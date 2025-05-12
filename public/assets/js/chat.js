document.addEventListener("DOMContentLoaded", function () { //attend que la page soit entièrement chargée 
    const chat = document.getElementById('chatContainer'); //classe contenant le chat
    const button = document.getElementById('toggleChatBtn'); //bouton "ouvrir le chat"

    if (localStorage.getItem('chatOpen') === 'true') { //si le chat est ouvert avant le rechargement
        chat.classList.remove('d-none'); //on affiche ce qui était caché (ici le chat)
    }

        button.addEventListener('click', function () { //ajout d'un écouteur d'évènement "au clic" et on appelle la fonction ci-dessous
            const isHidden = chat.classList.contains('d-none'); //classe qui contient "d-none"

            if (isHidden) { //si c'est "caché"
                chat.classList.remove('d-none'); //on retire la propriété pour afficher le chat
                localStorage.setItem('chatOpen', 'true'); //on stocke dans localStorage pour indiquer que le chat est ouvert
            } 
        });
});

document.addEventListener("DOMContentLoaded", function () { //attend que la page soit entièrement chargée 
    const chat = document.getElementById('chatContainer'); //classe contenant le chat
    const button = document.getElementById('closeChat'); //bouton "ouvrir le chat"

        button.addEventListener('click', function () { //ajout d'un écouteur d'évènement "au clic" et on appelle la fonction ci-dessous
            const isHidden = chat.classList.contains('d-none'); //classe qui contient "d-none"

            if (!isHidden) { //si c'est "caché"
                chat.classList.add('d-none');
                localStorage.setItem('chatOpen', 'false');
            } 
        });
});



