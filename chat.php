<?php
include "./db/conn.php";
$DB = new Database_Queries();
$usaerid = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect in Real Time</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./asstes/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body>
    <script>
        var userData = localStorage.getItem('loggedInUser');
        if (userData == null) {
            window.location.href = './'
            console.log('Key not found in localStorage');
        }
    </script>

    <div class="container-fluid">

        <div class="row p-3">
            <div class="col-md-3">
                <h6 class="border-bottom">All users</h6>
                <div class="allUsersContainer p-1">

                    <?php

                    $sql = "SELECT * FROM `users` WHERE `id` != $usaerid";
                    $DATA = $DB->RetriveArray($sql);
                    foreach ($DATA as $key => $item) {
                        echo '
                        <a href="./chat?id=' . $usaerid . '&sendto=' . $item['id'] . '" style="text-decoration: none;">
                        <div class="alert ' . ($item['id'] == $_GET['sendto'] ? 'alert-danger' : 'alert-info') . ' mb-1" role="alert">
                            <p class="fw-bold m-0">' . $item['username'] . '</p>
                            Click To Message
                        </div>
                    </a>
                    ';
                    }
                    ?>

                </div>
            </div>
            <div class="col-md-9 col-12 mx-auto">
                <div class="chatContainer p-2">
                    <h4 class="border-bottom">Chat Box of <span id="loggedUserId"></span></h4>
                    <input type="hidden" id="reciverId" name="sendto" value="<?php echo $_GET['sendto']; ?>">
                    <div class="messageContainer p-2" id="messageContainer">

                    </div>
                    <?php
                    if (isset($_GET['sendto'])) {
                        if ($_GET['sendto'] != 0) {
                    ?>
                            <div class="messageInputContainer">
                                <textarea name="" id="chatMessage" cols="30" rows="1" class="form-control" placeholder="Write Your Message"></textarea>
                                <button class="btn btn-primary" id="sendBtn">Send <i class="bi bi-send-fill"></i></button>
                            </div>
                    <?php }
                    } ?>

                </div>
            </div>
        </div>

    </div>




    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="./asstes/js/main.js"></script>
    <script src="./asstes/js/HttpRequest.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function() {

            var user = localStorage.getItem('loggedInUser');
            user = JSON.parse(user);
            let userName = user[0];
            let userId = user[2];
            let reciverId = $('#reciverId').val();
            $('#loggedUserId').text(userName)

            // fetch pre messages 
            HttpRequest('./api/getPreMessage.php', {
                    userId,
                    reciverId,
                },
                (data) => {
                    $.each(data.data, (index, item) => {
                        console.log(item);
                        console.log(item.message);
                        if (item.userid === userId) {
                            $('#messageContainer').append(`
                                <div class="alert alert-primary SendMsg" role="alert">
                                    <p class="fw-bold m-0">${data.reciver}</p>
                                    ${item.message}
                                </div>
                            `)
                        } else {
                            $('#messageContainer').append(`
                                <div class="alert alert-success RecivedMsg" role="alert">
                                    <p class="fw-bold m-0">${data.sender}</p>
                                    ${item.message}
                                </div>
                            `)
                        }
                    })
                })




            var conn = new WebSocket('ws://localhost:8080');
            conn.onopen = function(e) {
                console.log("Connection established!");
                showTost('Connection established!')
            };

            conn.onmessage = function(e) {
                let recivedData = JSON.parse(e.data)
                console.log('recivedData ==-=-=-=-=-=');
                console.log(recivedData);
                if (recivedData.reciverId === userId) {
                    $('#messageContainer').append(`
                    <div class="alert alert-success RecivedMsg" role="alert">
                    <p class="fw-bold m-0">${recivedData.userName}</p>
                    ${recivedData.message}
                    </div>
                    `)
                }
            }


            $('#sendBtn').on('click', function() {
                let message = $('#chatMessage').val()
                if (message.trim() !== '') {
                    let sendData = JSON.stringify({
                        userId,
                        userName,
                        message,
                        reciverId
                    })
                    conn.send(sendData)
                    $('#messageContainer').append(`
                    <div class="alert alert-primary SendMsg" role="alert">
                            <p class="fw-bold m-0">${userName}</p>
                            ${message}
                        </div>
                    `)
                    console.log('reciverId');
                    console.log(reciverId);

                    HttpRequest('./api/sendMessage.php', {
                            userId,
                            userName,
                            message,
                            reciverId
                        },
                        (data) => {
                            console.log('api response herer');
                            console.log(data);
                        })
                }
            })
        })
    </script>
    <script>

    </script>
</body>

</html>