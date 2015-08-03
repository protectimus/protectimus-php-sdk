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

	echo "CREATING A USER<br/>";
	$response = $api->addUser("login", "login@gmail.com", 12345678912, "pwd", null, null, true);
	echo print_r($response, true) . "<br/>";
	$userId = $response->response->id;
	echo "ID OF THE CREATED USER =>>> " . $userId . "<br/>";

	echo "<br/>GETTING A USER BY ID<br/>";
	$response = $api->getUser($userId);
	echo print_r($response, true) . "<br/>";
	echo "USER =>>> " . print_r($response->response->user, true) . "<br/>";

	echo "<br/>UPDATING A USER<br/>";
	$response = $api->editUser($userId, "loginNew", "loginNew@gmail.com", 98765432112, null, null, null, false);
	echo print_r($response, true) . "<br/>";
	echo "UPDATED USER =>>> " . print_r($response->response->user, true) . "<br/>";

	echo "<br/>UPDATING USERS PASSWORD<br/>";
	$response = $api->editUsersPassword($userId, null,
							"a7d48dbb7165641112ad1da9c59a6140",
							"5f4dcc3b5aa765d61d8327deb882cf99", "MD5",
							"PASS{HEX_SALT}");
	echo print_r($response, true) . "<br/>";

	echo "<br/>GETTING A LIST OF USERS<br/>";
	$response = $api->getUsers(0);
	echo print_r($response, true) . "<br/>";
	echo "USERS =>>> " . print_r($response->response->users, true) . "<br/>";

	echo "<br/>GETTING A QUANTITY OF USERS<br/>";
	$response = $api->getUsersQuantity();
	echo print_r($response, true) . "<br/>";
	$quantity = $response->response->quantity;
	echo "USERS QUANTITY =>>> " . $quantity . "<br/>";

	echo "<br/>CREATING A TOKEN<br/>";
	$response = $api->addSoftwareToken(null, null, "MAIL",
					"email@gmail.com", "Mail token", null, null, null, null, null, null);
	echo print_r($response, true) . "<br/>";
	$tokenId = $response->response->id;
	echo "ID OF THE CREATED TOKEN =>>> " . $tokenId . "<br/>";

	echo "<br/>ASSIGNING TOKEN WITH ID = " . $tokenId
	. " TO USER WITH ID = " . $userId . "<br/>";
	// assigns token to user
	$response = $api->assignUserToken($userId, $tokenId);
	echo print_r($response, true) . "<br/>";

	echo "<br/>GETTING A LIST OF TOKENS OF THE USER<br/>";
	// gets a list of of tokens of the user descending (10 records starting from 'offset' parameter)
	$response = $api->getUserTokens($userId, 0, 10);
	echo print_r($response, true) . "<br/>";
	echo "TOKENS OF THE USER =>>> " . print_r($response->response->tokens, true) . "<br/>";

	echo "<br/>GETTING A QUANTITY OF TOKENS OF THE USER<br/>";
	$response = $api->getUserTokensQuantity($userId);
	echo print_r($response, true) . "<br/>";
	$quantity = $response->response->quantity;
	echo "QUANTITY OF TOKENS OF THE USER =>>> " . $quantity . "<br/>";

	echo "<br/>UNASSIGNING TOKEN WITH ID = " . $tokenId
	. " FROM USER WITH ID = " . $userId . "<br/>";
	// unassigns token to user
	$response = $api->unassignUserToken($userId, $tokenId);
	echo print_r($response, true) . "<br/>";

	echo "<br/>GETTING A LIST OF TOKENS OF THE USER<br/>";
	// gets a list of of tokens of the user descending (10 records starting from 'offset' parameter)
	$response = $api->getUserTokens($userId, 0, 10);
	echo print_r($response, true) . "<br/>";
	echo "TOKENS OF THE USER =>>> " . print_r(!empty($response->response->tokens) ? $response->response->tokens : "", true) . "<br/>";

	echo "<br/>GETTING A QUANTITY OF TOKENS OF THE USER<br/>";
	$response = $api->getUserTokensQuantity($userId);
	echo print_r($response, true) . "<br/>";
	$quantity = $response->response->quantity;
	echo "QUANTITY OF TOKENS OF THE USER =>>> " . $quantity . "<br/>";

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

} catch (ProtectimusApiException $e) {
	echo "<br/><br/>";
	echo "Error code => " . $e->errorCode . "<br/>";
	echo "Error message => " . $e->getMessage() . "<br/>";
	echo "Developer message => " . (!empty($e->developerMessage) ? $e->developerMessage : "") . "<br/>";
	echo $e->getTraceAsString();
}

?>