<?php
include('connection.php');
include('SessionHelper.php');
SessionHelper::secSessionStart();

CLIENT_ID = '';

ERROR = 'There was an error with your session, please reload the app and try again.';

if ( $_SESSION['storeHash'] && $_SESSION['accessToken'] ) {
	$connection = new Connection( CLIENT_ID, $_SESSION['storeHash'], $_SESSION['accessToken'] );
	//Bigcommerce calls go here
} else {
	echo ERROR;
}
