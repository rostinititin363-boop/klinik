<?php
require_once __DIR__.'/includes/auth.php';
if (!empty($_SESSION['user'])) { header('Location: dashboard.php'); exit; }
header('Location: login.php'); exit;
