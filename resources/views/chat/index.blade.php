<!DOCTYPE html>
<html>
<head>
    <title>Company Chat</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        
        .chat-container {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            height: 650px;
        }
        
        .chat-header {
            background-color: #333;
            color: white;
            padding: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .chat-title {
            flex: 1;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin: 0;
        }
        
        .back-link {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 16px;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: #4CAF50;
        }
        
        .back-arrow {
            margin-right: 5px;
        }
        
        .chat-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .load-more-container {
            padding: 15px;
            text-align: center;
            background-color: #f9f9f9;
            border-bottom: 1px solid #eee;
        }
        
        .load-more-btn {
            background-color: #4a4a4a;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .load-more-btn:hover {
            background-color: #333;
        }
        
        .load-more-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        
        .no-messages {
            text-align: center;
            color: #888;
            margin-top: 40%;
            font-style: italic;
            font-size: 16px;
        }
        
        .loading {
            text-align: center;
            padding: 10px;
            color: #666;
            font-style: italic;
        }
        
        .chat-input-container {
            padding: 20px;
            border-top: 1px solid #eee;
            background-color: white;
        }
        
        .chat-input {
            display: flex;
            width: 100%;
        }
        
        .chat-input input {
            flex: 1;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
            font-size: 15px;
        }
        
        .chat-input input:focus {
            outline: none;
            border-color: #4CAF50;
        }
        
        .chat-input button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
        }
        
        .chat-input button:hover {
            background-color: #45a049;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .message-bubble {
            padding: 10px 15px;
            border-radius: 10px;
            max-width: 70%;
            word-wrap: break-word;
        }

        .message.self {
            align-items: flex-end;
        }

        .message.other {
            align-items: flex-start;
        }

        .message.self .message-bubble {
            background-color: #dcf8c6;
            border-top-right-radius: 0;
        }

        .message.other .message-bubble {
            background-color: #f1f0f0;
            border-top-left-radius: 0;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .sender-name {
            font-weight: bold;
            color: #555;
        }

        .message-time {
            color: #777;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <a href="{{ session('role') == 'admin' ? route('admin.dashboard') : route('employee.dashboard') }}" class="back-link">
                <span class="back-arrow">←</span> Back to Dashboard
            </a>
            <h1 class="chat-title">Company Chat</h1>
            <div style="width: 150px;"></div>
        </div>
        
        <div class="chat-body">
            <div id="loadMoreContainer" class="load-more-container" style="display: none;">
                <button id="loadMoreBtn" class="load-more-btn">Load Older Messages</button>
            </div>
            
            <div id="chatMessages" class="chat-messages">
                <div id="loadingIndicator" class="loading">Loading messages...</div>
                <div id="noMessages" class="no-messages" style="display: none;">No messages yet. Start the conversation!</div>
            </div>
        </div>
        
        <div class="chat-input-container">
            <div class="chat-input">
                <input type="text" id="messageInput" placeholder="Type your message here...">
                <button id="sendButton">Send</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    //Java references that for chat
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const loadMoreContainer = document.getElementById('loadMoreContainer');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const noMessages = document.getElementById('noMessages');
    
    let newestMessageId = 0;
    let oldestMessageId = Number.MAX_SAFE_INTEGER;
    let isLoadingMessages = false;
    
    // Sending message
    function sendMessage() {
        const messageText = messageInput.value.trim();
        if (messageText === '') return;
        
        // Disable input while sending
        messageInput.disabled = true;
        sendButton.disabled = true;
        
        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: 'message=' + encodeURIComponent(messageText)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                loadNewMessages();
            } else {
                alert('Error: ' + (data.error || 'Failed to send message'));
            }
        })
        .catch(error => {
            alert('Failed to send message. Please try again.');
        })
        .finally(() => {
            messageInput.disabled = false;
            sendButton.disabled = false;
            messageInput.focus();
        });
    }
    
    
    function loadNewMessages() {
        fetch('{{ route("chat.messages") }}?direction=newer&last_id=' + newestMessageId)
            .then(response => response.json())
            .then(data => {
             
                loadingIndicator.style.display = 'none';
                
                if (data.messages && data.messages.length > 0) {
                    
                    noMessages.style.display = 'none';
                    
                    
                    data.messages.forEach(message => {
                        addMessageToChat(message);
                        
                       
                        if (message.message_id > newestMessageId) {
                            newestMessageId = message.message_id;
                        }
                        
                        
                        if (oldestMessageId === Number.MAX_SAFE_INTEGER) {
                            oldestMessageId = message.message_id;
                        }
                    });
                    
                    
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    
                    // Load button if there are older messages
                    loadMoreContainer.style.display = data.has_more ? 'block' : 'none';
                } else if (newestMessageId === 0) {
                    
                    noMessages.style.display = 'block';
                    loadMoreContainer.style.display = 'none';
                }
            })
            .catch(error => {
                loadingIndicator.style.display = 'none';
            });
    }
    
    // Loads older messages
    function loadOlderMessages() {
        if (isLoadingMessages) return;
        
        isLoadingMessages = true;
        loadMoreBtn.disabled = true;
        loadMoreBtn.textContent = 'Loading...';
        
        fetch('{{ route("chat.messages") }}?direction=older&last_id=' + oldestMessageId)
            .then(response => response.json())
            .then(data => {
                
                if (data.messages && Object.keys(data.messages).length > 0) {
              
                    const scrollPos = chatMessages.scrollHeight - chatMessages.scrollTop;
                                      
                    let olderMessages = [];
                                      
                    if (Array.isArray(data.messages)) {
                        olderMessages = data.messages;
                    } else {
                        
                        olderMessages = Object.values(data.messages);
                    }
                                       
                    let newOldestId = oldestMessageId;
                                       
                    olderMessages.forEach(message => {
                       
                        if (!message || !message.message_id) {
                            return;
                        }
                        
                        const messageElement = createMessageElement(message);
                       
                        if (chatMessages.firstChild) {
                            chatMessages.insertBefore(messageElement, chatMessages.firstChild);
                        } else {
                            chatMessages.appendChild(messageElement);
                        }
                        
                        if (message.message_id < newOldestId) {
                            newOldestId = message.message_id;
                        }
                    });
                    
                    if (newOldestId < oldestMessageId) {
                        oldestMessageId = newOldestId;
                    }
                    
                    chatMessages.scrollTop = chatMessages.scrollHeight - scrollPos;
                    
                    // Shows load more button if there are more messages
                    loadMoreContainer.style.display = data.has_more ? 'block' : 'none';
                } else {
                    loadMoreContainer.style.display = 'none';
                }
            })
            .catch(error => {
            })
            .finally(() => {
                loadMoreBtn.disabled = false;
                loadMoreBtn.textContent = 'Load Older Messages';
                isLoadingMessages = false;
            });
    }
    
    function addMessageToChat(message) {
        const messageElement = createMessageElement(message);
        chatMessages.appendChild(messageElement);
    }
    
    function createMessageElement(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message ' + (message.is_self ? 'self' : 'other');
        messageDiv.dataset.id = message.message_id;
        
        const bubbleDiv = document.createElement('div');
        bubbleDiv.className = 'message-bubble';
        
        const headerDiv = document.createElement('div');
        headerDiv.className = 'message-header';
        
        const nameSpan = document.createElement('span');
        nameSpan.className = 'sender-name';
        nameSpan.textContent = message.sender_name;
        
        const timeSpan = document.createElement('span');
        timeSpan.className = 'message-time';
        timeSpan.textContent = formatTimestamp(message.timestamp);
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.textContent = message.message;
        
        headerDiv.appendChild(nameSpan);
        headerDiv.appendChild(timeSpan);
        
        bubbleDiv.appendChild(headerDiv);
        bubbleDiv.appendChild(contentDiv);
        
        messageDiv.appendChild(bubbleDiv);
        
        return messageDiv;
    }
    
    function formatTimestamp(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
    
    sendButton.addEventListener('click', sendMessage);
    
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    
    loadMoreBtn.addEventListener('click', loadOlderMessages);
    
    loadNewMessages();
    
    setInterval(loadNewMessages, 5000);
});
    </script>
</body>
</html>