document.addEventListener('DOMContentLoaded', function () {
    let form = document.getElementById('message-form');
    
    form.addEventListener('submit', function (e) {
        e.preventDefault(); 

        let messageInput = document.getElementById('message-input');
        let message = messageInput.value;
        let chat_id = document.getElementById('chat_id').value;
        let send_id = document.getElementById('user_id').value;

        const url = window.apiUrl;
        fetch(`${url}/api/support/store`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ 
                message: message,
                chat_id: chat_id,
                send_id: send_id
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Message sent:', data);
            console.log(data.message)
            messageInput.value = ''; 
        })
        .catch(error => console.error('Error:', error));
    });
    

    let chatId = document.getElementById('chat_id').value;
    let currentUserId = document.getElementById('user_id').value;

    window.Echo.channel(`chat_${chatId}`)
    .listen('.message', (event) => {
        console.log('Message received:', event.message);
        let messagesList = document.getElementById('messages-list');
        let newMessage = document.createElement('li');
        newMessage.classList.add('message'); 

        let messageClass = event.message.send_id === currentUserId ? 'sent' : 'received';
        
        newMessage.textContent = event.message.messages;
        newMessage.classList.add(messageClass);

        let messageName = document.createElement('p');
        messageName.classList.add('message-name');
        messageName.classList.add(messageClass);
        messageName.textContent = event.message.name;

        messagesList.appendChild(messageName);
        messagesList.appendChild(newMessage);
    });

});
