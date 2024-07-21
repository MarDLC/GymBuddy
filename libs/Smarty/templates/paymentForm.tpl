<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form with Date Validation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .invalid-feedback {
            display: none;
        }
        .is-invalid ~ .invalid-feedback {
            display: block;
        }
    </style>
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
                    <form id="myForm" action="/GymBuddy/User/payment" method="post">
                        <div class="form-group">
                            <label for="cardNumber">Credit card number</label>
                            <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="form-group">
                            <label for="expiryDate">Expiration date</label>
                            <input type="date" class="form-control" id="expiryDate" name="expiryDate" required>
                            <div id="expiryDateError" class="invalid-feedback">Your credit card has expired.</div>
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
    document.getElementById('myForm').addEventListener('submit', function(event) {
        var expiryDateInput = document.getElementById('expiryDate');
        var inputDate = new Date(expiryDateInput.value);
        var today = new Date();
        today.setHours(0, 0, 0, 0); // Clear the time part of today's date

        if (inputDate < today) {
            expiryDateInput.classList.add('is-invalid');
            event.preventDefault(); // Prevent form submission
        } else {
            expiryDateInput.classList.remove('is-invalid');
        }
    });

    document.getElementById('expiryDate').addEventListener('input', function() {
        var inputDate = new Date(this.value);
        var today = new Date();
        today.setHours(0, 0, 0, 0); // Clear the time part of today's date

        if (inputDate < today) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
</script>
</body>
</html>
