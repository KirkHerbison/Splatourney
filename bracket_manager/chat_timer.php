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


////////////////////////////////////////////////////////////////////////////////
//gets user for session for use or creates an empty user object so the code does not break
if (isset($_SESSION['userLogedin'])) {
    $userLogedin = $_SESSION['userLogedin'];
} else {
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', '', false, false);
}


if($matchId != null) {
  $chat = get_chat_by_match_id($matchId);
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