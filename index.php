<?php 
require_once 'model/User.php';
session_start();

if(isset($_SESSION['userLogedin'])){  
    $userLogedin = $_SESSION['userLogedin'];
}
else{
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', '', false, false);
}

require_once 'view/header.php';

?>

 <h1>Welcome To Splatourney</h1><br>
 <p>This website is under construction</p>

<?php require_once 'view/footer.php'; ?>