<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
const DEFAULT_URL = 'https://glaring-torch-9680.firebaseio.com/';
const DEFAULT_TOKEN = 'msshWRjmFNngCOZKraGu6ax4NKmblRZOZbLfNDN6';
const DEFAULT_PATH = '/live';

$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
?>