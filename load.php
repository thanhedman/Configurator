<?php
	include('connection.php');
	include('SessionHelper.php');

	CLIENT_SECRET = '';
	ERROR = 'There was an error authenticating your request, please try again.';

	function verify($signedRequest) {
		list($payload, $encodedSignature) = explode('.', $signedRequest, 2); 

		// decode the data
		$signature = base64_decode($encodedSignature);
		$data = json_decode(base64_decode($payload), true);

		// confirm the signature
		$expectedSignature = hash_hmac('sha256', $payload, CLIENT_SECRET, $raw = true);
	
		if (secureCompare($signature, $expectedSignature)) {
			return null;
		}

		return $data;
	}

	function secureCompare($str1, $str2) {
		$res = $str1 ^ $str2;
		$ret = strlen($str1) ^ strlen($str2); //not the same length, then fail ($ret != 0)
		for($i = strlen($res) - 1; $i >= 0; $i--) {
			$ret += ord($res[$i]);
		}
		return !$ret;	
	}

		$signedRequest = $_GET['signed_payload'];
		$valid = verify($signedRequest);
		if ($valid) {
			//Get $accessToken from $storeHash = $valid->store_hash;
			$select = self::$pdo->prepare( 'SELECT * FROM merchants WHERE storeHash = :storeHash LIMIT 1');
			$select->bindParam(':storeHash', $valid->store_hash);
			$select->execute();
			$resultArray = $select->fetchAll();
			$storeHash = $resultArray['storeHash'];
			$accessToken = $resultArray['accessToken'];
			SessionHelper::secSessionStart();
			$_SESSION['storeHash'] = $storeHash;
			$_SESSION['accessToken'] = $accessToken;
			header( 'Location: https://applications.intuitsolutions.net/configurator/upload.php' ) ;
		} else {
			echo ERROR;
		}