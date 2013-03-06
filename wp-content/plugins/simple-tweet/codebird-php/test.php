<?php
$consumer = '0ckhWwE8MAQzM2IjRH3seg';
$consumer_secret = 'G642Iu5fPoCSruaUlhsXcHZLkuv4N41ai9jKRbRc';
require_once ('codebird.php');
Codebird::setConsumerKey($consumer,$consumer_secret);
$cb = Codebird::getInstance();
//$cb = new Codebird;
//$cb->setConsumerKey($consumer,$consumer_secret);

$reply = $cb->oauth_requestToken(array(
        'oauth_callback' => 'http://shot.dogmap.jp/'
));
var_dump($reply);
var_dump($cb);

