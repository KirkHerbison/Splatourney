<?php
require_once 'model/User.php';

if (isset($_SESSION['userLogedin'])) {
    $userLogedin = $_SESSION['userLogedin'];
} else {
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', '', false, false);
}

require_once 'view/header.php';
?>

<div class="bracketContainer">

<link rel="stylesheet" type="text/css" href="styles/single_elimination_bracket.css">


<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script> <!-- for jquery bracket -->
<script type="text/javascript" src="js/jquery.bracket.min.js"></script> <!-- for jquery bracket -->
<link rel="stylesheet" type="text/css" href="styles/jquery.bracket.min.css" /> <!-- for jquery bracket -->


<div id="minimal">
  <h3>Minimal</h3>
  <Div class="demo"></Div>
  
  <script type="text/javascript">
$(function() {
  var minimalData = <?php echo $bracketData; ?>;
  $('#minimal .demo').bracket({
    skipConsolationRound: true,
    init: minimalData,
    onMatchClick: function(data) {
      console.log(data);
    }
  });

});
  </script>
</div>



<!--  READ UP ON THIS PAGE, I NEED TO CHANGE TO A DIFFERENT BRACKET, THIS ALSO SUPPORTS DOUBLE ELIM slightly less appealing initially http://www.aropupu.fi/bracket/ -->

</div>

<?php require_once 'view/footer.php'; ?>
