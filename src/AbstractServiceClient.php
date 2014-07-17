<?php

use Httpful\Request;
use Exception\ProtectimusApiException;

abstract class AbstractServiceClient {

	private $_username;
	private $_api_key;
	private $_api_url;
	private $_base_url;
	protected $_response_format;
	private $_version;

	public function __construct($_username, $_api_key, $_api_url, $_response_format, $_version) {
		if (empty($_username)) {
			throw new ProtectimusApiException(
					"Authentication is required. Please, specify username.", null, 5001);
		}
		$this->_username = $_username;
		if (empty($_api_key)) {
			throw new ProtectimusApiException(
					"Authentication is required. Please, specify password.", null, 5001);
		}
		$this->_api_key = $_api_key;
		$url_components = parse_url($_api_url);
		if (empty($url_components["scheme"]) || empty($url_components["host"])) {
			throw new ProtectimusApiException("Invalid API URL", "API URL = ["
			+ $_api_url + "] has invalid format", 6002);
		}
		$this->_base_url = $url_components["scheme"]
		. "://" . $url_components["host"] . (!empty($url_components["port"]) && $url_components["port"] != 80 && $url_components["port"] > 0 ? ":"
		. $url_components["port"] : "")
		. (!empty($url_components["path"]) && $this->endsWith($url_components["path"], "/") ? $url_components["path"] : $url_components["path"] . "/");
		$this->_version = $_version;
		$this->_response_format = $_response_format;
	}

	protected function getServiceUri() {
		return $this->_base_url . "api"
		. (!empty($this->_version) ? ("/" . $this->_version . "/"
		. $this->getServiceName() . "/") : ("/" . $this->getServiceName() . "/"));
	}

	protected abstract function getServiceName();

	protected function getClient($method) {
		return Request::init($method)->authenticateWith($this->_username, $this->getAuthenticationToken());
	}

	private function getAuthenticationToken() {
		$gmt = gmdate('Ymd:H');
		$token = hash("sha256", $this->_api_key . ':' . $gmt);
		return $token;
	}

	protected function checkResponse($response) {
		if ($response->code == 200) {
			if ($response->body->responseHolder->status == "OK") {
				return $response->body->responseHolder;
			} else if ($response->body->responseHolder->status == "FAILURE") {
				throw new ProtectimusApiException($response->body->responseHolder->error->message,
				isset($response->body->responseHolder->error->developerMessage) ?
				$response->body->responseHolder->error->developerMessage :
				"", $response->body->responseHolder->error->code);
			}
		} else {
			throw new ProtectimusApiException("HTTP Response Status Code: " . $response->code, $response->body, "9001", $response->code);
		}
	}

	private function endsWith($haystack, $needle, $case = true) {
		$expectedPosition = strlen($haystack) - strlen($needle);
		if ($case) {
			return strrpos($haystack, $needle, 0) === $expectedPosition;
		}
		return strripos($haystack, $needle, 0) === $expectedPosition;
	}

}