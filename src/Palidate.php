<?php

namespace Palidate\Palidate;

class Palidate
{
  
  private $clientId;
  private $clientSecret;
  private $env;
  private $access_token;
  private $scope;
  private $token_type;
  private $expires_in;
  private $error;
  
  public function __construct($options)
  {
    if(is_array($options)){
      switch ($options['env']){
        case 'live':
          $this->env = "https://api.paypal.com/v1/oauth2/token";
          break;
        case 'sandbox':
          $this->env = "https://api.sandbox.paypal.com/v1/oauth2/token";
          break;
        default:
          $this->error = "ERROR: First option must be either Live or Sandbox";
      }
      $this->clientId = $options['clientId'];
      $this->clientSecret = $options['clientSecret'];
    } else {
      $this->error = "ERROR: Input must be an array";
    }
    $endpoint = "https://api.sandbox.paypal.com/v1/oauth2/token";
    $data = 'grant_type=client_credentials';
    $credentials = base64_encode($this->clientId . ":" . $this->clientSecret);
    $headers = ["Accept: application/json", "Accept-Language: en_US", "Authorization:" . "Basic " . $credentials];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, 0);       // tells curl to include headers in response
    curl_setopt($ch, CURLOPT_TIMEOUT, 90);       // times out after 90 secs
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, TRUE);    //forces closure of connection when done
    $httpResponse = curl_exec($ch);
    $res = json_decode($httpResponse, true);
    if(isset($res['access_token'])){
      $this->scope = $res['scope'];
      $this->access_token = $res['access_token'];
      $this->token_type = $res['token_type'];
      $this->expires_in = $res['expires_in'];
    } else {
      $this->error = $res['error_description'];
    }
  }
  
  public function encrypt()
  {
    return base64_encode($this->clientId . ":" . $this->clientSecret);
  }
  
  public function palidate()
  {
    if(isset($this->error)){
      $resArray = [
        'status' => 'fail',
        'error' => $this->error
      ];
      return $resArray;
    } else {
      $resArray = [
        'status' => 'pass',
        'access_token' => $this->access_token
      ];
      return $resArray;
    }
  }
  public function getScope($array = false)
  {
    if(isset($this->error)){
      return $this->error;
    } else {
      if($array == true){
        $exploded = explode(' ', $this->scope);
        return $exploded;
      } else {
        return $this->scope;
      }
    }
  }
  public function getTokenType()
  {
    if(isset($this->error)){
      return $this->error;
    } else {
      return $this->token_type;
    }
  }
  public function getExpireTime($format = false)
  {
    if(isset($this->error)){
      return $this->error;
    } else {
      if($format != false){
        return gmdate($format, $this->expires_in);
      } else {
        return $this->expires_in;
      }
    }
  }
  
}

// 
// // get response from Payflow 
// $httpResponse = curl_exec($ch); 
// 
// echo "Output: " . $httpResponse;
// echo "<br /><br />";

?>