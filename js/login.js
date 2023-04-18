/* global url, type, data */
console.log('outside');

$(document).ready(function () {
    console.log('inside');
    const loginButton = document.getElementById('loginButton'); 


    loginButton.addEventListener("click", () => {
        console.log('inside');
            const pass = document.getElementById('pass').value;
    const email = document.getElementById('email').value;
        $.ajax({
            url: "user_manager/loginAjax.php",
            type: "POST",
            data: {
                'pass': pass,
                'email': email
                        
            },
            dataType: 'json',
            success: function(data) {
                if(data.success){
                if(confirm("Login Successful")){
                    window.location.href = 'index.php';
                }
            }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert('Login Failed');
            }
        });
    });
});