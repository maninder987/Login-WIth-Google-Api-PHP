<?php
session_start();

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = 'Google client ID'; //Google client ID
$clientSecret = 'Google client secret'; //Google client secret
$redirectURL = 'Callback URL'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>