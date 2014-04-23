<?php

namespace ZohoCRM;

/**
 * Simple cURL based HTTP Client.
 * Sends API calls to Zoho server.
 */
class HttpClient implements HttpClientInterface
{
  /**
   * cURL handle.
   */
  protected $curl;

  /**
   * cURL option CURLOPT_TIMEOUT.
   * The maximum number of seconds to allow cURL functions to execute.
   *
   * @var int
   */
  protected $timeout = 30;

  /**
   * cURL option CURLOPT_CONNECTTIMEOUT.
   * The number of seconds to wait while trying to connect.
   * Use 0 to wait indefinitely.
   *
   * @var int
   */
  protected $connectTimeout = 5;

  /**
   * Number of times cURL will try to connect.
   *
   * @var int
   */
  protected $retry = 1;

  /**
   * HTTP response code returned by cURL request.
   *
   * @var int
   */
  protected $httpCode;

  /**
   * List of all known HTTP response codes.
   *
   * @var array
   */
  protected static $messages = array(
    // Informational 1xx
    100 => 'Continue',
    101 => 'Switching Protocols',

    // Success 2xx
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',

    // Redirection 3xx
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',  // 1.1
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    // 306 is deprecated but reserved
    307 => 'Temporary Redirect',

    // Client Error 4xx
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',

    // Server Error 5xx
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    509 => 'Bandwidth Limit Exceeded'
  );

  public function __construct()
  {
    if (!function_exists('curl_init')) {
      throw new \Exception("cURL is not supported by server.");
    }
  }
  
  public function post($uri, $postBody)
  {
    $this->curl = curl_init();
    $this->setOptions($uri, $postBody);

    $count = 0;
    $response = false;
    while ($response === false && $count < $this->retry) {
      $response = curl_exec($this->curl);
      $count++;
    }

    if ($response === false) {
      throw new \RuntimeException(curl_error($this->curl), curl_errno($this->curl));
    }

    $this->httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

    curl_close($this->curl);

    if ($this->httpCode !== 200) {
      throw new ZohoCRMException("HTTP Response: $this->httpCode " . self::$messages[$this->httpCode]);
    }

    return $response;
  }

  public function setTimeout($timeout)
  {
    if (is_numeric($timeout)) {
      $this->timeout = intval($timeout);
    }
  }

  public function getTimeout()
  {
    return $this->timeout;
  }

  public function setConnectTimeout($connectTimeout)
  {
    if (is_numeric($connectTimeout)) {
      $this->connectTimeout = intval($connectTimeout);
    }
  }

  public function getConnectTimeout()
  {
    return $this->connectTimeout;
  }

  public function setRetry($retry)
  {
    if (is_numeric($retry)) {
      $this->retry = intval($retry);
    }
  }

  public function getRetry()
  {
    return $this->retry;
  }

  public function getHttpCode()
  {
    return $this->httpCode;
  }

  protected function setOptions($uri, $postBody)
  {
    curl_setopt($this->curl, CURLOPT_URL, $uri);

    curl_setopt($this->curl, CURLOPT_POST, 1);
    curl_setopt($this->curl, CURLOPT_POSTFIELDS, $postBody);

    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);

    //curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
    //curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, FALSE);
  }

}
