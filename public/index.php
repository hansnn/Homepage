<?php

main();
function main() 
{
  if (isset($_GET['lang']) && $_GET['lang'] == 'en') {
    $lang = 'en';
  } else {
    $lang = 'no';
  }

  $json = getJson($lang);


  $form = parse_post($json);

  require('cvLayout.php');
}

function getJson($lang) 
{
  if ($lang === 'en') {
    $filename = 'cvEN.json';
  } else {
    $filename = 'cvNO.json';
  }
  $json_string = file_get_contents($filename);
  $json = json_decode($json_string, TRUE);
  return $json;
}

function save_form($name, $email, $message) 
{
  $from = 'CVen din';
  $to ='martinmoeh@gmail.com';
  $body = sprintf("Senders navn: %s\nSenders epost: %s\n Melding:\n %s",
    $name, $email, $message);

  $f = fopen('/mnt/cvkontakt/'.$name.date('Y-m-d_H-i-s').'.txt', 'w');
  fwrite($f, $body);
  fclose($f);
}

function parse_post($json) 
{
  $parsedArray = [];
  $formSuccess = true; // Form is successfully parsed until proven otherwise

  foreach($_POST as $key => $value) {
    // If form is submitted
    if ($key == 'submit') {
      echo "<p id='form-submitted' style='display:none'></p>";
    } 
    else {
      if ($value == '' && isset($_POST['submit'])) {
        $formSuccess = false;
        $errorMsg = isset($json['error'][$key]) ? $json['error'][$key] : '';
      }
      else {
        $errorMsg = '';
      }
      $parsedArray[$key] = htmlspecialchars($value);
      $parsedArray[$key.'Err'] = $errorMsg;
    }
  }
  return $parsedArray;
}
