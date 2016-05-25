<?php

class Cookies implements ArrayAccess {
  protected $cookies;

  public function __construct($headers) {
    preg_match_all('/Set-Cookie:\s*(?P<name>[^=]+)=(?P<value>[^;]+)/im', $headers, $cookies, PREG_SET_ORDER);
    $this->cookies = [];
    foreach($cookies as $cookie) {
      $this->cookies[$cookie['name']] = trim($cookie['value']);
    }
  }

  /**
   * ArrayAccess implementation
   */
  public function offsetSet($offset, $value) {
    return false;
  }
  public function offsetExists($offset) {
    return isset($this->cookies[$offset]);
  }
  public function offsetUnset($offset) {
    return false;
  }
  public function offsetGet($offset) {
    return isset($this->cookies[$offset]) ? $this->cookies[$offset] : null;
  }

  public function toString() {
    $result = '';
    foreach($this->cookies as $name => $value) {
      $result .= $name . '=' . $value . ';';
    }
    return substr($result, 0, -1);
  }
}
