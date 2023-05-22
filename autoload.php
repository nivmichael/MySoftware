<?php

spl_autoload_register(function ($class_name) {
    require_once "inc/$class_name.class.php";
});
