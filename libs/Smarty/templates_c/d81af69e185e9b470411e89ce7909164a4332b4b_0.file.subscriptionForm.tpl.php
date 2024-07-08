<?php
/* Smarty version 3.1.33, created on 2024-07-07 17:51:56
  from 'C:\Users\delco\Desktop\ProgettiProgrammazioneWeb\GymBuddy\libs\Smarty\templates\subscriptionForm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_668ab99c82e688_62940208',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd81af69e185e9b470411e89ce7909164a4332b4b' => 
    array (
      0 => 'C:\\Users\\delco\\Desktop\\ProgettiProgrammazioneWeb\\GymBuddy\\libs\\Smarty\\templates\\subscriptionForm.tpl',
      1 => 1720360595,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_668ab99c82e688_62940208 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Acquista Abbonamento</title>
</head>
<body>
<h1>Acquista Abbonamento</h1>
<form action="/GymBuddy/subscription/purchaseSubscription" method="post">
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="type">Tipo di Abbonamento:</label>
        <select id="type" name="type" required>
            <option value="individual">Individual</option>
            <option value="coached">Coached</option>
        </select>
    </div>
    <div>
        <label for="duration">Durata (mesi):</label>
        <input type="number" id="duration" name="duration" min="1" required>
    </div>
    <div>
        <label for="price">Prezzo:</label>
        <input type="number" id="price" name="price" step="0.01" required>
    </div>
    <div>
        <button type="submit">Acquista</button>
    </div>
</form>
</body>
</html>
<?php }
}
