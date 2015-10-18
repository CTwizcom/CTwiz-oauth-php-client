<?php
require('baseController.php');


class userDetailsController extends baseController {


    protected function doStuff($sessionStorage) {

        echo "Access token: " . $sessionStorage['access_token']['access_token'] . "<br>";
        echo "Refresh token: " . $sessionStorage['access_token']['refresh_token'] . "<br>";
        echo "Expires: " . $sessionStorage['access_token']['expires_in'] . "<br>";
        echo "Expires: " . $sessionStorage['access_token']['expires_at'] . "<br>";
        echo "Did expire: " . (time() > $sessionStorage['access_token']['expires_at'] ? 'expired' : 'not expired') . "<br>";

        $resourceOwner = $this->client->fetch('me/');

        echo "Got user details " . $resourceOwner['accountId'] . ' ' . $resourceOwner['name']['fullName'];
        echo "<hr>";
    }
}

session_start();

$controller = new userDetailsController();
$controller->dispatch($_GET,$_SESSION);
