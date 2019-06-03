<?php
session_start();

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '860434878997-57tsr3klpeuscj2bh6kc2lg3lu0dn2vh.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'iI-PaPGI8jEzh2cfGN1rgMIa'; //Google client secret
$redirectURL = 'http://localhost/api/'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>