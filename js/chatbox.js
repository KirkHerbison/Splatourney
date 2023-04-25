$(document).ready(function () {
    console.log("start");
    const cont1 = document.getElementById("cont1");
    const matchIdFromForm = document.getElementById('matchId').value;
    const userId = document.getElementById('userId').value;





    $('.chat-input').keypress(function (e) {
        if (e.key === 'Enter') {
            const message = document.getElementById('message').value;

            $.ajax({
                url: "bracket_manager/sendChat.php",
                type: "POST",
                data: {
                    'matchId': matchIdFromForm,
                    'message': message
                },
                dataType: 'text',
                success: function (data) {
                    
                    
                    
                    const response = JSON.parse(data);
                    
                    console.log(data);
                    cont1.innerHTML = ''; // clear existing messages
                    
                    
                    response.messages.forEach((newMessage) => {

                        const bubbleDiv = document.createElement("div");
                        const p = document.createElement("p");
                        const dtSpan = document.createElement("span");

                        if (userId == newMessage.userId) {
                            bubbleDiv.classList.add("bubble", "bubble-alt");
                            dtSpan.classList.add("datestamp", "dt-alt");
                        } else {
                            bubbleDiv.classList.add("bubble");
                            dtSpan.classList.add("datestamp");
                        }
                        bubbleDiv.style.opacity = "1";
                        bubbleDiv.style.marginTop = "0px";
                        dtSpan.style.opacity = "1";
                        dtSpan.style.marginTop = "0px";
                        p.textContent = newMessage.message;
                        dtSpan.innerHTML = newMessage.username +" - "+ newMessage.dateSent;
                        bubbleDiv.appendChild(p);
                        cont1.innerHTML += bubbleDiv.outerHTML; // append the new message to the existing chat-container
                        cont1.innerHTML += dtSpan.outerHTML;
                    });
                    $('#message').val(''); // clear the input field
                    // Get a reference to the .chat-box element
                    const chatBox = document.querySelector('#cont1');
                    // Set the scrollTop property to the scrollHeight value
                    chatBox.scrollTop = chatBox.scrollHeight;

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log(ajaxOptions);
                    console.log(thrownError);
                }
            });




//            console.log("here");
//            const bubbleDiv = document.createElement("div");
//            const p = document.createElement("p");
//            bubbleDiv.classList.add("bubble");
//            bubbleDiv.style.opacity = "1";
//            bubbleDiv.style.marginTop = "0px";
//            p.textContent = $('.chat-input').val();
//            bubbleDiv.appendChild(p);
//            cont1.appendChild(bubbleDiv);
        }
    });

    showUI('#cont1');
});


function showUI(ele) {
    console.log($(ele));
    var kids = $(ele).children(), temp;
    for (var i = kids.length - 1; i >= 0; i--) {
        temp = $(kids[i]);

        if (temp.is('div')) {
            temp.animate({
                marginTop: 0,
            }, 400).css({opacity: 1}).fadeIn()
        } else {
            temp.css({opacity: 1}).fadeIn()
        }
    }
    // Get a reference to the .chat-box element
    const chatBox = document.querySelector('#cont1');

// Set the scrollTop property to the scrollHeight value
    chatBox.scrollTop = chatBox.scrollHeight;

}

function hideUI(ele) {
    console.log($(ele));
    var kids = $(ele).children(), temp;
    for (var i = kids.length - 1; i >= 0; i--) {
        temp = $(kids[i]);

        if (temp.is('div')) {
            temp.animate({
                marginTop: '30px',
            }).css({opacity: 0});
        } else {
            temp.css({opacity: 0});
        }
    }
}