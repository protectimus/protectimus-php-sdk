<?php

use Httpful\Mime;
use Httpful\Http;

class TokenServiceClient extends AbstractServiceClient {

	protected function getServiceName() {
		return "token-service";
	}

	public function __construct($_username, $_api_key, $_api_url, $_response_format, $_version) {
		parent::__construct($_username, $_api_key, $_api_url, $_response_format, $_version);
	}

	public function getGoogleAuthenticatorSecretKey() {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "secret-key/google-authenticator." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function getProtectimusSmartSecretKey() {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "secret-key/protectimus-smart." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function getTokens($offset = 0) {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "tokens." . $this->_response_format
		. (!empty($offset) ? "?start=" . $offset : ""))->send();
		return $this->checkResponse($response);
	}

	public function getToken($tokenId) {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "tokens/" . $tokenId . "." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function addUnifyToken($userId = null, $userLogin = null, $unifyType, $unifyKeyAlgo, $unifyKeyFormat, $serialNumber = null, $name = null, $secret = null, $otp = null, $otpLength = null, $pin = null, $pinOtpFormat = null, $counter = null, $challenge = null) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "tokens/unify." . $this->_response_format)
		->body(array("userId" => $userId, "userLogin" => $userLogin, "unifyType" => $unifyType, "unifyKeyAlgo" => $unifyKeyAlgo, "unifyKeyFormat" => $unifyKeyFormat,
					"serial" => $serialNumber, "name" => $name, "secret" => $secret, "otp" => $otp, "otpLength" => $otpLength, 
					"pin" => $pin, "pinOtpFormat" => $pinOtpFormat, "counter" => $counter, "challenge" => $challenge))
		->send();
		return $this->checkResponse($response);
	}

	public function addSoftwareToken($userId = null, $userLogin = null, $type, $serialNumber = null, $name = null, $secret = null, $otp = null, $otpLength = null, $keyType = null, $pin = null, $pinOtpFormat = null) {
		if ($type == "MAIL" || $type == "SMS") {
			$otp = "123456";
			$secret = $otp;
		}
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "tokens/software." . $this->_response_format)
		->body(array("userId" => $userId, "userLogin" => $userLogin, "type" => $type, "serial" => $serialNumber,
					"name" => $name, "secret" => $secret, "otp" => $otp, "otpLength" => $otpLength, "keyType" => $keyType,
					"pin" => $pin, "pinOtpFormat" => $pinOtpFormat))
		->send();
		return $this->checkResponse($response);
	}

	public function addHardwareToken($userId = null, $userLogin = null, $type, $serialNumber, $name = null, $secret = null, $otp = null, $isExistedToken, $pin = null, $pinOtpFormat = null) {
		$response = $this->getClient(Http::POST)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "tokens/hardware." . $this->_response_format)
		->body(array("userId" => $userId, "userLogin" => $userLogin, "type" => $type, "serial" => $serialNumber,
					"name" => $name, "secret" => $secret, "otp" => $otp, "existed" => var_export($isExistedToken, true), 
					"pin" => $pin, "pinOtpFormat" => $pinOtpFormat))
		->send();
		return $this->checkResponse($response);
	}

	public function editToken($tokenId, $name, $enabled, $apiSupport) {
		$response = $this->getClient(Http::PUT)->sends(Mime::FORM)
		->uri($this->getServiceUri() . "tokens/" . $tokenId . "." . $this->_response_format)
		->body(array("name" => $name, "enabled" => var_export($enabled, true), "apiSupport" => var_export($apiSupport, true)))
		->send();
		return $this->checkResponse($response);
	}

	public function deleteToken($tokenId) {
		$response = $this->getClient(Http::DELETE)
		->uri($this->getServiceUri() . "tokens/" . $tokenId . "." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function getTokensQuantity() {
		$response = $this->getClient(Http::GET)->uri($this->getServiceUri() . "tokens/quantity." . $this->_response_format)->send();
		return $this->checkResponse($response);
	}

	public function unassignToken($tokenId) {
		$response = $this->getClient(Http::POST)
		->uri($this->getServiceUri() . "tokens/" . $tokenId . "/unassign." . $this->_response_format)
		->send();
		return $this->checkResponse($response);
	}

}