<?php

require_once "config.php";
require_once "header.php";


$url = 'http://www.example.com';



echo '<pre>';
print_r(get_headers($url));
echo '</pre>';
