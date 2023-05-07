<?php
spl_autoload_register(function ($class_name) {
    include 'inc/' . $class_name . '.class.php';
});

?>