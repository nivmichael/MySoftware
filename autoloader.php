<?php
// Add autoloader - learn the difference between require/one include/once
spl_autoload_register(function ($class_name) {
    include 'inc/' . $class_name . '.class.php';
});