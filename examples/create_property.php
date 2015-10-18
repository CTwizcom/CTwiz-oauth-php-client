<?php
require('baseController.php');


class createPropertyController extends baseController{

    protected function doStuff($sessionStorage) {

        echo "Access token: " . $sessionStorage['access_token']['access_token'] . "<br>";
        echo "Refresh token: " . $sessionStorage['access_token']['refresh_token'] . "<br>";
        echo "Expires: " . $sessionStorage['access_token']['expires_in'] . "<br>";
        echo "Expires: " . $sessionStorage['access_token']['expires_at'] . "<br>";
        echo "Did expire: " . (time() > $sessionStorage['access_token']['expires_at'] ? 'expired' : 'not expired') . "<br>";

        // create new property
        $response = $this->client->fetch("me/property", array(

            "address" => "10 Moshe Aram st. Tel Aviv",
            'rooms' => 2,
            'houseType' => 2,
            'description' => '3123123213',
            'listingKind' => 'sale',
            'requiredPrice' => '1000000',
            'status' => 1,
            'bedrooms' => 2,
            'builtYear' => 1947,
            'privacy' => 1,
            'renovated' => true,
            'propertylevel' => 3,
            'totallevels' => 4,
            'parkingspace' => 2,
            'onColumns' => true,
            'elevator' => 1
        ), "POST");
        echo "Property " . $response['id'] . " was created<hr>";

        // upload image
        $response = $this->client->fetch('property/' . $response['id'] . "/photo/", array(
            "url" => "http://homedesigns.today/wp-content/uploads/Home-Interior-Idea-47.jpg",
            "caption" => 'test caption'
        ), "POST");

        echo "Photo " . $response['photoId'] . " was created<hr>";
        return false;
    }
}

session_start();

$controller = new createPropertyController();
$controller->dispatch($_GET,$_SESSION);