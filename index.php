<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  main();

  function getJson($lang) {
    if ($lang === 'en') {
      $filename = 'cvEN.json';
    } else {
      $filename = 'cvNO.json';
    }
    $json_string = file_get_contents($filename);
    $json = json_decode($json_string, TRUE);
    return $json;
  }

  function main() {

    if (isset($_GET['lang']) && $_GET['lang'] == 'en') {
      $lang = 'en';
    } else {
      $lang = 'no';
    }

    $json = getJson($lang);

    $form = parse_post($json);

    require('cv.php');
  }

  function save_form($name, $email, $message) {
    $from = 'CVen din';
    $to ='martinmoeh@gmail.com';
    $body = "Senders navn: $name\n Senders epost: $email\n Melding:\n $message";

    $f = fopen('/mnt/cvkontakt/' . $name . date('Y-m-d_H-i-s') . '.txt', 'w');
    fwrite($f, $body);
    fclose($f);
  }

  function parse_post($json) {
    if (isset($_POST['submit'])) {
      echo "<p id='form-submitted' style='display:none'></p>";

      if ($_POST['name'] != '') {
        $name = htmlspecialchars($_POST['name']);
        $errName = '';
      } else {
        $name = '';
        $errName = $json['error']['name'];
      }

      if ($_POST['email'] != '') {
        $email = htmlspecialchars($_POST['email']);
        $errEmail = '';
      } else {
        $email = '';
        $errEmail = $json['error']['email'] ?: '';
      }

      if ($_POST['message'] != '') {
        $message = htmlspecialchars($_POST['message']);
        $errMessage = '';
      } else {
        $message = '';
        $errMessage = $json['error']['email'] ?: '';
      }
      echo $message;
      if ( !($errName || $errEmail || $errMessage) ) {
        $result = $json['thanks'];
        save_form($name, $email, $message);
      }
    }
    else {
      $name = '';
      $email = '';
      $message = '';
      $errName = '';
      $errEmail = '';
      $errMessage = '';
      $result = isset($result) ? $result : '';
    }

    return array('name' => $name,
                 'email' => $email,
                 'message' => $message,
                 'errName' => $errName,
                 'errEmail' => $errEmail,
                 'errMessage' => $errMessage,
                 'result' => $result);
  }
?>
