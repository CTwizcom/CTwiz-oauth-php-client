<?php
require('baseController.php');


class searchPropertiesController extends baseController{


    protected function doStuff($sessionStorage) {

        echo "Access token: " . $sessionStorage['access_token']['access_token'] . "<br>";
        echo "Refresh token: " . $sessionStorage['access_token']['refresh_token'] . "<br>";
        echo "Expires: " . $sessionStorage['access_token']['expires_in'] . "<br>";
        echo "Expires: " . $sessionStorage['access_token']['expires_at'] . "<br>";
        echo "Did expire: " . (time() > $sessionStorage['access_token']['expires_at'] ? 'expired' : 'not expired') . "<br>";

        $properties = $this->client->fetch("property");

        echo "Got " . sizeof($properties) . " properties<br>";
        return false;
    }
}

session_start();

$controller = new searchPropertiesController();
$controller->dispatch($_GET,$_SESSION);