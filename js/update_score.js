/* global url, type, data */

const teamOneWin = document.getElementById('teamOneWin');
const matchIdFromForm = document.getElementById('matchId').value;

$(document).ready(function () {
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
});