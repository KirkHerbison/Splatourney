<?php
require_once '../model/User.php';

if (isset($_SESSION['userLogedin'])) {
    $userLogedin = $_SESSION['userLogedin'];
} else {
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', '', false, false);
}

require_once '../view/header.php';
?>
<link rel="stylesheet" type="text/css" href="styles/single_elimination_bracket.css">
<h3><?php echo $bracket->getTournamentBracketName();?></h3>
<div id="container">
<div class="bracketContainer">
    <div class="resize-handle resize-handle-bottom-right"></div>




    <script type="text/javascript" src="js/jquery.bracket.min.js"></script> <!-- for jquery bracket -->
    <link rel="stylesheet" type="text/css" href="styles/jquery.bracket.min.css" /> <!-- for jquery bracket -->
    <input type="hidden" id="tournament-id" value="<?php echo $tournament_id; ?> ">
    <input type="hidden" id="bracketId" value="<?php echo $bracket->getId(); ?> ">

    
    <div id="minimal">
        
        <Div class="demo"></Div>

        
        <script type="text/javascript">
            $(function () {
                var minimalData = <?php echo $bracketData; ?>;
                
                //jquery bracket 
                $('#minimal .demo').bracket({
                    skipConsolationRound: true,
                    teamWidth: 150,
                    scoreWidth: 40,
                    matchMargin: 41,
                    roundMargin: 55,
                    init: minimalData,
                    onMatchClick: function (data) {
                        const divs = document.querySelectorAll('.match'); // Get all divs with class "my-class"
                        const tournamentId = document.getElementById('tournament-id').value;
                        const bracketId = document.getElementById('bracketId').value;
                        const controllerRequest = 'match';
                        divs.forEach((div, index) => { // Loop through each div

                            const i = index + 1;
                            const id = `${i}`; // Create unique ID for each div
                            const dataValue = `${i}`; // Create unique data value for each div

                            div.setAttribute('id', id); // Set the unique ID for the div
                            div.setAttribute('data-value', dataValue); // Set the unique data value for the div

                            div.addEventListener('click', () => { // Add a click event listener to the div
                                const formData = new FormData(); // Create a new FormData object
                                formData.append('tournamentId', tournamentId); // Add the tournamentId parameter to the FormData object
                                formData.append('matchId', id); // Add the matchId parameter to the FormData object
                                formData.append('bracketId', bracketId); // Add the brcketId parameter to the FormData object
                                formData.append('controllerRequest', controllerRequest);
                                
                                let matchURL = 'bracket_manager/index.php?controllerRequest=match&matchId=';
                                matchURL += id.toString();
                                matchURL += '&tournamentId=';
                                matchURL += tournamentId.toString();
                                matchURL += '&bracketId=';
                                matchURL += bracketId.toString();

                                fetch('bracket_manager/index.php', {
                                    method: 'POST',
                                    body: formData
                                }).then(function (response) {
                                    // Handle the response from the server
                                    window.location.href = matchURL; // Redirect the user to the new page
                                }).catch(function (error) {
                                    console.log(error);
                                });
                            });
                        });
                    }
                });
            });
        </script>
    </div>
</div>
</div>

<!--  READ UP ON THIS PAGE, I NEED TO CHANGE TO A DIFFERENT BRACKET, THIS ALSO SUPPORTS DOUBLE ELIM slightly less appealing initially http://www.aropupu.fi/bracket/ -->

</div>
    
    




<?php require_once '../view/footer.php'; ?>
