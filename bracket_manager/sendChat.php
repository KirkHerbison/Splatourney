<?php
require_once('../model/database.php');
require_once('../model/bracket_db.php');
require_once('../model/Chat.php');
require_once('../model/User.php');
require_once('../model/user_db.php');
require_once('../model/Chat_Message.php');
session_start();
//var_dump($_POST);
//error_log(print_r($_POST, true));

$matchId = filter_input(INPUT_POST, 'matchId', FILTER_SANITIZE_NUMBER_INT);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);



//API call to Bad Word Filter by Rapid APT
$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://neutrinoapi-bad-word-filter.p.rapidapi.com/bad-word-filter",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "content=" . urlencode($message) . "&censor-character=*",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: neutrinoapi-bad-word-filter.p.rapidapi.com",
		"X-RapidAPI-Key: ec32d365cbmshcd4644180137d07p1274e0jsn73302fc69052",
		"content-type: application/x-www-form-urlencoded"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
}
else{
    $json = json_decode($response);
    $censoredContent = $json->{"censored-content"};
}




////////////////////////////////////////////////////////////////////////////////
//gets user for session for use or creates an empty user object so the code does not break
if (isset($_SESSION['userLogedin'])) {
    $userLogedin = $_SESSION['userLogedin'];
} else {
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', '', false, false);
}


if($matchId != null) {
  $chat = get_chat_by_match_id($matchId);
  $messageToSend = new Chat_Message(null, $chat->getId(), $userLogedin->getId(), $censoredContent, null);
  insert_message_by_chat_id($messageToSend);
  $messages = get_messages_by_chat_id($chat->getId());
  
  $newMessages = array(
      
  );
  
  foreach($messages as $message){
      
      $message_array = array("id" => $message->getId(), "chatId" => $message->getChatId(), 
          "userId" => $message->getUserId(), "message" => $message->getMessage(), 
          "dateSent" => date("H:i:s", strtotime($message->getDateSent())), "username" => get_user_by_id($message->getUserId())->getUsername());
      $newMessages[] = $message_array;
  }

  echo  json_encode(['success' => true, 'messages' => $newMessages ]);
  
}

?>
