/* global url, type, data */


$(document).ready(function () {
    
    const teamOneWin = document.getElementById('teamOneWin');
    const teamOneScore = document.getElementById('teamOneScore');
    
    const teamTwoWin = document.getElementById('teamTwoWin');
    const teamTwoScore = document.getElementById('teamTwoScore');
    
    const matchIdFromForm = document.getElementById('matchId').value;

    teamOneWin.addEventListener("click", () => {
        $.ajax({
            url: "bracket_manager/addTeamOneWin.php",
            type: "POST",
            data: {
                'matchId': matchIdFromForm
            },
            dataType: 'text',
            success: function(data) {
                alert("Score has been updated");
                const response = JSON.parse(data);
                const vic = response.victory;
                teamOneScore.textContent = response.score;
                if(vic === 'true'){
                    teamOneWin.remove();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(ajaxOptions);
                console.log(thrownError);
            }
        });
    });
    
    teamTwoWin.addEventListener("click", () => {
        
        $.ajax({
            url: "bracket_manager/addTeamTwoWin.php",
            type: "POST",
            data: {
                'matchId': matchIdFromForm
            },
            dataType: 'text',
            success: function(data) {
                alert("Score has been updated");
                const response = JSON.parse(data);
                const vic = response.victory;
                teamTwoScore.textContent = response.score;
                if(vic === 'true'){
                    teamTwoWin.remove();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(ajaxOptions);
                console.log(thrownError);
            }
        });
    });
});