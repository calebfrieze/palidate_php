# palidate-php
A PHP library to test your PayPal REST Integration.

Install the module and use the starting code below.

``` bash
composer require palidate
```

```php

$options = [
  'env' => 'live', 
  'clientId' => 'Your Client Id', 
  'clientSecret' => 'Your Client Secret'
];

$palidate = new Palidate\Palidate($options);
echo '<pre>';
print_r($palidate->palidate());

```

The code above tests your credentials and will return an array with a status key that is either "pass" or "fail".
If your credentials "pass" then you will receive your access token back in your result to make your PayPal API calls.
Great to test out your PayPal Rest credentials, or use the resulting access token to further develop.

This library is NOT officially linked to or apart of PayPal.com and is not directly supported by PayPal.
