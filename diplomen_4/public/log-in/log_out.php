<?php
// filepath: /c:/xampp/htdocs/diplomen_4/public/log-in/log_out.php
session_start();
session_unset();
session_destroy();
header('Location: /diplomen_4/public/log-in/log_in.php');
exit();
?>