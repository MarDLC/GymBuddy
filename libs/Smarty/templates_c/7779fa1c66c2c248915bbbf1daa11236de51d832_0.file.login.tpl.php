<?php
/* Smarty version 3.1.33, created on 2024-07-15 11:55:23
  from 'C:\Users\lorex\OneDrive - Università degli Studi dell'Aquila\GymBuddy\libs\Smarty\templates\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6694f20b6f39e7_19593719',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7779fa1c66c2c248915bbbf1daa11236de51d832' => 
    array (
      0 => 'C:\\Users\\lorex\\OneDrive - Università degli Studi dell\'Aquila\\GymBuddy\\libs\\Smarty\\templates\\login.tpl',
      1 => 1721037321,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6694f20b6f39e7_19593719 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Registration</title>
    <!-- icon scout cdn -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="GymBuddy/libs/Smarty/img/imglogin.jpg">

    <!-- stylesheet -->
    <link rel="stylesheet" type="text/css" href="/GymBuddy/libs/Smarty/css/stylelogin.css">
    <?php echo '<script'; ?>
>
        function ready(){
            if (!navigator.cookieEnabled) {
                alert('Attenzione! Attivare i cookie per proseguire correttamente la navigazione');
            }
        }
        document.addEventListener("DOMContentLoaded", ready);
    <?php echo '</script'; ?>
>
</head>

<body class="img js-fullheight" style="background-image: url(/GymBuddy/libs/Smarty/img/imglogin.jpg);">
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">WELCOME TO GYMBUDDY!</h2>
            </div>
        </div>

        <!------------FORM PER IL LOG IN------------------------------>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    <?php if ($_smarty_tpl->tpl_vars['error']->value == true) {?>
                        <p style="color: red; margin-left: 11%">username or password incorrect</p>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['regErr']->value == true) {?>
                        <p style="color: red; margin-left: 7%">email or username is already taken</p>
                    <?php }?>
                    <form id="login" action="/GymBuddy/User/checkLogin" method="post">
                        <h3 class="mb-4 text-center" style="color: #fff;">Have an account?</h3>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter Username" name="username" required>
                        </div>

                        <div class="form-group">
                            <input id="login-password-field" type="password" class="form-control" placeholder="Enter Password" name="password" required>
                            <span toggle="#login-password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!------------FINE FORM PER IL LOG IN------------------------------>

        <!------------FORM PER IL SING UP------------------------------>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    <h3 class="mb-4 text-center" style="color: #fff;">Create an account</h3>
                    <form id="register" class="signin-form" action="/GymBuddy/User/registration" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" name="email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" name="username" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="First Name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Last Name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <input id="register-password-field" type="password" class="form-control" placeholder="Enter Password" name="password" required>
                            <span toggle="#register-password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>

                        <p id="passwordMatchError" class="error-text" style="display: none;">Password must be at least 8 characters long, containing at least 1 number, 1 uppercase letter, and 1 special character.</p>
                        <div class="form-group d-md-flex">
                            <div class="w-50">
                                <label class="checkbox-wrap checkbox-primary">Are you a trainer?
                                    <input type="checkbox" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3" >Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!------------FINE FORM PER IL SING UP------------------------------>
    </div>
</section>

<?php echo '<script'; ?>
 src="js/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/popper.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/main.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/validatePwd.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
    document.addEventListener("DOMContentLoaded", function() {
        var togglePasswordElements = document.querySelectorAll('.toggle-password');

        togglePasswordElements.forEach(function(togglePassword) {
            togglePassword.addEventListener('click', function() {
                var passwordField = document.querySelector(this.getAttribute('toggle'));
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    });

    const x = document.getElementById("login");
    const y = document.getElementById("register");
    const z = document.getElementById("btn-log");

    function register(){
        x.style.left = "-400px"
        y.style.left = "50px"
        z.style.left = "110px"
    }

    function login(){
        x.style.left = "50px"
        y.style.left = "550px"
        z.style.left = "0px"
    }

<?php echo '</script'; ?>
>

</body>
</html><?php }
}
