![GymBuddy Logo](libs/Smarty/img/logo.png)

# GymBuddy - Your Gym Management System

![GymBuddy Homepage](libs/Smarty/img/homePage.png)

# Table of Contents

1. [Information](#information)
2. [Main Features](#main-features)
3. [Requirements](#requirements)
4. [Installation Guide](#installation-guide)
5. [Development Team](#development-team)

## Information

GymBuddy is a web application project designed for managing gym activities, bookings, and workout plans. This project is developed as part of the "Web Programming" exam for Univaq (IT).

GymBuddy uses PHP and Smarty templates to provide a seamless user experience.

**This app would is intended as a project to lean how to design web applications, using the principles of the MVC Pattern and show the potential of our team in the engineering field.**

## Main Features

GymBuddy is a comprehensive gym management system offering the following features:

- User registration and authentication.
- Booking training sessions with or without a personal trainer.
- Viewing and managing workout cards.
- Tracking and managing progress with a progress chart.
- Viewing and managing reservations.


![GymBuddy Profile Page](libs/Smarty/img/menuSection.png)

## Requirements

To install on a local server, you need:

1. Install XAMPP ([Download XAMPP](https://www.apachefriends.org/it/download.html)) on your computer, including PHP.

## Installation Guide

1. Download the git repository. [GymBuddy](https://github.com/MarDLC/GymBuddy.git)
2. Move the repository to the `htdocs/` folder in XAMPP and rename the folder to `GymBuddy`.
3. In the application, locate the `config.php` file in the `app/config` directory and update the parameters according to your XAMPP and MySQL settings.
4. To set up the GymBuddy database: launch XAMPP and run Apache and MySQL, open the browser and type `localhost/phpmyadmin`, create a new database named `gymbuddy` with the character set `utf8_unicode_ci` and import the `gymbuddy.sql` file located in the `GymBuddy/app/install/gymbuddy.sql` folder.
5. To use all the functionalities of the application, run the classes `insertAdminInDB` and `insertPersonalTrainerInDB` from the IDE. These classes are located in the `creation_AD_PT` folder and will insert the two actors into the database.
6. Open your browser and navigate to `localhost/GymBuddy` to access the application.

_Linux users only:_ To make the application work on the terminal, you need to enable read, write, and execute permissions on all application files. Use the command `chmod -R a+rwe path-to-GymBuddy-directory` to enable all permissions. Ensure that all files within the folders have the correct permissions. If they do not, you can use the previous command directly on the affected folders, particularly `libs/Smarty/templates_c`.

p.s. is recommended to use  PHP 7.4 version

## Development Team

- [Mario Del Corvo](https://github.com/MarDLC)
- [Lorenzo Rodorigo](https://github.com/Darth-Enzo)
- [Mattia Giraldi](https://github.com/Cristofly)

## RepositoryGithub
- [GymBuddy](https://github.com/MarDLC/GymBuddy.git)