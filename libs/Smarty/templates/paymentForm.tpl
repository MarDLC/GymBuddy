<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAYMENT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script>
        function ready(){
            if (!navigator.cookieEnabled) {
                alert('Attenzione! Attivare i cookie per proseguire correttamente la navigazione');
            }
        }
        document.addEventListener("DOMContentLoaded", ready);
    </script>

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
                    <form action="/GymBuddy/User/payment" method="post">
                        <div class="form-group">
                            <label for="cardNumber">Credit card number</label>
                            <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="form-group">
                            <label for="expiryDate">Expiration date</label>
                            <input type="date" class="form-control" id="expiryDate" name="expiryDate" required>
                            <div id="expiryDateError" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" required>
                        </div>
                        <div class="form-group">
                            <label for="cardHolderName">Name</label>
                            <input type="text" class="form-control" id="cardHolderName" name="accountHolder" placeholder="Name and Surname" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Pay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
</script>
</body>
</html>