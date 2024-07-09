<?php
/* Smarty version 3.1.33, created on 2024-07-09 19:38:22
  from 'C:\Users\delco\Desktop\ProgettiProgrammazioneWeb\GymBuddy\libs\Smarty\templates\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_668d758ecb9ba9_60058972',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3397d9d632a797d70e2934b4bcc7801b4878858f' => 
    array (
      0 => 'C:\\Users\\delco\\Desktop\\ProgettiProgrammazioneWeb\\GymBuddy\\libs\\Smarty\\templates\\login.tpl',
      1 => 1720546641,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_668d758ecb9ba9_60058972 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/logcss.css" type="text/css">

    <style>
        body {
            background-color: #b7a5ad;
        }
        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-container form .form-group {
            margin-bottom: 20px;
        }
        .login-container form label {
            font-weight: bold;
        }
        .login-container form input[type="email"], .login-container form input[type="password"] {
            border: 1px solid #ced4da;
            border-radius: 3px;
            padding: 8px;
        }
        .login-container form button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .login-container form button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .login-container .error-message {
            color: #dc3545;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-container">
        <h2>Accedi al tuo account</h2>
        <form action="/GymBuddy/User/checkLogin" method="post">
            <div class="form-group">
                <label for="email">Indirizzo email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Accedi</button>
            <?php if (isset($_smarty_tpl->tpl_vars['error_message']->value)) {?>
                <p class="error-message"><?php echo $_smarty_tpl->tpl_vars['error_message']->value;?>
</p>
            <?php }?>
        </form>
        <div class="text-center mt-3">
            <a href="registrazione.html" class="btn btn-secondary btn-sm">Registrati</a>
        </div>
    </div>
</div>
</body>
</html>
<?php }
}
