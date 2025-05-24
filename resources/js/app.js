import './bootstrap'; // Assegura't que es carrega el bootstrap.js

window.Echo.channel('videos')
    .listen('.video.created', (e) => {
        console.log('Nova notificació push:', e);

        // Exemple: afegir la notificació a una llista HTML
        const list = document.getElementById('notifications');
        if (list) {
            const item = document.createElement('li');
            item.innerText = `Nou vídeo: ${e.title}`;
            list.prepend(item);
        }
    });
