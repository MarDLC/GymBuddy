<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RESERVATION FORM</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->

    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/flaticon.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="/GymBuddy/libs/Smarty/css/errorDate.css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/GymBuddy/libs/Smarty/css/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="/GymBuddy/libs/Smarty/css/stylelogin.css">
    <style>
        .invalid-feedback {
            display: none;
            color: red;
            background-color:#212529
            padding: 5px;
            margin-bottom: 0.5em;
            border-radius: 5px;
            position: absolute;
            top: 70px; /* Posizionamento sopra l'input */
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            z-index: 1;
            font-weight: bold;
            font-size: 21px;
        }
        .is-invalid ~ .invalid-feedback {
            display: block;
        }
        .calendar-day {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-bottom: 40px;
            height: 100px; /* Altezza desiderata */
            position: relative; /* Per il posizionamento dell'errore */
        }
        .calendar-day input[type="date"] {
            padding: 10px;
            font-size: 17px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
            background-color: rgb(243, 97, 0); /* Colore di sfondo arancione */
            color: #000000; /* Colore del testo nero */
            border: 1px solid transparent; /* Rimuove il bordo */
            outline: none; /* Rimuove l'outline */
            font-weight: bold;
        }
        .timeslot-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }
        .timeslot-container button {
            width: 150px;
            padding: 15px;
            margin: 10px;
            background-color: rgb(243, 97, 0);
            color: rgb(0, 0, 0);
            font-family: "Bahnschrift", sans-serif;
            border: none;
            font-size: 17px;
            cursor: pointer;
            transition: background-color 0.6s ease;
            font-weight: bold;
        }
        .timeslot-container button:hover {
            background-color: #ffffff;
        }
        .confirm-button {
            text-align: center;
        }
        .confirm-button button {
            background-color: rgb(243, 97, 0);
            color: rgb(0, 0, 0);
            font-family: "Bahnschrift", sans-serif;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.6s ease;
            font-weight: bold;
        }
        .confirm-button button:hover {
            background-color: #ffffff;
        }
        .pt-checkbox-container {
            text-align: center;
            margin-top: 20px;
        }
        .pt-checkbox-container label {
            font-size: 18px;
            font-weight: bold;
            color: rgb(243, 97, 0);
        }
        .pt-checkbox-container input[type="checkbox"] {
            margin-left: 10px;
            accent-color: rgb(243, 97, 0); /* Specifica il colore di accento per il checkbox */
        }
    </style>



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

<!-- Header Section Begin -->
<header class="header-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="logo">
                    <a href="/GymBuddy/User/homeVIP">
                        <img src="/GymBuddy/libs/Smarty/img/logo.png" alt="">
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="nav-menu">
                    <ul>
                        <li class="active"><a href="/GymBuddy/User/homeVIP" id="home-link">Home</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="top-option">
                    <div class="to-social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                    <!-- Aggiunta del pulsante di logout -->
                    <a href="/GymBuddy/User/logout" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
        <div class="canvas-open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header End -->
<!-- Pricing Section Begin -->
<form id="bookingForm" method="POST" action="/GymBuddy/Reservation/booking">
    <section class="pricing-section service-pricing spad">
        <div class="container">
            <div class="section-title">
                <h2>SELECT DAY</h2>
            </div>
            <div class="calendar-day">
                <input type="date" id="calendar-day" name="date" required>
                <div id="calendarDayError" class="invalid-feedback">PLEASE INSERT A VALIDE DATE</div>
            </div>

            <div class="section-title">
                <h2>SELECT THE TIME SLOT</h2>
            </div>
            <div class="timeslot-container">
                <button type="button" onclick="selectCell(this)" value="9:00 - 11:00">9:00 - 11:00</button>
                <button type="button" onclick="selectCell(this)" value="11:00 - 13:00">11:00 - 13:00</button>
                <button type="button" onclick="selectCell(this)" value="13:00 - 15:00">13:00 - 15:00</button>
                <button type="button" onclick="selectCell(this)" value="15:00 - 17:00">15:00 - 17:00</button>
                <button type="button" onclick="selectCell(this)" value="17:00 - 19:00">17:00 - 19:00</button>
                <input type="hidden" id="selected-time" name="time">
            </div>

            <div class="pt-checkbox-container">
                <label for="pt-checkbox">Train with PT</label>
                <input type="checkbox" id="pt-checkbox" name="pt">
            </div>

            <div class="confirm-button">
                <button type="submit" onclick="confirmSelection()">CONFIRM</button>
            </div>
        </div>
    </section>
</form>
<!-- Pricing Section End -->

<!-- Get In Touch Section Begin -->
<div class="gettouch-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="gt-text">
                    <i class="fa fa-map-marker"></i>
                    <p>L'Aquila Via Vetoio, 48<br/> 67100 Coppito AQ</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="gt-text">
                    <i class="fa fa-mobile"></i>
                    <ul>
                        <li>125-711-811</li>
                        <li>125-668-886</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="gt-text email">
                    <i class="fa fa-envelope"></i>
                    <p>support.gymbuddy@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Get In Touch Section End -->

