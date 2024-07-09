<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/logcss.css"type="text/css">


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
            margin-top: 10px; /* Aggiunto margine superiore per separare il messaggio dal form */
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-container">
        <h2>Accedi al tuo account</h2>
        {if isset($error_message)}
            <p class="error-message">{$error_message}</p>
        {/if}
        <form id="login-form" action="/GymBuddy/User/checkLogin" method="post">
            <div class="form-group">
                <label for="email">Indirizzo email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Accedi</button>
        </form>
        <div class="text-center mt-3">
            <a href="/GymBuddy/libs/Smarty/html/registrazione.html" class="btn btn-secondary btn-sm">Registrati</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (!navigator.cookieEnabled) {
            alert('Attenzione! Attivare i cookie per proseguire correttamente la navigazione');
        }
    });
</script>

</body>
</html>