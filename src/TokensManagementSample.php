<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require(__DIR__ . '/bootstrap.php');
use Exception\ProtectimusApiException;

define("USERNAME", "");
define("API_KEY", "");
define("API_URL", "");

try {
	$api = new ProtectimusApi(USERNAME, API_KEY, API_URL);

	/*echo "<br/>CREATING A TOKEN<br/>";
	$response = $api->addUnifyToken(null, null, "OATH_HOTP", "SHA1", "HEX", "unifytoken", "unifytoken",
                    "a08bc52465e75aa1d99dc19338ebf2e291467fe2", "123456", null, null, null, 8, null);
	echo print_r($response, true) . "<br/>";*/
	
	echo "GETTING SECRET KEY FOR GOOGLE AUTHENTICATOR TOKEN<br/>";
	$response = $api->getGoogleAuthenticatorSecretKey();
	echo print_r($response, true) . "<br/>";
	$secret = $response->response->key;
	echo "SECRET KEY FOR GOOGLE AUTHENTICATOR TOKEN =>>> " . $secret . "<br/>";

	echo "<br/>GETTING SECRET KEY FOR PROTECTIMUS MOBILE TOKEN<br/>";
	$response = $api->getProtectimusSmartSecretKey();
	echo print_r($response, true) . "<br/>";
	$secret = $response->response->key;
	echo "SECRET KEY FOR PROTECTIMUS MOBILE TOKEN =>>> " . $secret . "<br/>";

	echo "<br/>CREATING A TOKEN<br/>";
	$response = $api->addSoftwareToken(null, null, "MAIL",
					"email@gmail.com", "Mail token", null, null, null, null, null, null);
	echo print_r($response, true) . "<br/>";
	$tokenId = $response->response->id;
	echo "ID OF THE CREATED TOKEN =>>> " . $tokenId . "<br/>";

	// to add hardware token you must own it, because you need to
	// provide one-time password from this token
	/*$response = $api->addHardwareToken(null, null, "PROTECTIMUS",
	"797150452", "797150452", null, "220225", true, null, null);
	echo print_r($response, true) . "<br/>";
	$tokenId = $response->response->id;
	echo $tokenId . "<br/>";*/

	echo "<br/>GETTING A TOKEN BY ID<br/>";
	$response = $api->getToken($tokenId);
	echo print_r($response, true) . "<br/>";
	echo "TOKEN =>>> " . print_r($response->response->token, true) . "<br/>";

	echo "<br/>UPDATING A TOKEN<br/>";
	$response = $api->editToken($tokenId, "Mail token new", false, false);
	echo print_r($response, true) . "<br/>";
	echo "UPDATED TOKEN =>>> " . print_r($response->response->token, true) . "<br/>";

	echo "<br/>GETTING A LIST OF TOKENS<br/>";
	// gets a list of tokens descending (10 records starting from 'offset' parameter)
	$response = $api->getTokens(0);
	echo print_r($response, true) . "<br/>";
	echo "TOKENS =>>> " . print_r($response->response->tokens, true) . "<br/>";

	echo "<br/>GETTING A QUANTITY OF TOKENS<br/>";
	$response = $api->getTokensQuantity();
	echo print_r($response, true) . "<br/>";
	$quantity = $response->response->quantity;
	echo "TOKENS QUANTITY =>>> " . $quantity . "<br/>";

	echo "<br/>UNASSIGNING TOKEN WITH ID = " . $tokenId
	. " FROM USER, WHICH HAS THIS TOKEN<br/>";
	// unassigns token from user
	$response = $api->unassignToken($tokenId);
	echo print_r($response, true) . "<br/>";

	echo "<br/>DELETING A TOKEN<br/>";
	$response = $api->deleteToken($tokenId);
	echo print_r($response, true) . "<br/>";
	$tokenId = $response->response->token->id;
	echo "ID OF THE DELETED TOKEN =>>> " . $tokenId . "<br/>";

} catch (ProtectimusApiException $e) {
	echo "<br/><br/>";
	echo "Error code => " . $e->errorCode . "<br/>";
	echo "Error message => " . $e->getMessage() . "<br/>";
	echo "Developer message => " . (!empty($e->developerMessage) ? $e->developerMessage : "") . "<br/>";
	echo $e->getTraceAsString();
}

?>