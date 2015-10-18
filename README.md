CTwiz-oauth-php-client
============================


Usage instructions
------------------
The OAuth flow is a little complex so we have created a set of controllers in the examples folder.
While all of the examples have the same authentication flow, each shows a different use case on using CTwiz's API.

Here's a basic example:

```php
<?php

require('/src/CTwiz/Client.php');

$client = new CTwiz\Oauth\Client(apiKey, apiSecret, return_url);

if (!isset($_GET['code'])) {
    $auth_url = $client->getAuthenticationUrl('email,messages,properties_write,properties_read');
    header('Location: ' . $auth_url);
    return true;;

}
else {
    // the access token should be saved for future API requests
    $response = $client->getAccessToken($_GET['code']);
    $client->setAccessToken($response);
    $resourceOwner = $client->fetch('me/');
}
```

Contact
----------------

CTwiz support
    - support@ctwiz.com


Documentation & Download
------------------------

Latest version is available on github at :
    - https://github.com/CTwizcom/CTwiz-oauth-php-client

Documentation can be found on :
    - http://ctwiz.com


License
-------

This Code is released under the GNU LGPL

Please do not change the header of the file(s).

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published
by the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This library is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
or FITNESS FOR A PARTICULAR PURPOSE.

See the GNU Lesser General Public License for more details.

This library is a modified version of the oAuth wrapper
    - https://github.com/evert/oauth2
