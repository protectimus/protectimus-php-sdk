<?php

use Httpful\Mime;
use Httpful\Http;

class AuthServiceClient extends AbstractServiceClient {

	protected function getServiceName() {
		return "auth-service";
	}

	public function __construct($_username, $_api_key, $_api_url, $_response_format, $_version) {
		parent::__construct($_username, $_api_key, $_api_url, $_response_format, $_version);
	}

	public function getBalance()  {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "balance." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function prepare($resourceId, $tokenId = null, $userId = null, $userLogin = null) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "prepare." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "tokenId" => $tokenId, "userId" => $userId, "userLogin" => $userLogin))
		->send();
		return $this->checkResponse($response);
	}

	public function authenticateToken($resourceId, $tokenId, $otp, $ip = null) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "authenticate/token." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "tokenId" => $tokenId, "otp" => $otp, "ip" => $ip))
		->send();
		return $this->checkResponse($response);
	}

	public function authenticateUserPassword($resourceId, $userId = null, $userLogin = null, $password, $ip = null) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "authenticate/user-password." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "userId" => $userId, "userLogin" => $userLogin, "pwd" => $password, "ip" => $ip))
		->send();
		return $this->checkResponse($response);
	}

	public function authenticateUserToken($resourceId, $userId = null, $userLogin = null, $otp, $ip = null) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "authenticate/user-token." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "userId" => $userId, "userLogin" => $userLogin, "otp" => $otp, "ip" => $ip))
		->send();
		return $this->checkResponse($response);
	}

	public function authenticateUserPasswordToken($resourceId, $userId = null, $userLogin = null, $otp, $password, $ip = null) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "authenticate/user-password-token." . $this->_response_format)
		->body(array("resourceId" => $resourceId, "userId" => $userId, "userLogin" => $userLogin, "otp" => $otp, "pwd" => $password, "ip" => $ip))
		->send();
		return $this->checkResponse($response);
	}

}