<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Chat</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./asstes/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body>
<script>
      var user = localStorage.getItem('loggedInUser');
            if (user !== null) {
                user = JSON.parse(user);
                let userId = user[2];
                window.location.href=`chat?id=${userId}&sendto=0`
            }
</script>
    <div class="mainContainer">

        <div class="formContainer border">

            <form method="post" id="loginForm">
                <h4>Login to Your Acoount</h4>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="useremail" placeholder="name@example.com" autocomplete="">
                </div>

                <div class="form-group password-toggle">
                    <label for="password">Password:</label>
                    <input type="password" id="password" class="form-control" placeholder="Enter your password" autocomplete="current-password">
                    <span class="toggle-icon" id="togglePassword">
                        <i class="bi bi-eye-fill"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-primary mt-2 mx-auto mb-2">Login</button>

            </form>
            <p>Don't Have an Account ? <a href="./signup">Sign up</a></p>

        </div>

    </div>


    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="./asstes/js/HttpRequest.js"></script>
    <script src="./asstes/js/main.js"></script>
    <script>
        $(document).ready(function() {

            $('#loginForm').on('submit', function(e) {
                e.preventDefault()
                const email = $('#useremail').val();
                const password = $('#password').val();

                // Ajax Call 
                HttpRequest('./api/login.php', {
                        email,
                        password
                    },
                    (data) => {
                        if (data.response) {
                            console.log(data.user);
                            localStorage.setItem('loggedInUser', JSON.stringify(data.user));
                            document.getElementById('loginForm').reset();
                            showTost('Success!')
                            setTimeout(function() {
                                window.location.href = `./chat?id=${data.user[2]}&sendto=0`;
                            }, 1500);

                        } else {
                            showTost(data.message, false)
                        }
                    }
                )
            })


        })
    </script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        });
    </script>


</body>

</html>