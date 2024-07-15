<?php
/* Smarty version 3.1.33, created on 2024-07-14 19:13:15
  from 'C:\Users\lorex\OneDrive - Università degli Studi dell'Aquila\GymBuddy\libs\Smarty\templates\registrazione.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6694072b08a275_59621104',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dfa95f40195bc199f4329c57591c3460e0195b89' => 
    array (
      0 => 'C:\\Users\\lorex\\OneDrive - Università degli Studi dell\'Aquila\\GymBuddy\\libs\\Smarty\\templates\\login.tpl',
      1 => 1720721845,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6694072b08a275_59621104 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/logcss.css"type="text/css">

    <style>
        body {
            background-color: #b7a5ad;
        }
        .registrazione-container {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        .registrazione-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .registrazione-container form .form-group {
            margin-bottom: 20px;
        }
        .registrazione-container form label {
            font-weight: bold;
        }
        .registrazione-container form input[type="text"],
        .registrazione-container form input[type="date"] {
            border: 1px solid #ced4da;
            border-radius: 3px;
            padding: 8px;
        }
        .registrazione-container form input[type="radio"] {
            margin-right: 10px;
        }
        .registrazione-container form button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .registrazione-container form button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="registrazione-container">
        <h2>REGISTRAZIONE</h2>
        <form action="/GymBuddy/User/registration" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="first_name">Nome</label>
                <input type="text" id="first_name" name="first_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="last_name">Cognome</label>
                <input type="text" id="last_name" name="last_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" id="password" name="password" class="form-control" required>
            </div>

            <p id="passwordMatchError" class="error-text" style="display: none;">Password must be at least 8 characters long, containing at least 1 number, 1 uppercase letter, and 1 special character.</p>
            <button type="submit" class="btn btn-primary btn-block">Registrati</button>
        </form>
    </div>
</div>
<?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/validatePwd.js"><?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
