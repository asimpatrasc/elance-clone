<?php
session_start();
// Sends the user to the login-page if not logged in
if(!isset($_SESSION['cppassBSI'])) {
   header('Location:index.php?msg=requires_login');
   exit;
}
?>