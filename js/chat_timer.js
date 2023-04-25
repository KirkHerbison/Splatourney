const cont1 = document.getElementById("cont1");
const matchIdFromForm = document.getElementById('matchId').value;
const userId = document.getElementById('userId').value;


setInterval(function() {
    console.log("timer is running");
            $.ajax({
                url: "bracket_manager/chat_timer.php",
                type: "POST",
                data: {
                    'matchId': matchIdFromForm
                },
                dataType: 'text',
                success: function (data) {

                    const response = JSON.parse(data);

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

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log(ajaxOptions);
                    console.log(thrownError);
                }
            });
}, 2000);
