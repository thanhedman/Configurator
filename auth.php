<?php
	include('connection.php');
	include('SessionHelper.php');

	CLIENT_ID = '';
	CLIENT_SECRET = '';
	AUTH_CALLBACK_URI = 'https://applications.intuitsolutions.net/configurator/auth.php';
	ERROR = 'There was an error connecting to your store, please uninstall the app and try again.';

	$code = $_GET['code'];
	$scope = $_GET['scope'];
	$context = $_GET['context'];
	$array = explode('/', $context);
	$store_hash = $array[1];

	$response = Connection::getAccessToken(CLIENT_ID, CLIENT_SECRET, AUTH_CALLBACK_URI, $code, $scope, $context);

	$merchantArray = array(
		'storeHash' => $store_hash,
		'accessToken' => $response->access_token
	);

	//TO DO: store $merchantArray
	$paramArray = array($merchantArray['store_hash'], $merchantArray['accessToken']);

	//Do first time configuration stuff
	$connection = new Connection( CLIENT_ID, $merchantArray['storeHash'], $merchantArray['accessToken'] );

	if ( $connection->get('time') ) {
		SessionHelper::secSessionStart();
		$_SESSION['storeHash'] = $merchantArray['storeHash'];
		$_SESSION['accessToken'] = $merchantArray['accessToken'];
		//redirect to upload form
		header( 'Location: https://applications.intuitsolutions.net/configurator/upload.php' ) ;
	} else {
		echo ERROR;
	}