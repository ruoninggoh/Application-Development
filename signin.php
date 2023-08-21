<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>UniHealth</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;0,800;1,100;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/signup.css">
    <?php include("landingHeader.html"); ?>
   
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="database/signin_form.php" method="POST">
                            <div>
                                <h4>Sign In</h4><br>
                            </div>
                            <div class="center-buttons">
                                <button type="button" class="role-button" data-role="Patient">Patient</button>
                                <button type="button" class="role-button" data-role="Doctor">Doctor</button>
                                <button type="button" class="role-button" data-role="Staff">Staff</button>
                            </div>
                            <input type="hidden" id="selectedRole" name="selectedRole" value="">

                            <br>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div>
                                <div class="text-left mt-3">
                                    <a href="recover_psw.php">Forgot Passowrd?</a></h>
                                </div><br>
                                <button type="submit" class="btn custom-btn-signin">Sign In</button>
                                <div class="text-center mt-3">
                                    <h>New user? <a href="signup.php">Sign Up Now</a></h>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const roleButtons = document.querySelectorAll('.role-button');
        const selectedRoleInput = document.getElementById('selectedRole');

        roleButtons.forEach(button => {
            button.addEventListener('click', () => {
                const role = button.getAttribute('data-role');
                selectedRoleInput.value = role;

                // Highlight the selected button and unhighlight others
                roleButtons.forEach(btn => {
                    if (btn === button) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>

</body>

</html>