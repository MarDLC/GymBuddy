<?php
/* Smarty version 3.1.33, created on 2024-07-21 11:53:07
  from 'C:\Users\delco\Desktop\ProgettiProgrammazioneWeb\GymBuddy\libs\Smarty\templates\clientsList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_669cda83a16f20_61376034',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fcd8f902c4540a4a3c553e907906da03c9c62cba' => 
    array (
      0 => 'C:\\Users\\delco\\Desktop\\ProgettiProgrammazioneWeb\\GymBuddy\\libs\\Smarty\\templates\\clientsList.tpl',
      1 => 1721555125,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669cda83a16f20_61376034 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clients List</title>

    <!-- Google Font -->
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

    <style>
        .selected {
            background-color: #f36100;
        }
    </style>

    <?php echo '<script'; ?>
>
        function ready() {
            if (!navigator.cookieEnabled) {
                alert('Attenzione! Attivare i cookie per proseguire correttamente la navigazione');
            }
        }

        document.addEventListener("DOMContentLoaded", ready);
    <?php echo '</script'; ?>
>

</head>

<body>

<!-- Header Section Begin -->
<header class="header-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="logo">
                    <a href="/GymBuddy/PersonalTrainer/homePT">
                        <img src="/GymBuddy/libs/Smarty/img/logo.png" alt="">
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="nav-menu">
                    <ul>
                        <li><a href="/GymBuddy/PersonalTrainer/homePT">Home</a></li>
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
<!-- Info Section Begin -->
<section class="pricing-section service-pricing spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>YOUR SUBSCRIPTION</span>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
    <div class="col-lg-12">
        <table class="table" id="peopleTable">
            <thead>
            <tr>


                <th>NAME</th>
                <th>SURNAME</th>
                <th>EMAIL</th>
                <th>OPTIONS</th>
            </tr>
            </thead>
            <tbody id="user-table-body">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['clients']->value, 'client');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['client']->value) {
?>
                <tr>

                    <td><?php echo $_smarty_tpl->tpl_vars['client']->value['name'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['client']->value['surname'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['client']->value['email'];?>
</td>
                    <td>
                        <!-- Form for selecting the user for Physical Data -->
                        <form action="/GymBuddy/PhysicalData/physicalDataForm" method="post">
                            <!-- Hidden field with the user ID -->
                            <input type="hidden" name="selected_user" value="<?php echo $_smarty_tpl->tpl_vars['client']->value['idUser'];?>
">
                            <!-- Button to select the user -->
                            <button type="submit" class="btn btn-primary">Physical Data</button>
                        </form>
                        <!-- Form for selecting the user for Training Card -->
                        <form action="/GymBuddy/TrainingCard/trainingCardForm" method="post">
                            <!-- Hidden field with the user ID -->
                            <input type="hidden" name="selected_user" value="<?php echo $_smarty_tpl->tpl_vars['client']->value['idUser'];?>
">
                            <!-- Button to select the user -->
                            <button type="submit" class="btn btn-primary">Training Card</button>
                        </form>
                    </td>
                </tr>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </tbody>
        </table>
    </div>
</div>

    </div>
</section>
<!-- Info Section End -->
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
                        <a href="/GymBuddy/PersonalTrainer/homePT"><img src="/GymBuddy/libs/Smarty/img/logo.png" alt=""></a>
                    </div>
                    <p>The most iconic gym in the world has arrived in L'Aquila!
                        Live the best training experience in a unique atmosphere.
                        DISCOVER THE LEGACY: GymBuddy L'Aquila.</p>
                    <div class="fa-social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa  fa-envelope-o"></i></a>
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
                        <h6><a href="#">Fitness: The best exercise to lose belly fat</a></h6>
                        <ul>
                            <li>3 min read</li>
                            <li>20 Comment</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="fs-text">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<?php echo '<script'; ?>
>document.write(new Date().getFullYear());<?php echo '</script'; ?>
>
                    All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by
                    <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
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
<?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/jquery-3.3.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/jquery.magnific-popup.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/masonry.pkgd.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/jquery.barfiller.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/jquery.slicknav.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/owl.carousel.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GymBuddy/libs/Smarty/js/main.js"><?php echo '</script'; ?>
>


<!-- Codice per la gestione della tabella -->

<?php echo '<script'; ?>
>
    document.addEventListener('DOMContentLoaded', () => {
        const tableRows = document.querySelectorAll('#peopleTable tbody tr');

        let selectedRow = null; // Memorizza la riga attualmente selezionata

        // Aggiunta dell'event listener al clic sulle righe della tabella
        tableRows.forEach(row => {
            row.addEventListener('click', () => {
                // Se la riga cliccata è già selezionata, deseleziona
                if (selectedRow === row) {
                    row.classList.remove('selected');
                    selectedRow = null;
                } else {
                    // Deseleziona la riga attualmente selezionata
                    if (selectedRow) {
                        selectedRow.classList.remove('selected');
                    }

                    // Seleziona la riga cliccata
                    row.classList.add('selected');
                    selectedRow = row;
                }
            });
        });
    });
<?php echo '</script'; ?>
>

</body>

</html>
<?php }
}