<!-- Footer Section Begin -->
<section class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="fs-about">
                    <div class="fa-logo">
                        <a href="#"><img src="/GymBuddy/libs/Smarty/img/logo.png" alt=""></a>
                    </div>
                    <p>The most iconic gym in the world has arrived in L'Aquila!
                        Live the best training experience in a unique atmosphere.
                        DISCOVER THE LEGACY: GymBuddy L'Aquila.</p>
                    <div class="fa-social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-envelope-o"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="fs-widget">
                    <h4>Useful links</h4>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Classes</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="fs-widget">
                    <h4>Tips & Guides</h4>
                    <div class="fw-recent">
                        <h6><a href="#">Physical fitness may help prevent depression, anxiety</a></h6>
                        <ul>
                            <li>3 min read</li>
                            <li>20 Comment</li>
                        </ul>
                    </div>
                    <div class="fw-recent">
                        <h6><a href="#">Fitness: The best exercise to lose belly fat and tone up...</a></h6>
                        <ul>
                            <li>3 min read</li>
                            <li>20 Comment</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="copyright-text">
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                        All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Footer Section End -->

<!-- Search model Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search model end -->

<!-- Js Plugins -->
<script src="/GymBuddy/libs/Smarty/js/jquery-3.3.1.min.js"></script>
<script src="/GymBuddy/libs/Smarty/js/bootstrap.min.js"></script>
<script src="/GymBuddy/libs/Smarty/js/jquery.magnific-popup.min.js"></script>
<script src="/GymBuddy/libs/Smarty/js/masonry.pkgd.min.js"></script>
<script src="/GymBuddy/libs/Smarty/js/jquery.barfiller.js"></script>
<script src="/GymBuddy/libs/Smarty/js/jquery.slicknav.js"></script>
<script src="/GymBuddy/libs/Smarty/js/owl.carousel.min.js"></script>
<script src="/GymBuddy/libs/Smarty/js/main.js"></script>

<script>
    document.getElementById('bookingForm').addEventListener('submit', function(event) {
        var calendarDayInput = document.getElementById('calendar-day');
        var calendarDayError = document.getElementById('calendarDayError');
        var inputDate = new Date(calendarDayInput.value);
        var today = new Date();
        today.setHours(0, 0, 0, 0); // Clear the time part of today's date

        if (inputDate < today) {
            calendarDayInput.classList.add('is-invalid');
            calendarDayError.style.display = 'block'; // Show the error message
            event.preventDefault(); // Prevent form submission
        } else {
            calendarDayInput.classList.remove('is-invalid');
            calendarDayError.style.display = 'none'; // Hide the error message
        }
    });

    document.getElementById('calendar-day').addEventListener('input', function() {
        var inputDate = new Date(this.value);
        var today = new Date();
        today.setHours(0, 0, 0, 0); // Clear the time part of today's date
        var calendarDayError = document.getElementById('calendarDayError');

        if (inputDate < today) {
            this.classList.add('is-invalid');
            calendarDayError.style.display = 'block'; // Show the error message
        } else {
            this.classList.remove('is-invalid');
            calendarDayError.style.display = 'none'; // Hide the error message
        }
    });

    function selectCell(button) {
        var calendarDay = document.getElementById('calendar-day').value;

        // Verifica se è stata selezionata una data
        if (calendarDay.trim() === '') {
            alert("Seleziona prima una data dal calendario.");
            return;
        }

        // Rimuove la classe selezionata da tutti i pulsanti
        var buttons = document.querySelectorAll('.timeslot-container button');
        buttons.forEach(function (btn) {
            btn.classList.remove('selected');
            btn.classList.remove('temp-selected'); // Rimuove la classe temporanea, se presente
        });

        // Aggiunge la classe selezionata al pulsante cliccato
        button.classList.add('selected');
        button.classList.add('temp-selected'); // Aggiunge la classe temporanea

        // Store the selected time slot in the hidden input field
        document.getElementById('selected-time').value = button.value;
    }

    function confirmSelection() {
        // Trova il pulsante selezionato
        var selectedButton = document.querySelector('button.selected');

        if (selectedButton) {
            // Ottieni il testo del pulsante selezionato
            var selectedText = selectedButton.textContent;
            var trainWithPT = document.getElementById('pt-checkbox').checked ? "Yes" : "No";
            alert('Hai selezionato: ' + selectedText + '\nTrain with PT: ' + trainWithPT);

            // Rimuovi la classe temporanea dopo un breve ritardo (1 secondo)
            setTimeout(function () {
                selectedButton.classList.remove('temp-selected');
            }, 1000);
        } else {
            alert("Seleziona prima un'opzione.");
        }
    }
</script>
</body>
</html>