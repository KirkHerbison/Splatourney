const form = document.getElementsByClassName('matchForm');
const match = document.getElementsByClassName('match');


for(let i = 0; i < form.length; i++) {
    form[i].addEventListener('submit', (event) => {
    // Prevent the default form submission behavior
        event.preventDefault();
    // Submit the form programmatically
        form[i].submit();
    });
    
    
    match[i].addEventListener("click", () => {
        // Programmatically click the form's submit button
        form[i].dispatchEvent(new Event('submit'));
    });
}



