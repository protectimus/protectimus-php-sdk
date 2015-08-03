<?php

use Httpful\Mime;
use Httpful\Http;

class UserServiceClient extends AbstractServiceClient {

	protected function getServiceName() {
		return "user-service";
	}

	public function __construct($_username, $_api_key, $_api_url, $_response_format, $_version) {
		parent::__construct($_username, $_api_key, $_api_url, $_response_format, $_version);
	}

	public function getUsers($offset = 0, $limit = 10) {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "users." . $this->_response_format
		."?start=". (!empty($offset) ? $offset : "0"). "&limit=". (!empty($limit) ? $limit : "10"))->send();
		return $this->checkResponse($response);
	}

	public function getUser($userId) {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "users/" . $userId . "." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function addUser($login, $email = null, $phoneNumber = null, $password = null, $firstName = null, $secondName = null, $apiSupport = true) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "users." . $this->_response_format)
		->body(array("login" => $login, "email" => $email, "phoneNumber" => $phoneNumber, "password" => $password,
						"firstName" => $firstName, "secondName" => $secondName, "apiSupport" => var_export($apiSupport, true)))
		->send();
		return $this->checkResponse($response);
	}

	public function editUser($userId, $login = null, $email = null, $phoneNumber = null, $password = null, $firstName = null, $secondName = null, $apiSupport = true) {
		$response = $this->getClient(Http::PUT)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "users/" . $userId . "." . $this->_response_format)
		->body(array("login" => $login, "email" => $email, "phoneNumber" => $phoneNumber, "password" => $password,
						"firstName" => $firstName, "secondName" => $secondName, "apiSupport" => var_export($apiSupport, true)))
		->send();
		return $this->checkResponse($response);
	}

	public function editUsersPassword($userId, $userLogin, $rawPassword, $rawSalt, $encodingType, $encodingFormat) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "users/password." . $this->_response_format)
		->body(array("id" => $userId, "login" => $userLogin, "rawPassword" => $rawPassword, "rawSalt" => $rawSalt, "encodingType" => $encodingType, "encodingFormat" => $encodingFormat))
		->send();
		return $this->checkResponse($response);
	}

	public function deleteUser($userId) {
		$response = $this->getClient(Http::DELETE)
		->uri($this->getServiceUri() . "users/" . $userId . "." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function getUsersQuantity() {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "users/quantity." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function getUserTokens($userId, $offset = 0) {
		$response = $this->getClient(Http::GET)
		->uri($this->getServiceUri() . "users/" . $userId . "/tokens." . $this->_response_format
		. (!empty($offset) ? "?start=" . $offset : ""))->send();
		return $this->checkResponse($response);
	}

	public function getUserTokensQuantity($userId) {
		$response = $this->getClient(Http::GET)
		->uri($this->getServiceUri() . "users/" . $userId . "/tokens/quantity." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function assignUserToken($userId, $tokenId) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "users/" . $userId . "/tokens/" . $tokenId . "/assign." . $this->_response_format)
		->body(array("userId" => $userId, "tokenId" => $tokenId))
		->send();
		return $this->checkResponse($response);
	}

	public function unassignUserToken($userId, $tokenId) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "users/" . $userId . "/tokens/" . $tokenId . "/unassign." . $this->_response_format)
		->body(array("userId" => $userId, "tokenId" => $tokenId))
		->send();
		return $this->checkResponse($response);
	}

}