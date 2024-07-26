<?php
session_start();

require_once 'includes/_config.php';
require_once 'includes/_functions.php';
require_once 'includes/_database.php';
require_once 'includes/_message.php';
require_once 'includes/_security.php';
require_once 'includes/_actions-queries.php';

// header('Content-type:application/json');


if (!isset($_REQUEST['action'])) {
    redirectTo();
}

// Check CSRF
preventFromCSRF();

if (!empty($_REQUEST)) {

    if ($_POST['action'] === 'add-spending') {
        addSpending($dbCo);
    }

    if ($_POST['action'] === 'modify-transaction') {
        updateTransaction($dbCo);
    }
}

redirectTo();
