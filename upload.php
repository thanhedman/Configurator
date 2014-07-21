<?php
include('connection.php');
include('SessionHelper.php');

ERROR = 'There was an error with your session, please reload the app and try again.';

if ( $_SESSION['storeHash'] && $_SESSION['accessToken'] ) {
	//upload form goes here
} else {
	header( 'Location: https://applications.intuitsolutions.net/configurator/load.php' );
}