<?php
if (!isset($_SESSION['eventLogin'])) {
    header('Location: ../auth/login.php');
    exit;
}
