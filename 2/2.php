<?php

$opt = getopt('h', array('username:', 'password:', 'email:'));

$username = isset($opt['username']) ? $opt['username'] : 'admin';
$password = isset($opt['password']) ? $opt['password'] : '123';
$email = isset($opt['email']) ? filter_var($opt['email'], FILTER_VALIDATE_EMAIL) : false;

require_once "class_browser.php";

$browser = new browser("http://home.local/");

$browser->go("/recr.php");

$browser->go("/recr.php?formsubmit", array("username" => $username, "password" => $password, "chk" => $browser->cookie['chk']));

$r = $browser->regexp('~name=line_id\[\] value=\'([0-9]+)\'~Usi');
$r = $r[1];

if ($email) {
  mail($email, 'Result', print_r($r, true));
}
print_r($r);
