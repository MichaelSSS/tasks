<?php

class CurlHelper {
  protected $options;

  protected $isPost;
  protected $postFields;
  protected $requestCookies = [];

  protected $response;
  protected $info;
  protected $error;

  public function __construct($options = null) {
    $this->options = $options;
  }
  
  public function addCookie($cookie) {
    $this->requestCookies[] = $cookie;
  }
  
  public function setGet($params) {
    $this->isPost = false;
    if (is_array($params)) {
      $this->_url .= (strpos($this->_url, '?') === false ? '?' : '')
        . http_build_query($params);
    }
  }
  
  public function setPost($postFields) {
    $this->isPost = true;
    if (is_array($postFields)) {
      $this->postFields = http_build_query($postFields);
    }
  }

  public function exec($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    if (count($this->requestCookies)) {
      curl_setopt($ch, CURLOPT_COOKIE, implode(';', $this->requestCookies));
    }
    
    if ($this->isPost) {
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postFields);
    }

    $this->response = curl_exec($ch);

    $this->info = curl_getinfo($ch);
    $this->error = curl_error($ch);

    curl_close($ch);

    return $this->response;
  }

  public function getInfo($key) {
    return $this->info[$key];
  }
  public function getResponse() {
    return $this->response;
  }
  public function getError() {
    return $this->error;
  }
}
