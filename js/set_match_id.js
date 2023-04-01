
document.addEventListener('DOMContentLoaded', () => {

    const divs = document.querySelectorAll('.match'); // Get all divs with class "my-class"
    console.log(divs);
    const tournamentId = document.getElementById('tournament-id').value;

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
            formData.append('controllerRequest', controllerRequest);

            fetch('bracket_manager/index.php', {
                method: 'POST',
                body: formData
            }).then(function (response) {
                // Handle the response from the server
                window.location.href = response.url; // Redirect the user to the new page
            }).catch(function (error) {
                console.log(error);
            });
        });
    });

});

