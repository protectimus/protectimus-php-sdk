<?php

use Httpful\Mime;
use Httpful\Http;

class ResourceServiceClient extends AbstractServiceClient {

	protected function getServiceName() {
		return "resource-service";
	}

	public function __construct($_username, $_api_key, $_api_url, $_response_format, $_version) {
		parent::__construct($_username, $_api_key, $_api_url, $_response_format, $_version);
	}

	public function getResources($offset = 0, $limit = 10) {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "resources." . $this->_response_format
		."?start=". (!empty($offset) ? $offset : "0"). "&limit=". (!empty($limit) ? $limit : "10"))->send();
		return $this->checkResponse($response);
	}

	public function getResource($resourceId) {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "resources/" . $resourceId . "." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function addResource($resourceName, $failedAttemptsBeforeLock) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "resources." . $this->_response_format)
		->body(array("resourceName" => $resourceName, "failedAttemptsBeforeLock" => $failedAttemptsBeforeLock))
		->send();
		return $this->checkResponse($response);
	}

	public function editResource($resourceId, $resourceName, $failedAttemptsBeforeLock) {
		$response = $this->getClient(Http::PUT)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "resources/" . $resourceId . "." . $this->_response_format)
		->body(array("resourceName" => $resourceName, "failedAttemptsBeforeLock" => $failedAttemptsBeforeLock))
		->send();
		return $this->checkResponse($response);
	}

	public function deleteResource($resourceId) {
		$response = $this->getClient(Http::DELETE)
		->uri($this->getServiceUri() . "resources/" . $resourceId . "." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function getResourcesQuantity() {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "resources/quantity." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function assignUserToResource($resourceId, $resourceName, $userId, $userLogin) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "assign/user." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "resourceName" => $resourceName, "userId" => $userId, "userLogin" => $userLogin))
		->send();
		return $this->checkResponse($response);
	}

	public function assignTokenToResource($resourceId, $resourceName, $tokenId) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "assign/token." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "resourceName" => $resourceName, "tokenId" => $tokenId))
		->send();
		return $this->checkResponse($response);
	}

	public function assignUserAndTokenToResource($resourceId, $resourceName, $userId, $userLogin, $tokenId) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "assign/user-token." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "resourceName" => $resourceName, "userId" => $userId, "userLogin" => $userLogin, "tokenId" => $tokenId))
		->send();
		return $this->checkResponse($response);
	}

	public function assignTokenWithUserToResource($resourceId, $resourceName, $tokenId) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "assign/token-with-user." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "resourceName" => $resourceName, "tokenId" => $tokenId))
		->send();
		return $this->checkResponse($response);
	}

	public function unassignUserFromResource($resourceId, $resourceName, $userId, $userLogin) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "unassign/user." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "resourceName" => $resourceName, "userId" => $userId, "userLogin" => $userLogin))
		->send();
		return $this->checkResponse($response);
	}

	public function unassignTokenFromResource($resourceId, $resourceName, $tokenId) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "unassign/token." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "resourceName" => $resourceName, "tokenId" => $tokenId))
		->send();
		return $this->checkResponse($response);
	}

	public function unassignUserAndTokenFromResource($resourceId, $resourceName, $userId, $userLogin, $tokenId) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "unassign/user-token." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "resourceName" => $resourceName, "userId" => $userId, "userLogin" => $userLogin, "tokenId" => $tokenId))
		->send();
		return $this->checkResponse($response);
	}

	public function unassignTokenWithUserFromResource($resourceId, $resourceName, $tokenId) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "unassign/token-with-user." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "resourceName" => $resourceName, "tokenId" => $tokenId))
		->send();
		return $this->checkResponse($response);
	}

}