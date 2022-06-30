<?php
class SmsAPI
{

  private $parameters = [];
  private $output = "";
  public function __construct($apiKey, $sender = 'Semaphore')
  {
    $this->parameters['apikey'] = $apiKey;
    $this->parameters['sendername'] = $sender;
  }

  public function send($number, $message)
  {
    $this->parameters['number'] = $number;
    $this->parameters['message'] = $message;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->parameters));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $this->output = $output;
    curl_close($ch);

    //Show the server response
    echo $output . "\n";
  }

  public function getOutput(){
    return $this->output;
  }
}
