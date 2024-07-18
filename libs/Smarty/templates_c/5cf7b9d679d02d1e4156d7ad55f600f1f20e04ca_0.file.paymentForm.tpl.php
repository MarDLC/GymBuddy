<?php
/* Smarty version 3.1.33, created on 2024-07-18 17:19:58
  from 'C:\Users\delco\Desktop\ProgettiProgrammazioneWeb\GymBuddy\libs\Smarty\templates\paymentForm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6699329ebb27a4_10414078',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5cf7b9d679d02d1e4156d7ad55f600f1f20e04ca' => 
    array (
      0 => 'C:\\Users\\delco\\Desktop\\ProgettiProgrammazioneWeb\\GymBuddy\\libs\\Smarty\\templates\\paymentForm.tpl',
      1 => 1721315997,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6699329ebb27a4_10414078 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAYMENT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header">
                    <h2>Enter your credit card information</h2>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="cardNumber">Credit card number</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="form-group">
                            <label for="expiryDate">Expiration date (MM/YY)</label>
                            <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
                            <div id="expiryDateError" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" class="form-control" id="cvv" placeholder="123" required>
                        </div>
                        <div class="form-group">
                            <label for="cardHolderName">Name</label>
                            <input type="text" class="form-control" id="cardHolderName" placeholder="Name and Surname" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Pay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo '<script'; ?>
>
    document.getElementById('expiryDate').addEventListener('input', function (e) {
        var input = e.target.value;
        var expiryDateError = document.getElementById('expiryDateError');
        var month = input.split('/')[0];
        if (input.length === 2 && !input.includes('/')) {
            input += '/';
            document.getElementById('expiryDate').value = input;
        } else if (month > 12) {
            expiryDateError.textContent = 'Il mese non può essere superiore a 12';
            document.getElementById('expiryDate').classList.add('is-invalid');
        } else {
            expiryDateError.textContent = '';
            document.getElementById('expiryDate').classList.remove('is-invalid');
        }
    });
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
