<html>
    <head>
        <title></title>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <style>
            #chat {
                width: 300px;
            }
            #input {
                border: 1px solid #ccc;
                width: 100%;
                height: 30px;
            }
            #messages {
                padding-top: 5px;
            }
            #messages > div {
                background: #eee;
                padding: 10px;
                margin-bottom: 5px;
                border-radius: 4px;
            }
        </style>
    </head>
    <body>
        <div id="chat">
            <input type="submit" id="sends" />
            <input id="input" type="text" name="message" value="">
            <div id="messages">
            @foreach($allchat as $chat)
                <div data-created_at="{{ $chat->created_at }}">{{ $chat->body }}</div>
            @endforeach
            </div>
        </div>

        <script>
            var $messagesWrapper = $('#messages');

            // Append message to the wrapper,
            // which holds the conversation.
            var appendMessage = function(data) {
                var message = document.createElement('div');
                message.innerHTML = data.body;
                message.dataset.created_at = data.created_at;
                $messagesWrapper.append(message);
            };

            // Load messages from the server.
            // After request is completed, queue
            // another call
            var updateMessages = function(timestamp) {
                var lastMessage = $messagesWrapper.find('> div:last-child')[0];
                $.ajax({
                    type: "POST",
                    url: '{{ route("allmess") }}',
                    data: {
                        "from": ! lastMessage ? '' : lastMessage.dataset.created_at , "_token": "{{ csrf_token() }}" , "timestamp": timestamp
                    },
                    success: function(data) {
                       var obj = jQuery.parseJSON(data);
                        // put the data_from_file into #response
                        $('#response').html(obj.data_from_file);
                        // call the function again, this time with the timestamp we just got from server.php
                        setTimeout(updateMessages , 3000 , obj.timestamp);
                    },
                    error: function() {
                        console.log('Ooops, something happened!');
                    },
                    dataType: 'json'
                });
            };

            // Send message to server.
            // Server returns this message and message
            // is appended to the conversation.
            var sendMessage = function() {
                if (document.getElementById("input").value.trim() === '') { return; }

                //input.disabled = true;
                $.ajax({
                    type: "POST",
                    url: '{{ route("chat") }}',
                    data: { "message": document.getElementById("input").value , "_token": "{{ csrf_token() }}" , "user": "koko" },
                    success: function(message) {
                        appendMessage(message);
                    },
                    error: function() {
                        alert('Ooops, something happened!');
                    },
                    complete: function() {
                        document.getElementById("input").value = '';
                        document.getElementById("input").disabled = false;
                    },
                    dataType: 'json'
                });
            };

            // Send message to the servet on enter
            $('#input').on('keypress', function(e) {
                // Enter is pressed
                if (e.charCode === 13) {
                    e.preventDefault();
                    sendMessage(this);
                }
            });

            $("#sends").click(function() {
                sendMessage();

                return false;
            });

            // Start loop which get messages from server.
            $(function() {
                updateMessages();
            });
        </script>
    </body>
</html>