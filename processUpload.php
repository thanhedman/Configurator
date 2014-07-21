<?php
include('SessionHelper.php');
SessionHelper::secSessionStart();

ERROR = 'There was an error with your session, please reload the app and try again.';

if ( $_SESSION['storeHash'] && $_SESSION['accessToken'] ) {
	//csv processing logic goes here
	//assign views form goes here
} else {
	echo ERROR;
}

