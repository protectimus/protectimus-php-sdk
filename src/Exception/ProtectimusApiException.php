<?php

namespace Exception;

class ProtectimusApiException extends \Exception {

	public $developerMessage;
	public $errorCode;
	public $httpResponseStatusCode;
	private $errorCodeArray = array("1001" => "ALREADY_EXIST", "2001" => "INVALID_PARAMETER_LENGTH",
		"3001" => "DB_ERROR", "4001" => "UNREGISTERED_NAME", "5001" => "MISSING_PARAMETER", 
		"5002" => "MISSING_DB_ENTITY", "6001" => "INVALID_PARAMETER", "6002" => "INVALID_URL_PATTERN", 
		"7001" => "ACCESS_RESTRICTION", "8001" => "INTERNAL_SERVER_ERROR", "9001" => "UNKNOWN_ERROR");

	public function __construct($message, $developerMessage, $code = "9001", $httpResponseStatusCode = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
		$this->developerMessage = $developerMessage;
		$this->errorCode = $this->errorCodeArray[$code];
		$this->httpResponseStatusCode = $httpResponseStatusCode;
	}

}