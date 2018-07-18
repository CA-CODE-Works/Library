<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$currentPage = basename($_SERVER['PHP_SELF']);

// add handler for post and get requests
include('core/handler.php');
if (isset($_GET['action'])) {
    print getRequestHandler($_GET);
    die();
} elseif (isset($_POST['action'])) {
    print postRequestHandler($_POST);
    die();
}

?>
