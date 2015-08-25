<?php

class ProtectimusApi {

	private $_username;
	private $_api_key;
	private $_api_url;
	private $_version;

	public function __construct($_username, $_api_key, $_api_url, $_version = "v1")
	{
		$this->_username = $_username;
		$this->_api_key = $_api_key;
		$this->_api_url = $_api_url;
		$this->_version = $_version;
	}

	/**
	 *
	 * Gets current balance of the client
	 *
	 * @return Current balance of the client
	 * @throws ProtectimusApiException
	 */
	public function getBalance()  {
		$auth_service_client = new AuthServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $auth_service_client->getBalance();
	}

	/**
	 *
	 * Prepares token for authentication. In case of use tokens with type such
	 * as SMS, MAIL or PROTECTIMUS_ULTRA this method must be called before
	 * authentication to send sms for SMS-token or send e-mail for MAIL-token or
	 * get challenge string for PROTECTIMUS_ULTRA-token.
	 *
	 * @param resourceId
	 * @param tokenId
	 * @return Challenge string for PROTECTIMUS_ULTRA-token or empty string for
	 *         SMS and MAIL tokens
	 * @throws ProtectimusApiException
	 */
	public function prepareAuthentication($resourceId, $tokenId = null, $userId = null, $userLogin = null) {
		$auth_service_client = new AuthServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $auth_service_client->prepare($resourceId, $tokenId, $userId, $userLogin);
	}

	/**
	 *
	 * Performs static environment check for user with id
	 * <code>userId</code> or login <code>userLogin</code>, which is assigned to
	 * resource with id <code>resourceId</code>.
	 *
	 * @param resourceId
	 * @param userId
	 * @param userLogin
	 * @param $jsonEnvironment
	 *            - user environment in JSON format (see documentation)
	 * @return match percent for current environment in users list.
	 * @throws ProtectimusApiException
	 */
	public function checkEnvironment($resourceId, $userId = null, $userLogin = null, $jsonEnvironment = null) {
		$auth_service_client = new AuthServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $auth_service_client->checkEnvironment($resourceId, $userId, $userLogin, $jsonEnvironment);
	}

	/**
	 *
	 * Performs static environment save for user with id
	 * <code>userId</code> or login <code>userLogin</code>
	 *
	 * @param userId
	 * @param userLogin
	 * @param $jsonEnvironment
	 *            - user environment in JSON format (see documentation)
	 * @return true if current environment was saved for user; false otherwise.
	 * @throws ProtectimusApiException
	 */
	public function saveEnvironment($userId = null, $userLogin = null, $jsonEnvironment = null) {
		$auth_service_client = new AuthServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $auth_service_client->saveEnvironment($userId, $userLogin, $jsonEnvironment);
	}

	/**
	 *
	 * Performs authentication for token with id <code>tokenId</code>, which is
	 * assigned to resource with id <code>resourceId</code>.
	 *
	 * @param resourceId
	 * @param tokenId
	 * @param otp
	 *            - one-time password from token
	 * @param ip
	 *            - IP-address of the end user. Must be specified to perform the
	 *            validation of geo-filter.
	 * @return true if authentication was successful; false otherwise.
	 * @throws ProtectimusApiException
	 */
	public function authenticateToken($resourceId, $tokenId, $otp, $ip = null) {
		$auth_service_client = new AuthServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $auth_service_client->authenticateToken($resourceId, $tokenId, $otp, $ip);
	}

	/**
	 *
	 * Performs static password authentication for user with id <code>userId</code> or
	 * login <code>userLogin</code>, which is assigned to resource with id
	 * <code>resourceId</code>.
	 *
	 * @param resourceId
	 * @param userId
	 * @param userLogin
	 * @param password
	 *            - password of the user
	 * @param ip
	 *            - IP-address of the end user. Must be specified to perform the
	 *            validation of geo-filter.
	 * @return true if authentication was successful; false otherwise.
	 * @throws ProtectimusApiException
	 */
	public function authenticateUserPassword($resourceId, $userId = null, $userLogin = null, $password, $ip = null) {
		$auth_service_client = new AuthServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $auth_service_client->authenticateUserPassword($resourceId, $userId, $userLogin, $password, $ip);
	}

