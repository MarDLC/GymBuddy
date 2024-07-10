<?php
/* Smarty version 3.1.33, created on 2024-07-10 11:04:00
  from 'C:\Users\delco\Desktop\ProgettiProgrammazioneWeb\GymBuddy\libs\Smarty\templates\registrazione.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_668e4e803136a2_30494050',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cfdb2bc9e044e4fbbb69ece21a3a72beeb81f46f' => 
    array (
      0 => 'C:\\Users\\delco\\Desktop\\ProgettiProgrammazioneWeb\\GymBuddy\\libs\\Smarty\\templates\\registrazione.tpl',
      1 => 1720563819,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_668e4e803136a2_30494050 (Smarty_Internal_Template $_smarty_tpl) {
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

            <button type="submit" class="btn btn-primary btn-block">Registrati</button>
        </form>
    </div>
</div>
</body>
</html>
<?php }
}
