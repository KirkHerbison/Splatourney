$(document).ready(function () {
    console.log("start");
    const cont1 = document.getElementById("cont1");
    const matchIdFromForm = document.getElementById('matchId').value;


    $('.user-profile').click(function () {
        if (!$(this).hasClass('active')) {

            $('.user-profile.active').removeClass('active');
            $(this).addClass('active');

            var temp = $('#' + $(this).attr('data-up'));

            hideUI('.chat-container');
            showUI('#' + $(this).attr('data-up'));
            temp.addClass('active').removeClass('hidechat');
            temp.prevAll('.chat-container').addClass('hidechat').removeClass('active');
            temp.nextAll('.chat-container').removeClass('active').removeClass('hidechat');
        }
    });

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
                success: function() {
                    $(cont1).load(location.href + ' #cont1');
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