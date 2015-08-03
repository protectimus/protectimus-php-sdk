<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require(__DIR__ . '/bootstrap.php');
use Exception\ProtectimusApiException;

define("USERNAME", "");
define("API_KEY", "");
define("API_URL", "https://api.protectimus.com/");

try {
	$api = new ProtectimusApi(USERNAME, API_KEY, API_URL);

	// IP-address of the end user. Must be specified to perform the
	// validation of geo-filter.
	$ip = "192.168.15.1";

	echo "GETTING A BALANCE<br/>";
	$response = $api->getBalance();
	echo print_r($response, true) . "<br/>";
	$balance = $response->response->balance;
	echo "BALANCE =>>> " . $balance . "<br/>";

	echo "<br/>CREATING A RESOURCE<br/>";
	$response = $api->addResource("resource", 5);
	echo print_r($response, true) . "<br/>";
	$resourceId = $response->response->id;
	echo "ID OF THE CREATED RESOURCE =>>> " . $resourceId . "<br/>";

	echo "<br/>CREATING A USER<br/>";
	$userPassword = "password";
	$response = $api->addUser("login", "login@gmail.com", 12345678912, $userPassword, null, null, true);
	echo print_r($response, true) . "<br/>";
	$userId = $response->response->id;
	echo "ID OF THE CREATED USER =>>> " . $userId . "<br/>";

	echo "<br/>CREATING A TOKEN<br/>";
	$response = $api->addSoftwareToken(null, null, "MAIL",
					"email@gmail.com", "Mail token", null, null, null, null, null, null);
	echo print_r($response, true) . "<br/>";
	$tokenId = $response->response->id;
	echo "ID OF THE CREATED TOKEN =>>> " . $tokenId . "<br/>";

	echo "<br/>ASSIGNING TOKEN WITH ID = " . $tokenId
	. " TO RESOURCE WITH ID = " . $resourceId . "<br/>";
	// assigns token to resource
	$response = $api->assignTokenToResource($resourceId, null, $tokenId);
	echo print_r($response, true) . "<br/>";

	echo "<br/>PREPARING AUTHENTICATION<br/>";
	// In case of use tokens with type such
	// as SMS, MAIL or PROTECTIMUS_OCRA this method must be called
	// before authentication to send sms for SMS-token or send e-mail
	// for
	// MAIL-token or get challenge string for PROTECTIMUS_OCRA-token.
	$response = $api->prepareAuthentication($resourceId, $tokenId, null, null);
	echo print_r($response, true) . "<br/>";

	// one-time password
	$otp = "123456";
	echo "<br/>AUTHENTICATION WITH ONE-TIME PASSWORD<br/>";
	// authenticates MAIL-token with one-time password
	$response = $api->authenticateToken($resourceId, $tokenId, $otp, $ip);
	echo print_r($response, true) . "<br/>";
	$authenticationResult = $response->response->result;
	echo "AUTHENTICATION RESULT =>>> " . var_export($authenticationResult, true) . "<br/>";

	echo "<br/>ASSIGNING USER WITH ID = " . $userId
	. " TO RESOURCE WITH ID = " . $resourceId . "<br/>";
	// assigns user to resource
	$response = $api->assignUserToResource($resourceId, null, $userId, null);
	echo print_r($response, true) . "<br/>";

	echo "<br/>AUTHENTICATION WITH STATIC USER PASSWORD<br/>";
	// authenticates user with static password
	$response = $api->authenticateUserPassword($resourceId, $userId, null, $userPassword, $ip);
	echo print_r($response, true) . "<br/>";
	$authenticationResult = $response->response->result;
	echo "AUTHENTICATION RESULT =>>> " . var_export($authenticationResult, true) . "<br/>";

	echo "<br/>ASSIGNING TOKEN WITH ID = " . $tokenId
	. " TO USER WITH ID = " . $userId . "<br/>";
	// assigns token to user
	$response = $api->assignUserToken($userId, $tokenId);
	echo print_r($response, true) . "<br/>";

	echo "<br/>ASSIGNING USER WITH ID = " . $userId
	. " AND TOKEN WITH ID = " . $tokenId
	. " TOGETHER TO RESOURCE WITH ID = " . $resourceId . "<br/>";
	// assigns user and token together to resource
	$response = $api->assignUserAndTokenToResource($resourceId, null, $userId, null, $tokenId);
	echo print_r($response, true) . "<br/>";

	echo "<br/>AUTHENTICATION WITH ONE-TIME PASSWORD<br/>";
	// authenticates token of user with one-time password
	$response = $api->authenticateUserToken($resourceId, $userId, null, $otp, $ip);
	echo print_r($response, true) . "<br/>";
	$authenticationResult = $response->response->result;
	echo "AUTHENTICATION RESULT =>>> " . var_export($authenticationResult, true) . "<br/>";

	echo "<br/>AUTHENTICATION WITH ONE-TIME PASSWORD AND STATIC USER PASSWORD<br/>";
	// authenticates token of user with one-time password and user with
	// static password
	$response = $api->authenticateUserPasswordToken($resourceId, $userId, null, $otp, $userPassword, $ip);
	echo print_r($response, true) . "<br/>";
	$authenticationResult = $response->response->result;
	echo "AUTHENTICATION RESULT =>>> " . var_export($authenticationResult, true) . "<br/>";

	echo "<br/>DELETING A TOKEN<br/>";
	$response = $api->deleteToken($tokenId);
	echo print_r($response, true) . "<br/>";
	$tokenId = $response->response->token->id;
	echo "ID OF THE DELETED TOKEN =>>> " . $tokenId . "<br/>";

	echo "<br/>DELETING A USER<br/>";
	$response = $api->deleteUser($userId);
	echo print_r($response, true) . "<br/>";
	$userId = $response->response->user->id;
	echo "ID OF THE DELETED USER =>>> " . $userId . "<br/>";

	echo "<br/>DELETING A RESOURCE<br/>";
	$response = $api->deleteResource($resourceId);
	echo print_r($response, true) . "<br/>";
	$resourceId = $response->response->resource->id;
	echo "ID OF THE DELETED RESOURCE =>>> " . $resourceId . "<br/>";

} catch (ProtectimusApiException $e) {
	echo "<br/><br/>";
	echo "Error code => " . $e->errorCode . "<br/>";
	echo "Error message => " . $e->getMessage() . "<br/>";
	echo "Developer message => " . (!empty($e->developerMessage) ? $e->developerMessage : "") . "<br/>";
	echo $e->getTraceAsString();
}

?>
