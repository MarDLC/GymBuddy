<?php
/* Smarty version 3.1.33, created on 2024-07-21 23:46:50
  from 'C:\Users\delco\Desktop\ProgettiProgrammazioneWeb\GymBuddy\libs\Smarty\templates\confirmation.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_669d81ca412b42_64206935',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd7c146848b9842a12096d05ceb7796c5f2896861' => 
    array (
      0 => 'C:\\Users\\delco\\Desktop\\ProgettiProgrammazioneWeb\\GymBuddy\\libs\\Smarty\\templates\\confirmation.tpl',
      1 => 1721597218,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669d81ca412b42_64206935 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/style.css" type="text/css">
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
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-4">
            <a href="#" class="btn btn-primary">Home</a>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="card-header">
                    <h2>Confirmation</h2>
                </div>
                <div class="card-body">
                    <p><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript redirect -->
<?php echo $_smarty_tpl->tpl_vars['redirect']->value;?>


</body>
</html>
<?php }
}
