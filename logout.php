<?php
// Initialize session.
session_start();

session_destroy();

header('Location: login.php');
exit;