<?php session_start(); ?>
<?php
include('../database/connectdb.php');

if (isset($_POST["register"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $check_query = mysqli_query($connect, "SELECT * FROM login where email ='$email'");
    $rowCount = mysqli_num_rows($check_query);

    if (!empty($email) && !empty($password)) {
        if ($rowCount > 0) {
            ?>
            <script>
                alert("User with email already exist!");
            </script>
            <?php
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $result = mysqli_query($connect, "INSERT INTO login (email, password, status) VALUES ('$email', '$password_hash', 0)");

            if ($result) {
                $otp = rand(100000, 999999);
                $_SESSION['otp'] = $otp;
                $_SESSION['mail'] = $email;
                require "Mail/phpmailer/PHPMailerAutoload.php";
                $mail = new PHPMailer;

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';

                $mail->Username = 'ting02@graduate.utm.my';
                $mail->Password = 'ting@881608';

                $mail->setFrom('ting02@graduate.utm.my', 'OTP Verification');
                $mail->addAddress($_POST["email"]);

                $mail->isHTML(true);
                $mail->Subject = "Your verify code";
                $mail->Body = "<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>
                    <br><br>
                    <p>With regrads,</p>
                    <b>Programming with Lam</b>
                    https://www.youtube.com/channel/UCKRZp3mkvL1CBYKFIlxjDdg";

                if (!$mail->send()) {
                    ?>
                    <script>
                        alert("<?php echo "Register Failed, Invalid Email " ?>");
                    </script>
                    <?php
                } else {
                    ?>
                    <script>
                        alert("<?php echo "Register Successfully, OTP sent to " . $email ?>");
                        window.location.replace('verification.php');
                    </script>
                    <?php
                }
            }
        }
    }
}

?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>UniHealth</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;0,800;1,100;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="../css/signup.css" ;>
    <?php include("landingHeader.html"); ?>
</head>

<body>
    <?php
    if (isset($_GET['error']) && $_GET['error'] === 'password_mismatch') {
        echo '<div class="error-container">';
        echo '  <div class="error-box">';
        echo '    <p class="error-message">Passwords do not match! Please try again.</p>';
        echo '  </div>';
        echo '</div>';
    }
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="../index.php" method="POST">
                            <div>
                                <h4>Sign Up</h4>
                            </div>
                            <input type="hidden" name="type" value="1">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="8"
                                    required>
                                <i class="far fa-eye-slash" id="togglePassword"></i>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                    required>
                                    <i class="far fa-eye-slash" id="toggleConfirmPassword"></i>
                            </div>
                            <div id="passwordMismatch" class="text-danger"></div>
                            <button type="submit" name="registerSubmit" class="btn custom-btn-signup">Sign Up</button>
                            <div class="text-center mt-3">
                                <h>Already sign up? <a href="signin.php">Sign In Now</a></h>
                            </div>

                            <input type="hidden" name="action" value="validate" />
                            <input type="hidden" name="controller" value="RegistrationController" />

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    var passwordInput = document.getElementById("password");
    var confirmPasswordInput = document.getElementById("confirmPassword");
    var passwordMismatch = document.getElementById("passwordMismatch");
    var passwordToggle = document.getElementById("togglePassword");
    var confirmToggle = document.getElementById("toggleConfirmPassword");

    confirmPasswordInput.addEventListener("input", checkPasswords);
    passwordToggle.addEventListener("click", togglePasswordVisibility);
    confirmToggle.addEventListener("click", toggleConfirmPasswordVisibility);

    function checkPasswords() {
        var password = passwordInput.value;
        var confirmPassword = confirmPasswordInput.value;

        if (password === confirmPassword) {
            passwordMismatch.innerHTML = "";
        } else {
            passwordMismatch.innerHTML = "Passwords do not match! Please enter again.";
        }
    }

    function togglePasswordVisibility() {
        var passwordFieldType = passwordInput.getAttribute("type");

        if (passwordFieldType === "password" ) {
            passwordInput.setAttribute("type", "text");
            passwordToggle.classList.remove("fa-eye-slash");
            passwordToggle.classList.add("fa-eye");
        } else {
            passwordInput.setAttribute("type", "password");
            passwordToggle.classList.remove("fa-eye");
            passwordToggle.classList.add("fa-eye-slash");
        }
    }

    function toggleConfirmPasswordVisibility() {
        var confirmFieldType = confirmPasswordInput.getAttribute("type");

        if (confirmFieldType === "password" ) {
            confirmPasswordInput.setAttribute("type", "text");
            confirmToggle.classList.remove("fa-eye-slash");
            confirmToggle.classList.add("fa-eye");
        } else {
            confirmPasswordInput.setAttribute("type", "password");
            confirmToggle.classList.remove("fa-eye");
            confirmToggle.classList.add("fa-eye-slash");
        }
    }
</script>

</body>

</html>