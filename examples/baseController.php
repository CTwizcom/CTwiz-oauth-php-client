<?php
require('../src/CTwiz/Client.php');


class baseController
{

    /** @var string API key retrieved from CTwiz */
    static $apiKey = "1";

    static $apiSecret = "XXXXXXX";

    protected $client;

    public function dispatch($get, $sessionStorage)
    {

        $this->init();

        // got back an error message
        if (isset($get['error'])) {
            return $this->displayError($get['message']);
        } // have an access token
        elseif (isset($sessionStorage['access_token'])) {

            // check if access token is expired
            if ((time() > $sessionStorage['access_token']['expires_at'])) {

                // refresh access token
                $this->refreshAccessToken($sessionStorage);
            }

            $this->doStuff($sessionStorage);
        } // got code back
        elseif (isset($get['code'])) {
            $this->getAccessToken($get['code'], $sessionStorage);

            $this->doStuff($sessionStorage);
        } // we need to fetch a code
        else {
            $auth_url = $this->client->getAuthenticationUrl('email,messages,properties_write,properties_read');
            header('Location: ' . $auth_url);
            return true;;
        }
    }

    protected function doStuff($sessionStorage)
    {
        throw new Exception("doStuff must be implemented with some functionality to demonstrate  API calls");
    }

    protected function init()
    {
        $url =  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

        $this->client = new CTwiz\Oauth\Client(self::$apiKey, self::$apiSecret, $escaped_url);
    }

    protected function refreshAccessToken($sessionStorage)
    {
        // refresh the access token
        $response = $this->client->refreshAccessToken($sessionStorage['access_token']['refresh_token']);

        // something went wrong
        if (empty($response['access_token'])) {
            return $this->displayError("couldn't refresh a valid access token" . $response['result']['result']);
        }

        // save new access token in session
        $sessionStorage['access_token'] = $response;
        $sessionStorage['access_token']['expires_at'] = time() + $sessionStorage['access_token']['expires_in'];
        $this->client->setAccessToken($sessionStorage['access_token']);
        return true;
    }

    protected function getAccessToken($code, $sessionStorage)
    {
        // replace code with access token
        $response = $this->client->getAccessToken($code);

        // something went wrong
        if (empty($response['access_token'])) {
            return $this->displayError("couldn't retrieve a valid access token" . $response['result']['result']);
        }
        $sessionStorage['access_token'] = $response;
        $sessionStorage['access_token']['expires_at'] = time() + $sessionStorage['access_token']['expires_in'];
        $this->client->setAccessToken($sessionStorage['access_token']);
        return true;
    }

    protected function displayError($errorMessage = "")
    {
        echo $errorMessage;
        return true;
    }
}