	/**
	 *
	 * Performs one-time password authentication for user with id
	 * <code>userId</code> or login <code>userLogin</code>, which is assigned
	 * with token to resource with id <code>resourceId</code>.
	 *
	 * @param resourceId
	 * @param userId
	 * @param userLogin
	 * @param otp
	 *            - one-time password from token
	 * @param ip
	 *            - IP-address of the end user. Must be specified to perform the
	 *            validation of geo-filter.
	 * @return true if authentication was successful; false otherwise.
	 * @throws ProtectimusApiException
	 */
	public function authenticateUserToken($resourceId, $userId = null, $userLogin = null, $otp, $ip = null) {
		$auth_service_client = new AuthServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $auth_service_client->authenticateUserToken($resourceId, $userId, $userLogin, $otp, $ip);
	}

	/**
	 *
	 * Performs one-time password and static password authentication for user
	 * with id <code>userId</code> or login <code>userLogin</code>, which is
	 * assigned with token to resource with id <code>resourceId</code>.
	 *
	 * @param resourceId
	 * @param userId
	 * @param userLogin
	 * @param otp
	 *            - one-time password from token
	 * @param password
	 *            - password of the user
	 * @param ip
	 *            - IP-address of the end user. Must be specified to perform the
	 *            validation of geo-filter.
	 * @return true if authentication was successful; false otherwise.
	 * @throws ProtectimusApiException
	 */
	public function authenticateUserPasswordToken($resourceId, $userId = null, $userLogin = null, $otp, $password, $ip = null) {
		$auth_service_client = new AuthServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $auth_service_client->authenticateUserPasswordToken($resourceId, $userId, $userLogin, $otp, $password, $ip);
	}

