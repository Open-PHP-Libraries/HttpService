<?php
require __DIR__ . '/../../vendor/autoload.php';

use OpenPHPLibraries\Http\Client;

$example = [];

$client = new Client('https://reqres.in/api/');
$client
    ->addHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'); // <-- Some API's require a user agent, you can set it like this, we got it from https://developers.whatismybrowser.com/useragents/explore/
/**
 * Example 1. Sending a basic GET request
 */

$request = $client->get('users', ['page' => 2]);
$example['Example_1'] = $request->decode()->asArray();
$example['Example_1_Headers'] = $request->headers;


header("Content-Type: application/json");
echo json_encode($example);