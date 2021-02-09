<?php
    include 'controller/controller.php';
    $_SESSION['controller'] = new Controller(new DatabaseConnection());
?>