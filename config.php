<?php

    // switch on output buffering
    ob_start();

    // start session
    session_start();

    //Enable error messages for development
    ini_set("display_errors", "off");
    //error_reporting(E_ALL);

    //Set timezone
    date_default_timezone_set('Europe/London');

    // define the API key
    define('API_KEY', "key goes here");

    /****** CHECK OR SET THE REGION ******/

        // get region from URL as long as it matches one of the three options
        if (isset($_GET['region']) && ($_GET['region'] == 'euw'
               || $_GET['region'] == 'eune'
               || $_GET['region'] == 'na')){
            
            $get_region = $_GET['region']; 

            // set session
            $_SESSION['region'] = $get_region;
            // set cookie that will last 3 days
            setcookie('champMastery_region', $get_region, time() + (3600 * 24 * 3));

            $chosen_region = $get_region;
        } 
        // or else get the region from the session
        else if (isset($_SESSION['region'])){

            $chosen_region = $_SESSION['region'];
        }
        // or else get the region from the cookie
        else if (isset($_COOKIE['champMastery_region'])){

            $chosen_region = $_COOKIE['champMastery_region'];
        }
        // if all else fails, set the default region (euw)
        else {

            $chosen_region = 'euw';
            $_SESSION['region'] = 'euw';
            $_COOKIE['champMastery_region'] = 'euw';
        }

?>