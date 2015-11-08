<?php 
require __DIR__ . '/vendor/autoload.php';
const DEFAULT_URL = 'https://glaring-torch-9680.firebaseio.com/';
const DEFAULT_TOKEN = 'msshWRjmFNngCOZKraGu6ax4NKmblRZOZbLfNDN6';
const DEFAULT_PATH = '/example';

$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);

// --- storing an array ---
$test = array(
    "foo" => "bar",
    "i_love" => "lamp",
    "id" => 42
);
$dateTime = new DateTime();
$firebase->set(DEFAULT_PATH . '/' . $dateTime->format('c'), $test);

// --- storing a string ---
$firebase->set(DEFAULT_PATH . '/name/contact001', "John Doe");

// --- reading the stored string ---
$name = $firebase->get(DEFAULT_PATH . '/name/contact001');
echo 'test';
 ?>