	/**
	 *
	 * Gets a list of resources descending (10 records starting from <code>offset</code>)
	 *
	 * @param offset
	 * @param limit
	 * @return list of resources
	 * @throws ProtectimusApiException
	 */
	public function getResources($offset = 0, $limit = 10) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->getResources($offset, $limit);
	}

	/**
	 *
	 * Gets a resource by <code>resourceId</code>
	 *
	 * @param resourceId
	 * @return resource
	 * @throws ProtectimusApiException
	 */
	public function getResource($resourceId) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->getResource($resourceId);
	}

	/**
	 *
	 * Gets quantity of resources
	 *
	 * @return quantity of resources
	 * @throws ProtectimusApiException
	 */
	public function getResourcesQuantity() {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->getResourcesQuantity();
	}

	/**
	 *
	 * Adds a new resource
	 *
	 * @param resourceName
	 * @param failedAttemptsBeforeLock
	 * @return id of a new resource
	 * @throws ProtectimusApiException
	 */
	public function addResource($resourceName, $failedAttemptsBeforeLock) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->addResource($resourceName, $failedAttemptsBeforeLock);
	}

	/**
	 * Edits an existing resource with <code>resourceId</code>
	 *
	 * @param resourceId
	 * @param resourceName
	 * @param failedAttemptsBeforeLock
	 * @return edited resource
	 * @throws ProtectimusApiException
	 */
	public function editResource($resourceId, $resourceName, $failedAttemptsBeforeLock) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->editResource($resourceId, $resourceName, $failedAttemptsBeforeLock);
	}

	/**
	 *
	 * Deletes an existing resource with <code>resourceId</code>
	 *
	 * @param resourceId
	 * @return id of deleted resource
	 * @throws ProtectimusApiException
	 */
	public function deleteResource($resourceId) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->deleteResource($resourceId);
	}

	/**
	 *
	 * Assigns user with <code>userId</code> to resource with
	 * <code>resourceId</code>
	 *
	 * @param resourceId
	 * @param resourceName
	 * @param userId
	 * @param userLogin
	 * @throws ProtectimusApiException
	 */
	public function assignUserToResource($resourceId, $resourceName, $userId, $userLogin) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->assignUserToResource($resourceId, $resourceName, $userId, $userLogin);
	}

	/**
	 *
	 * Assigns token with <code>tokenId</code> to resource with
	 * <code>resourceId</code>
	 *
	 * @param resourceId
	 * @param resourceName
	 * @param tokenId
	 * @throws ProtectimusApiException
	 */
	public function assignTokenToResource($resourceId, $resourceName, $tokenId) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->assignTokenToResource($resourceId, $resourceName, $tokenId);
	}

	/**
	 *
	 * Assigns together user with <code>userId</code> and token with
	 * <code>tokenId</code> to resource with <code>resourceId</code>
	 *
	 * @param resourceId
	 * @param resourceName
	 * @param userId
	 * @param userLogin
	 * @param tokenId
	 * @throws ProtectimusApiException
	 */
	public function assignUserAndTokenToResource($resourceId, $resourceName, $userId, $userLogin, $tokenId) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->assignUserAndTokenToResource($resourceId, $resourceName, $userId, $userLogin, $tokenId);
	}

	/**
	 *
	 * Assigns together token with <code>tokenId</code> and user, which has
	 * given token, to resource with <code>resourceId</code>
	 *
	 * @param resourceId
	 * @param resourceName
	 * @param tokenId
	 * @throws ProtectimusApiException
	 */
	public function assignTokenWithUserToResource($resourceId, $resourceName, $tokenId) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->assignTokenWithUserToResource($resourceId, $resourceName, $tokenId);
	}

	/**
	 *
	 * Unassigns user with <code>userId</code> from resource with
	 * <code>resourceId</code>
	 *
	 * @param resourceId
	 * @param resourceName
	 * @param userId
	 * @param userLogin
	 * @throws ProtectimusApiException
	 */
	public function unassignUserFromResource($resourceId, $resourceName, $userId, $userLogin) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->unassignUserFromResource($resourceId, $resourceName, $userId, $userLogin);
	}

	/**
	 *
	 * Unassigns token with <code>tokenId</code> from resource with
	 * <code>resourceId</code>
	 *
	 * @param resourceId
	 * @param resourceName
	 * @param tokenId
	 * @throws ProtectimusApiException
	 */
	public function unassignTokenFromResource($resourceId, $resourceName, $tokenId) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->unassignTokenFromResource($resourceId, $resourceName, $tokenId);
	}

	/**
	 *
	 * Unassigns together user with <code>userId</code> and token with
	 * <code>tokenId</code> from resource with <code>resourceId</code>
	 *
	 * @param resourceId
	 * @param resourceName
	 * @param userId
	 * @param userLogin
	 * @param tokenId
	 * @throws ProtectimusApiException
	 */
	public function unassignUserAndTokenFromResource($resourceId, $resourceName, $userId, $userLogin, $tokenId) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->unassignUserAndTokenFromResource($resourceId, $resourceName, $userId, $userLogin, $tokenId);
	}

	/**
	 *
	 * Unassigns together token with <code>tokenId</code> and user, which has
	 * given token, from resource with <code>resourceId</code>
	 *
	 * @param resourceId
	 * @param resourceName
	 * @param tokenId
	 * @throws ProtectimusApiException
	 */
	public function unassignTokenWithUserFromResource($resourceId, $resourceName, $tokenId) {
		$resource_service_client = new ResourceServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $resource_service_client->unassignTokenWithUserFromResource($resourceId, $resourceName, $tokenId);
	}

	/**
	 *
	 * Gets secret key for Google Authenticator application
	 *
	 * @return secret key
	 * @throws ProtectimusApiException
	 */
	public function getGoogleAuthenticatorSecretKey() {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->getGoogleAuthenticatorSecretKey();
	}

	/**
	 *
	 * Gets secret key for ProtectimusMobile application
	 *
	 * @return secret key
	 * @throws ProtectimusApiException
	 */
	public function getProtectimusSmartSecretKey() {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->getProtectimusSmartSecretKey();
	}

	/**
	 *
	 * Gets a list of tokens descending (10 records starting from <code>offset</code>)
	 *
	 * @param offset
	 * @param limit
	 * @return list of tokens
	 * @throws ProtectimusApiException
	 */
	public function getTokens($offset = 0, $limit = 10) {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->getTokens($offset, $limit);
	}

	/**
	 *
	 * Gets a token by <code>tokenId</code>
	 *
	 * @param tokenId
	 * @return token
	 * @throws ProtectimusApiException
	 */
	public function getToken($tokenId) {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->getToken($tokenId);
	}

	/**
	 *
	 * Gets quantity of tokens
	 *
	 * @return quantity of tokens
	 * @throws ProtectimusApiException
	 */
	public function getTokensQuantity() {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->getTokensQuantity();
	}

	/**
	 *
	 * Adds unify token
	 * $unifyType: OATH_HOTP, OATH_TOTP, OATH_OCRA
	 * $unifyKeyAlgo: SHA1, SHA256, SHA512
	 * $unifyKeyFormat: HEX, BASE32, BASE64
	 * $pinOtpFormat: PIN_BEFORE_OTP, PIN_AFTER_OTP
	 *
	 * @param userId
	 *            - id of the user to whom the token will be assigned
	 * @param userLogin
	 *            - login of the user to whom the token will be assigned
	 * @param unifyType
	 *            - uniry token type
	 * @param unifyKeyAlgo
	 *            - token key algorythm
	 * @param unifyKeyFormat
	 *            - token key algorythm
	 * @param serialNumber
	 *            - token serial number
	 * @param name
	 *            - token name
	 * @param secret
	 *            - token secret key
	 * @param otp
	 *            - one-time password from token
	 * @param otpLength
	 *            - length of the one-time password (6 or 8 digits)
	 * @param pin
	 *            - pin-code (optional)
	 * @param pinOtpFormat
	 *            - usage of a pin-code with one-time password (adding pin-code
	 *            before or after one-time password)
	 * @param counter
	 *            - counter for token
	 * @param challenge
	 *            - challenge for token
	 * @return id of a new token
	 * @throws ProtectimusApiException
	 */
	public function addUnifyToken($userId = null, $userLogin = null, $unifyType, $unifyKeyAlgo, $unifyKeyFormat, $serialNumber = null, $name = null, $secret = null, $otp = null, $otpLength = null, $pin = null, $pinOtpFormat = null, $counter = null, $challenge = null) {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->addUnifyToken($userId, $userLogin, $unifyType, $unifyKeyAlgo, $unifyKeyFormat, $serialNumber, $name, $secret, $otp, $otpLength, $pin, $pinOtpFormat, $counter, $challenge);
	}

	/**
	 *
	 * Adds software token
	 * $type: GOOGLE_AUTHENTICATOR, SMS, MAIL, PROTECTIMUS_SMART
	 * $keyType: TOTP, HOTP
	 * $pinOtpFormat: PIN_BEFORE_OTP, PIN_AFTER_OTP
	 *
	 * @param userId
	 *            - id of the user to whom the token will be assigned
	 * @param userLogin
	 *            - login of the user to whom the token will be assigned
	 * @param type
	 *            - token type
	 * @param serialNumber
	 *            - token serial number
	 * @param name
	 *            - token name
	 * @param secret
	 *            - token secret key
	 * @param otp
	 *            - one-time password from token
	 * @param otpLength
	 *            - length of the one-time password (6 or 8 digits), parameter
	 *            is required for PROTECTIMUS_SMART token
	 * @param keyType
	 *            - type of key for PROTECTIMUS_SMART token, allowed values
	 *            "HOTP" (counter-based) or "TOTP" (time-based), parameter is
	 *            required for PROTECTIMUS_SMART token
	 * @param pin
	 *            - pin-code (optional)
	 * @param pinOtpFormat
	 *            - usage of a pin-code with one-time password (adding pin-code
	 *            before or after one-time password)
	 * @return id of a new token
	 * @throws ProtectimusApiException
	 */
	public function addSoftwareToken($userId = null, $userLogin = null, $type, $serialNumber = null, $name = null, $secret = null, $otp = null, $otpLength = null, $keyType = null, $pin = null, $pinOtpFormat = null) {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->addSoftwareToken($userId, $userLogin, $type, $serialNumber, $name, $secret, $otp, $otpLength, $keyType, $pin, $pinOtpFormat);
	}

	/**
	 *
	 * Adds hardware token
	 * $type: PROTECTIMUS, SAFENET_ETOKEN_PASS, PROTECTIMUS_ULTRA, YUBICO_OATH_MODE, PROTECTIMUS_SLIM
	 * $pinOtpFormat: PIN_BEFORE_OTP, PIN_AFTER_OTP
	 *
	 * @param userId
	 *            - id of the user to whom the token will be assigned
	 * @param userLogin
	 *            - login of the user to whom the token will be assigned
	 * @param type
	 *            - token type
	 * @param serialNumber
	 *            - token serial number
	 * @param name
	 *            - token name
	 * @param secret
	 *            - token secret key
	 * @param otp
	 *            - one-time password from token
	 * @param isExistedToken
	 *            - false indicates that you are adding your own token,
	 *            true indicates that you are adding token, which is provided by
	 *            Protectimus
	 * @param pin
	 *            - pin-code (optional)
	 * @param pinOtpFormat
	 *            - usage of a pin-code with one-time password (adding pin-code
	 *            before or after one-time password)
	 * @return id of a new token
	 * @throws ProtectimusApiException
	 */
	public function addHardwareToken($userId = null, $userLogin = null, $type, $serialNumber = null, $name = null, $secret = null, $otp = null, $isExistedToken, $pin = null, $pinOtpFormat = null) {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->addHardwareToken($userId, $userLogin, $type, $serialNumber, $name, $secret, $otp, $isExistedToken, $pin, $pinOtpFormat);
	}

	/**
	 *
	 * Edits an existing token with <code>tokenId</code>
	 *
	 * @param tokenId
	 * @param name
	 * @param enabled
	 * @param apiSupport
	 * @return edited token
	 * @throws ProtectimusApiException
	 */
	public function editToken($tokenId, $name, $enabled, $apiSupport) {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->editToken($tokenId, $name, $enabled,
		$apiSupport);
	}

	/**
	 *
	 * Deletes an existing token with <code>tokenId</code>
	 *
	 * @param tokenId
	 * @return id of deleted token
	 * @throws ProtectimusApiException
	 */
	public function deleteToken($tokenId) {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->deleteToken($tokenId);
	}

	/**
	 *
	 * Unassigns token with <code>tokenId</code> from user
	 *
	 * @param tokenId
	 * @throws ProtectimusApiException
	 */
	public function unassignToken($tokenId) {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->unassignToken($tokenId);
	}

	/**
	 *
	 * Gets a list of users descending (10 records starting from <code>offset</code>)
	 *
	 * @param offset
	 * @param limit
	 * @return list of users
	 * @throws ProtectimusApiException
	 */
	public function getUsers($offset = 0, $limit = 10) {
		$user_service_client = new UserServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $user_service_client->getUsers($offset, $limit);
	}

	/**
	 *
	 * Gets a user by <code>userId</code>
	 *
	 * @param userId
	 * @return user
	 * @throws ProtectimusApiException
	 */
	public function getUser($userId) {
		$user_service_client = new UserServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $user_service_client->getUser($userId);
	}

	/**
	 *
	 * Gets quantity of users
	 *
	 * @return quantity of users
	 * @throws ProtectimusApiException
	 */
	public function getUsersQuantity() {
		$user_service_client = new UserServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $user_service_client->getUsersQuantity();
	}

	/**
	 *
	 * Adds a new user
	 *
	 * @param login
	 * @param email
	 * @param phoneNumber
	 * @param password
	 * @param firstName
	 * @param secondName
	 * @param apiSupport
	 * @return id of a new user
	 * @throws ProtectimusApiException
	 */
	public function addUser($login, $email = null, $phoneNumber = null, $password = null, $firstName = null, $secondName = null, $apiSupport = true) {
		$user_service_client = new UserServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $user_service_client->addUser($login, $email, $phoneNumber, $password, $firstName, $secondName, $apiSupport);
	}

	/**
	 *
	 * Edits an existing user with <code>userId</code>
	 *
	 * @param userId
	 * @param login
	 * @param email
	 * @param phoneNumber
	 * @param password
	 * @param firstName
	 * @param secondName
	 * @param apiSupport
	 * @return edited user
	 * @throws ProtectimusApiException
	 */
	public function editUser($userId, $login = null, $email = null, $phoneNumber = null, $password = null, $firstName = null, $secondName = null, $apiSupport = true) {
		$user_service_client = new UserServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $user_service_client->editUser($userId, $login, $email, $phoneNumber, $password, $firstName, $secondName, $apiSupport);
	}

	/**
	 *
	 * Change raw users password with <code>userId</code>
	 *
	 * @param userId
	 * @param rawPassword
	 * @param rawSalt
	 * @param encodingType - PLAIN, MD5, SHA, SHA256
	 * @param encodingFormat
	 * @return edited user
	 * @throws ProtectimusApiException
	 */
	public function editUsersPassword($userId, $userLogin, $rawPassword, $rawSalt, $encodingType, $encodingFormat) {
		$user_service_client = new UserServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $user_service_client->editUsersPassword($userId, $userLogin, $rawPassword, $rawSalt, $encodingType, $encodingFormat);
	}

	/**
	 *
	 * Deletes an existing user with <code>userId</code>
	 *
	 * @param userId
	 * @return id of deleted user
	 * @throws ProtectimusApiException
	 */
	public function deleteUser($userId) {
		$user_service_client = new UserServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $user_service_client->deleteUser($userId);
	}

	/**
	 *
	 * Gets a list of user tokens descending by <code>userId</code> (10 records starting
	 * from <code>offset</code>)
	 *
	 * @param userId
	 * @param offset
	 * @param limit
	 * @return list of user tokens
	 * @throws ProtectimusApiException
	 */
	public function getUserTokens($userId, $offset = 0, $limit = 10) {
		$user_service_client = new UserServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $user_service_client->getUserTokens($userId, $offset, $limit);
	}

	/**
	 *
	 * Gets quantity of user tokens by <code>userId</code>
	 *
	 * @param userId
	 * @return quantity of users
	 * @throws ProtectimusApiException
	 */
	public function getUserTokensQuantity($userId) {
		$user_service_client = new UserServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $user_service_client->getUserTokensQuantity($userId);
	}

	/**
	 *
	 * Assigns token with <code>tokenId</code> to user with <code>userId</code>
	 *
	 * @param userId
	 * @param tokenId
	 * @throws ProtectimusApiException
	 */
	public function assignUserToken($userId, $tokenId) {
		$user_service_client = new UserServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $user_service_client->assignUserToken($userId, $tokenId);
	}

	/**
	 *
	 * Unassigns token with <code>tokenId</code> from user with
	 * <code>userId</code>
	 *
	 * @param userId
	 * @param tokenId
	 * @throws ProtectimusApiException
	 */
	public function unassignUserToken($userId, $tokenId) {
		$user_service_client = new UserServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $user_service_client->unassignUserToken($userId, $tokenId);
	}

	/**
	 * Allows to generate OTP, based on your transactions data to secure user against some type of injects. 
	 * More detailed about this feature you can read in our blog: https://www.protectimus.com/blog/detailed-information-on-data-signing/
	 * 
	 * @param tokenId – user’s token identifier;
	 * @param transactionData – transaction details to be used in ОТР generation;
	 * @param hash – НМАС-SHA256 hash of the transactionData string to verify the integrity of the data received; the user’s API key is used as the key.
	 */
	public function signTransaction($tokenId, $transactionData, $hash) {
		$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
		return $token_service_client->signTransaction($tokenId, $transactionData, $hash);
	}

	/**
	 * Allows to verify OTP, generated by above signTransaction method. For more detailed information visit our blog:
	 * https://www.protectimus.com/blog/detailed-information-on-data-signing/
	 * 
	 * @param tokenId – user’s token identifier;
	 * @param transactionData – details of the transaction being verified (it is important to send the details that will be sent to perform the transaction, not those received when performing the previous steps);
	 * @param hash – hash of the transactionData string generated in the same way as when calling the previous method;
	 * @param otp – one-time password provided by the user. 
	 * 
	 */
	public function verifySignedTransaction($tokenId, $transactionData, $hash, $otp) {
        	$token_service_client = new TokenServiceClient($this->_username, $this->_api_key, $this->_api_url, "json", $this->_version);
        	return $token_service_client->verifySignedTransaction($tokenId, $transactionData, $hash, $otp);
	}

}
