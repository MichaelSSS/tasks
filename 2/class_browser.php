<?php

require 'class_CurlHelper.php';
require 'class_Cookies.php';

class  browser {
  protected $baseUrl;

  protected $response;

  public $cookie;

  public function __construct($baseUrl) {
    $this->baseUrl = rtrim($baseUrl, '/') . '/';
  }

  public function go($url, $params = null) {
    $curl = new CurlHelper();
    
    if (is_array($params) && count($params)) {

      $curl->setPost($params);
    }

    if ($this->cookie instanceof Cookies) {
      $curl->addCookie($this->cookie->toString());
    }

    $url = ltrim($url, '/');
    
    $this->response = $curl->exec($this->baseUrl . $url);

    $this->cookie = new Cookies(substr($curl->getResponse(), 0, $curl->getInfo('header_size')));

    return $this->response;
  }

  public function regexp($regexp) {
    preg_match_all($regexp, $this->response, $matches);

    return $matches;
  }
}
