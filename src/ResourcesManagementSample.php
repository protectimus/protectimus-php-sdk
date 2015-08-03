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

	echo "CREATING A RESOURCE<br/>";
	$response = $api->addResource("resource", 5);
	echo print_r($response, true) . "<br/>";
	$resourceId = $response->response->id;
	echo "ID OF THE CREATED RESOURCE =>>> " . $resourceId . "<br/>";

	echo "<br/>GETTING A RESOURCE BY ID<br/>";
	$response = $api->getResource($resourceId);
	echo print_r($response, true) . "<br/>";
	echo "RESOURCE =>>> " . print_r($response->response->resource, true) . "<br/>";

	echo "<br/>UPDATING A RESOURCE<br/>";
	$response = $api->editResource($resourceId, "resourceNew", 8);
	echo print_r($response, true) . "<br/>";
	echo "UPDATED RESOURCE =>>> " . print_r($response->response->resource, true) . "<br/>";

	echo "<br/>GETTING A LIST OF RESOURCES<br/>";
	// gets a list of resources descending (10 records starting from 'offset' parameter)
	$response = $api->getResources(0, 10);
	echo print_r($response, true) . "<br/>";
	echo "RESOURCES =>>> " . print_r($response->response->resources, true) . "<br/>";

	echo "<br/>GETTING A QUANTITY OF RESOURCES<br/>";
	$response = $api->getResourcesQuantity();
	echo print_r($response, true) . "<br/>";
	$quantity = $response->response->quantity;
	echo "RESOURCES QUANTITY =>>> " . $quantity . "<br/>";

	echo "<br/>CREATING A USER<br/>";
	$response = $api->addUser("login", "login@gmail.com", 12345678912, "pwd", null, null, true);
	echo print_r($response, true) . "<br/>";
	$userId = $response->response->id;
	echo "ID OF THE CREATED USER =>>> " . $userId . "<br/>";

	echo "<br/>ASSIGNING USER WITH ID = " . $userId
	. " TO RESOURCE WITH ID = " . $resourceId . "<br/>";
	// assigns user to resource
	$response = $api->assignUserToResource($resourceId, null, $userId, null);
	echo print_r($response, true) . "<br/>";

	echo "<br/>UNASSIGNING USER WITH ID = " . $userId
	. " FROM RESOURCE WITH ID = " . $resourceId . "<br/>";
	// unassigns user from resource
	$response = $api->unassignUserFromResource($resourceId, null, $userId, null);
	echo print_r($response, true) . "<br/>";

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

	echo "<br/>UNASSIGNING TOKEN WITH ID = " . $tokenId
	. " FROM RESOURCE WITH ID = " . $resourceId . "<br/>";
	// unassigns token from resource
	$response = $api->unassignTokenFromResource($resourceId, null, $tokenId);
	echo print_r($response, true) . "<br/>";

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

	echo "<br/>UNASSIGNING USER WITH ID = " . $userId
	. " AND TOKEN WITH ID = " . $tokenId
	. " TOGETHER FROM RESOURCE WITH ID = " . $resourceId . "<br/>";
	// unassigns user and token together from resource
	$response = $api->unassignUserAndTokenFromResource($resourceId, null, $userId, null, $tokenId);
	echo print_r($response, true) . "<br/>";

	echo "<br/>ASSIGNING TOKEN WITH ID = "
	. $tokenId
	. " AND USER, WHICH HAS THIS TOKEN, TOGETHER TO RESOURCE WITH ID = "
	. $resourceId . "<br/>";
	// assigns user and token together to resource (userId does not
	// specified, because token is already assigned to user)
	$response = $api->assignTokenWithUserToResource($resourceId, null, $tokenId);
	echo print_r($response, true) . "<br/>";

	echo "<br/>UNASSIGNING TOKEN WITH ID = "
	. $tokenId
	. " AND USER, WHICH HAS THIS TOKEN, TOGETHER FROM RESOURCE WITH ID = "
	. $resourceId . "<br/>";
	// unassigns user and token together from resource (userId does not
	// specified, because token is already assigned to user)
	$response = $api->unassignTokenWithUserFromResource($resourceId, null, $tokenId);
	echo print_r($response, true) . "<br/>";

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