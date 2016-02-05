<?php 
session_start();
if(true === session_unregister('cppassBSI')) :
   session_destroy();
   sleep(3);
   header('Location: index.php');
else :
   unset($_SESSION['cppassBSI']);
   session_destroy();
   sleep(3);
   header('Location: index.php');
endif;
?> 