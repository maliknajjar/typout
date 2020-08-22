<?php

// including all wordpress functions
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

// including ip adress function
include_once 'custom_php_functions/visitor_location_info.php';

// GeoLite
require_once 'GeoLite2/geoip2.phar';
use GeoIp2\Database\Reader;
$ip_reader = new Reader( get_template_directory() . '/GeoLite2/GeoLite2-Country.mmdb' );
$ip_result = $ip_reader->country(get_user_ip())->country->name;

// start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();

    $user_ip_country = strtolower($ip_result);
}

// -> deciding what language to use <-
// if user is not logged in 
if(!is_user_logged_in()){
    if(isset($_GET['lang'])){
        if($_GET['lang'] == 'en'){
            $_SESSION['lang'] = 'en';
        }
        elseif($_GET['lang'] == 'ar'){
            $_SESSION['lang'] = 'ar';
        }
        elseif($_GET['lang'] == 'zh'){
            $_SESSION['lang'] = 'zh';
        }
        elseif($_GET['lang'] == 'fr'){
            $_SESSION['lang'] = 'fr';
        }
        elseif($_GET['lang'] == 'ru'){
            $_SESSION['lang'] = 'ru';
        }
        elseif($_GET['lang'] == 'es'){
            $_SESSION['lang'] = 'es';
        }
        else{
            $_SESSION['lang'] = 'en';
        }
    }else{
        if(!isset($_SESSION['lang'])){
            // changing the language based on the country if the user is not logged in
            if($user_ip_country == 'egypt' || $user_ip_country == 'algeria' || $user_ip_country == 'sudan' || $user_ip_country == 'iraq' || $user_ip_country == 'morocco' || $user_ip_country == 'tunisia' || $user_ip_country == 'saudi Arabia' || $user_ip_country == 'yemen' || $user_ip_country == 'syria' || $user_ip_country == 'somalia' || $user_ip_country == 'tunisia' || $user_ip_country == 'jordan' || $user_ip_country == 'united arab emirates' || $user_ip_country == 'lebanon' || $user_ip_country == 'libya' || $user_ip_country == 'palestine' || $user_ip_country == 'oman' || $user_ip_country == 'kuwait' || $user_ip_country == 'mauritania' || $user_ip_country == 'qatar' || $user_ip_country == 'bahrain' || $user_ip_country == 'djibouti' || $user_ip_country == 'comoros'){
                $_SESSION['lang'] = "ar";
            }else{
                $_SESSION['lang'] = "en";
            }
        } 
    }
// if user is logged in 
}else{
    global $wpdb;
    $table_name = '_typ_users';
    $user_id = get_current_user_id();

    $result = $wpdb->get_results ( "SELECT * FROM $table_name WHERE ID = $user_id" );
    $user_id_key = $result[0]->user_lang;

    if($user_id_key){
        $_SESSION['lang'] = $user_id_key;
    }else{
        // changing the language based on the country if the user is logged in
        if($user_ip_country == 'egypt' || $user_ip_country == 'algeria' || $user_ip_country == 'sudan' || $user_ip_country == 'iraq' || $user_ip_country == 'morocco' || $user_ip_country == 'tunisia' || $user_ip_country == 'saudi Arabia' || $user_ip_country == 'yemen' || $user_ip_country == 'syria' || $user_ip_country == 'somalia' || $user_ip_country == 'tunisia' || $user_ip_country == 'jordan' || $user_ip_country == 'united arab emirates' || $user_ip_country == 'lebanon' || $user_ip_country == 'libya' || $user_ip_country == 'palestine' || $user_ip_country == 'oman' || $user_ip_country == 'kuwait' || $user_ip_country == 'mauritania' || $user_ip_country == 'qatar' || $user_ip_country == 'bahrain' || $user_ip_country == 'djibouti' || $user_ip_country == 'comoros'){
            $_SESSION['lang'] = "ar";
        }else{
            $_SESSION['lang'] = "en";
        }
    }
    // sql command to change the lang in the database to the chosen lang chosen by the systeme
    $table_name = '_typ_users';
    $data_update = array('user_lang' => $_SESSION['lang']);
    $data_where = array('ID' => get_current_user_id());
    $wpdb->update($table_name , $data_update, $data_where);
}

include "languages/" . $_SESSION['lang'] . ".php";

?>