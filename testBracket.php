<?php
require_once 'model/User.php';
session_start();

if (isset($_SESSION['userLogedin'])) {
    $userLogedin = $_SESSION['userLogedin'];
} else {
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', '', false, false);
}

require_once 'view/header.php';
?>

<link rel="stylesheet" type="text/css" href="styles/single_elimination_bracket.css">

<div class="bracket"> <!-- start bracket -->



    <div class="round"> <!-- start round -->
        <div class="gameGroup"> <!-- start game group -->

            <div class="groupDiv"> <!-- start group div -->

                <div class="gameTop">
                    <div class="teamDivTop">
                        <span class="team">Team 1</span>
                    </div>
                    <div class="teamDivBottom">
                        <span  class="team">Team 2</span>
                    </div>
                </div>
                <div class="gameBottom">
                    <div class="teamDivTop">
                        <span  class="team">Team 3</span>
                    </div>
                    <div class="teamDivBottom">
                        <span  class="team">Team 4</span>
                    </div>
                </div>
            </div>  <!-- end group div -->  
            <div class="connector">
                <div class="merger">&nbsp;</div> <!-- vertical line -->
                <div class="line">&nbsp;</div> <!-- horizontal line -->
            </div>

        </div> <!-- end game group -->    

        <div class="gameGroup"> <!-- start game group -->
            <div class="groupDiv"> <!-- start group div -->

                <div class="gameTop">
                    <div class="teamDivTop">
                        <span class="team">Team 5</span>
                    </div>
                    <div class="teamDivBottom">
                        <span  class="team">Team 6</span>
                    </div>
                </div>
                <div class="gameBottom">
                    <div class="teamDivTop">
                        <span  class="team">Team 7</span>
                    </div>
                    <div class="teamDivBottom">
                        <span  class="team">Team 8</span>
                    </div>
                </div>
            </div>
            <div class="connector">
                <div class="merger">&nbsp;</div> <!-- vertical line -->
                <div class="line">&nbsp;</div> <!-- horizontal line -->
            </div>
        </div> <!-- end game group -->



    </div> <!-- end round -->







    <div class="round"> <!-- start round -->
        <div class="gameGroup"> <!-- start game group -->
            <div class="groupDiv"> <!-- start group div -->
            <div class="gameTop">
                <div class="teamDivTop">
                    <span class="team">Team 1</span>
                </div>
                <div class="teamDivBottom">
                    <span  class="team">Team 3</span>
                </div>
            </div>
            <div class="gameBottom">
                <div class="teamDivTop">
                    <span  class="team">Team 5</span>
                </div>
                <div class="teamDivBottom">
                    <span  class="team">Team 7</span>
                </div>
            </div>
            </div>
            <div class="connector">
                <div class="merger">&nbsp;</div> <!-- vertical line -->
                <div class="line">&nbsp;</div> <!-- horizontal line -->
            </div>
        </div> <!-- end game group -->

    </div> <!-- end round -->

    
    
    
    
    
    
    
    
    
    <div class="round"> <!-- start round -->
        <div class="gameFinal">
            <div class="teamDivTop">
                <span class="team">Team 1</span>
            </div>
            <div class="teamDivBottom">
                <span class="team">Team 5</span>
            </div>
        </div>
    </div> <!-- end game final -->
</div> <!-- end round -->




</div> <!-- end bracket -->


<?php require_once 'view/footer.php'; ?>
