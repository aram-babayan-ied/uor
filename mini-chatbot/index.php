<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UOR - Mini chatbot</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">

    <script>
        $(document).on('click', '#send-btn', function() {
            var message = $("#query").val();

            // On rajoute le message saisi
            $('.form').append(
                '<div class="user-inbox inbox">' +
                    '<div class="msg-header"><p>' + message + '</p></div>' +
                '</div>'
            );

            $('#query').val('');

            // Petit loader en attente de la réponse AJAX
            $('.form').append(
                '<div class="loading-icon lds-ellipsis"><div></div><div></div><div></div><div></div></div>'
            );
            // Scroll en bas du chat
            $('.form').scrollTop($(".form")[0].scrollHeight);

            $.post('query.php', {query: message})
                .done(function(res) {
                    var res = JSON.parse(res);

                    // On affiche côté client le message transmis
                    $('.loading-icon').remove();
                    $('.form').append(
                        '<div class="bot-inbox inbox"><div class="msg-header"><p>' +
                            res.message +
                        '</p></div></div>');
                    
                    setTimeout(function() {
                        // scroll en bas du chat une fois l'animation CSS terminée
                        $('.form').scrollTop($(".form")[0].scrollHeight);
                    }, 200);
                })
        });

        $(document).on('keyup', '#query', function(e) {
            // Envoi de la pquête lorsqu'on appuie sur Entrée dans le contexte du chat
            if ((e.keyCode || e.which) === 13) {
                $('#send-btn').trigger('click')
            }
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="title">UOR - Mini chat bot</div>
        <div class="form">
            <div class="bot-inbox inbox">
                <div class="msg-header">
                    <p>Bienvenue. Comment puis-je vous aider?</p>
                </div>
            </div>
        </div>
        <div class="typing-field">
            <div class="input-query">
                <input id="query" type="text" placeholder="Envoyer un message..." required>
                <button id="send-btn">Envoyer</button>
            </div>
        </div>
    </div>
</body>
</html>