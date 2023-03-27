<?php
require_once('../model/database.php');
require_once('../model/bracket_db.php');
require_once('../model/Chat.php');
require_once('../model/Chat_Message.php');
session_start();
//var_dump($_POST);
//error_log(print_r($_POST, true));

$matchId = filter_input(INPUT_POST, 'matchId', FILTER_SANITIZE_NUMBER_INT);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);


////////////////////////////////////////////////////////////////////////////////
//gets user for session for use or creates an empty user object so the code does not break
if (isset($_SESSION['userLogedin'])) {
    $userLogedin = $_SESSION['userLogedin'];
} else {
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', '', false, false);
}


if($matchId != null) {
  $chat = get_chat_by_match_id($matchId);
  $messageToSend = new Chat_Message(null, $chat->getId(), $userLogedin->getId(), $message, null);
  insert_message_by_chat_id($messageToSend);
  $messages = get_messages_by_chat_id($chat->getId());
  
  echo  json_encode(['success' => true, 'messages' => $messages ]);

}

?>
