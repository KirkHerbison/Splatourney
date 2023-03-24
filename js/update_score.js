/* global url, type, data */


$(document).ready(function () {
    
    const teamOneWin = document.getElementById('teamOneWin');
    const teamTwoWin = document.getElementById('teamTwoWin');
    const matchIdFromForm = document.getElementById('matchId').value;

    
    
    teamOneWin.addEventListener("click", () => {
        $.ajax({
            url: "bracket_manager/addTeamOneWin.php",
            type: "POST",
            data: {
                'matchId': matchIdFromForm
            },
            dataType: 'text',
            success: function() {
                alert("Score has been updated");
                location.reload();
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
            success: function() {
                alert("Score has been updated");
                location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(ajaxOptions);
                console.log(thrownError);
            }
        });
    });
});