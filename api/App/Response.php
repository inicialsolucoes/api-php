<?php

/**
 * @see Settings
 */
require_once 'Settings.php';

/**
 * Response
 */
class Response
{
	/**
	 * @var array
	 */
	private $__data;

	/**
	 * @var boolean
	 */
	private $__status;

	/**
	 * @var int
	 */
	private $__code;

	/**
	 * @var string
	 */
	private $__message;

	/**
	 * @param mixed   $data
	 * @param boolean $status
	 * @return Api\Response
	 */
	public function __construct($data = null, $status = true, $code = 200, $message = null)
	{
		$this->setData   ($data);
		$this->setMessage($message);
		$this->setStatus ($status);
		$this->setCode   ($code);

		return $this;
	}

	/**
	 * @param mixed $data
	 * @return Api\Response
	 */
	public function setData($data)
	{
		$this->__data = (array) $data;

		return $this;
	}

	/**
	 * @param bool $status
	 * @return Api\Response
	 */
	public function setStatus($status)
	{
		$this->__status = (bool) $status;

		return $this;
	}

	/**
	 * @param int $code
	 * @return Api\Response
	 */
	public function setCode($code)
	{
		$this->__code = (int) $code;

		switch ($code) {
            case 100: $message = 'Continue'; break;
            case 101: $message = 'Switching Protocols'; break;
            case 200: $message = 'OK'; break;
            case 201: $message = 'Created'; break;
            case 202: $message = 'Accepted'; break;
            case 203: $message = 'Non-Authoritative Information'; break;
            case 204: $message = 'No Content'; break;
            case 205: $message = 'Reset Content'; break;
            case 206: $message = 'Partial Content'; break;
            case 300: $message = 'Multiple Choices'; break;
            case 301: $message = 'Moved Permanently'; break;
            case 302: $message = 'Moved Temporarily'; break;
            case 303: $message = 'See Other'; break;
            case 304: $message = 'Not Modified'; break;
            case 305: $message = 'Use Proxy'; break;
            case 400: $message = 'Bad Request'; break;
            case 401: $message = 'Unauthorized'; break;
            case 402: $message = 'Payment Required'; break;
            case 403: $message = 'Forbidden'; break;
            case 404: $message = 'Not Found'; break;
            case 405: $message = 'Method Not Allowed'; break;
            case 406: $message = 'Not Acceptable'; break;
            case 407: $message = 'Proxy Authentication Required'; break;
            case 408: $message = 'Request Time-out'; break;
            case 409: $message = 'Conflict'; break;
            case 410: $message = 'Gone'; break;
            case 411: $message = 'Length Required'; break;
            case 412: $message = 'Precondition Failed'; break;
            case 413: $message = 'Request Entity Too Large'; break;
            case 414: $message = 'Request-URI Too Large'; break;
            case 415: $message = 'Unsupported Media Type'; break;
            case 500: $message = 'Internal Server Error'; break;
            case 501: $message = 'Not Implemented'; break;
            case 502: $message = 'Bad Gateway'; break;
            case 503: $message = 'Service Unavailable'; break;
            case 504: $message = 'Gateway Time-out'; break;
            case 505: $message = 'HTTP Version not supported'; break;
            default:
                $message = 'Unknown http status code "' . htmlentities($code) . '"';
            break;
        }

        if (empty($this->__message)) {
        	$this->__message = $message;
        }

		return $this;
	}

	/**
	 * @param string $message
	 * @return Api\Response
	 */
	public function setMessage($message)
	{
		$this->__message = (string) $message;

		return $this;
	}

	/**
	 * @param string $name
	 * @param string $value
	 */
	public function setHeader($name, $value)
	{
		header("{$name}:{$value}");
	}

	/**
	 * Output JSON
	 * @return void
	 */
	public function json()
	{
		$this->setHeader('Access-Control-Allow-Origin', Settings::ALLOW_ORIGIN);
		$this->setHeader('Content-Type', 'application/json');

		print json_encode(array(
			'data'    => $this->__data,
			'status'  => array (
				'success' => $this->__status,
				'code'	  => $this->__code,
				'message' => $this->__message,
			)
		));

		exit();
	}
}