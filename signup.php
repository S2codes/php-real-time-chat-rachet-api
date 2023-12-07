<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./asstes/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body>

    <div class="mainContainer">

        <div class="formContainer border">
            <h3>Create your Account</h3>
            <form action="" method="post" id="signupForm">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input type="text" class="form-control" id="username" placeholder="Enter Your Name" autocomplete="username">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com" autocomplete="email">
                </div>

                <div class="form-group password-toggle mb-2">
                    <label for="password">Password:</label>
                    <input type="password" id="password" class="form-control" placeholder="Enter your password" autocomplete="new-password">
                    <span class="toggle-icon" id="togglePassword">
                        <i class="bi bi-eye-fill"></i>
                    </span>
                </div>
                <div class="form-group password-toggle">
                    <label for="password">Confirm Password:</label>
                    <input type="password" id="confirmPassword" class="form-control" placeholder="Enter your password" autocomplete="new-password">
                    <span class="toggle-icon" id="togglePassword">
                        <i class="bi bi-eye-fill"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-primary mt-2 mx-auto">Login</button>

            </form>
            <p class="mt-3 text-center">Already Have an Account ? <a href="./">Login</a></p>

        </div>

    </div>


    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="./asstes/js/HttpRequest.js"></script>
    <script src="./asstes/js/main.js"></script>
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
    <script>
        $(document).ready(function() {
            // Add a submit event listener to the form
            $('#signupForm').submit(function(event) {
                // Prevent the form from submitting by default
                event.preventDefault();
                // Get the email, password, and confirmPassword input values
                var username = $('#username').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var confirmPassword = $('#confirmPassword').val();

                // Validate email
                if (username === '') {
                    showTost('Enter Your Name', false)
                    return;
                }
                if (!validateEmail(email)) {
                    showTost('Invalid email address', false)
                    return;
                }

                // Validate password
                if (!validatePassword(password)) {
                    showTost('Password must be at least 6 characters', false)
                    return;
                }

                // Check if the password matches the confirm password
                if (password !== confirmPassword) {
                    showTost('Password is not matched with Confirm password', false)
                    return;
                }

                // If both email and password are valid, submit the form via AJAX
                HttpRequest('./api/signup.php', {
                    username, email, password
                }, (data) => {
                    if (data.response) {
                        document.getElementById('signupForm').reset();
                        showTost('Your Account is created Successfully. Login to Contunue')
                    } else {
                        showTost(data.message, false)
                    }
                })
            });

            // Function to validate email
            function validateEmail(email) {
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Function to validate password
            function validatePassword(password) {
                return password.length >= 6;
            }

        });
    </script>

</body>

</html>