// hide all games except game 1 for each round or if games are alredy created
jQuery(document).ready(function () {
    jQuery('.round').each(function (index) {
        jQuery(this).find('.game').hide();
        jQuery(this).find('#game1').show();
        jQuery(this).find('#game1').css("border-bottom", "1px solid lightgray");
        jQuery(this).find('#game1').css("margin-bottom", "10px");
        jQuery(this).find('#game3').css("border-bottom", "1px solid lightgray");
        jQuery(this).find('#game3').css("margin-bottom", "10px");
        jQuery(this).find('#game5').css("border-bottom", "1px solid lightgray");
        jQuery(this).find('#game5').css("margin-bottom", "10px");
        jQuery(this).find('#game7').css("border-bottom", "1px solid lightgray");
        jQuery(this).find('#game7').css("margin-bottom", "10px");
        jQuery(this).find('#game9').css("border-bottom", "1px solid lightgray");
        jQuery(this).find('#game9').css("margin-bottom", "10px");

        
        if (jQuery(this).find('#game1 .mapPicker select').val() !== "0") {
            jQuery(this).find('#game2').show();
            jQuery(this).find('#game3').show();
            updateGameOptions(0, 1, 2, 3, (index + 1));

        }
        if (jQuery(this).find('#game2 .mapPicker select').val() !== "0") {
            jQuery(this).find('#game4').show();
            jQuery(this).find('#game5').show();
            updateGameOptions(2, 3, 4, 5, (index + 1));
        }
        if (jQuery(this).find('#game4 .mapPicker select').val() !== "0") {
            jQuery(this).find('#game6').show();
            jQuery(this).find('#game7').show();
            updateGameOptions(4, 5, 6, 7, (index + 1));
        }
        if (jQuery(this).find('#game6 .mapPicker select').val() !== "0") {
            jQuery(this).find('#game8').show();
            jQuery(this).find('#game9').show();
            updateGameOptions(6, 7, 8, 9, (index + 1));
        }
        if (jQuery(this).find('#game8 .mapPicker select').val() !== "0") {
            jQuery(this).find('#game10').show();
            jQuery(this).find('#game11').show();
            updateGameOptions(8, 9, 10, 11, (index + 1));
        }

    });
});
// function to check if all selects in a game are not set to NONE
function checkGameSelections(gameNum, roundNum) {
    let valid = true;
    var mapValue = jQuery('#round' + roundNum + ' #game' + gameNum + ' .mapPicker select').val();
    var modeValue = jQuery('#round' + roundNum + ' #game' + gameNum + ' .modePicker select').val();
    console.log('mapValue' + mapValue);
    console.log('modeValue' + modeValue);
    
    if (mapValue === "0" || modeValue === "0") {
        valid = false;
    }
    return (valid);
}

// function to close the games ahead of a group of games if a value is set to NONE
function closeGameOptions(nextGameOne, nextGameTwo, gameOne, gameTwo, roundNum) {
    var noneCount = 0;
    // check if any of the selects in the newly opened game have a value other than NONE
    jQuery('#round' + roundNum + ' #game' + gameOne + ' select').each(function () {
        if (jQuery(this).val() === "0") {
            noneCount++;
        }
    });
    // check if any of the selects in the newly opened game have a value other than NONE
    jQuery('#round' + roundNum + ' #game' + gameTwo + ' select').each(function () {
        if (jQuery(this).val() === "0") {
            noneCount++;
        }
    });
    // if at least one select has a NONE value, disable the next rounds.
    if (noneCount > 0) {
        jQuery('#round' + roundNum + ' #game' + nextGameOne).hide();
        jQuery('#round' + roundNum + ' #game' + nextGameTwo).hide();
    }
}


//function that changes the ability to select NONE bassed on the conditions necessary 
function updateGameOptions(previousGameOne, previousGameTwo, gameOne, gameTwo, roundNum) {
    var nonNoneCount = 0;
    // check if any of the selects in the newly opened game have a value other than NONE
    jQuery('#round' + roundNum + ' #game' + gameOne + ' select').each(function () {
        if (jQuery(this).val() !== "0") {
            nonNoneCount++;
        }
    });
    // check if any of the selects in the newly opened game have a value other than NONE
    jQuery('#round' + roundNum + ' #game' + gameTwo + ' select').each(function () {
        if (jQuery(this).val() !== "0") {
            nonNoneCount++;
        }
    });
    // if at least one select has a non-NONE value, disable the NONE option for all selects in the game
    if (nonNoneCount > 0) {
        jQuery('#round' + roundNum + ' #game' + previousGameOne + ' select option[value="0"]').prop('disabled', true);
        jQuery('#round' + roundNum + ' #game' + previousGameTwo + ' select option[value="0"]').prop('disabled', true);
    }
    // if all selects are set back to NONE, reactivate the NONE option for all selects in the game
    else {
        jQuery('#round' + roundNum + ' #game' + previousGameOne + ' select option[value="0"]').prop('disabled', false);
        jQuery('#round' + roundNum + ' #game' + previousGameTwo + ' select option[value="0"]').prop('disabled', false);
    }
}

// display  games based on user input
jQuery('#tabs-3').find('select').change(function () {
    console.log('here');
    var gameNum = parseInt(jQuery(this).closest('.game').attr('id').replace('game', ''));
    var roundNum = parseInt(jQuery(this).closest('.round').attr('id').replace('round', ''));
    console.log('gn' + gameNum);
    console.log('rn' + roundNum);
    // check if all selects in game 1 are not set to NONE
    if (gameNum === 1 && checkGameSelections(1, roundNum)) {
        jQuery('#round' + roundNum + ' #game2, #round' + roundNum + ' #game3').show();
    } else {
        closeGameOptions(2, 3, 0, 1, roundNum);
    }
    // check if all selects in games 2 and 3 are not set to NONE
    if ((gameNum === 2 || gameNum === 3)) {
        if (checkGameSelections(2, roundNum) && checkGameSelections(3, roundNum)) {
            jQuery('#round' + roundNum + ' #game4, #round' + roundNum + ' #game5').show();
        } else {
            updateGameOptions(0, 1, 2, 3, roundNum);
            closeGameOptions(4, 5, 2, 3, roundNum);
        }
    }
    // check if all selects in games 4 and 5 are not set to NONE
    if ((gameNum === 4 || gameNum === 5)) {
        if (checkGameSelections(4, roundNum) && checkGameSelections(5, roundNum)) {
            jQuery('#round' + roundNum + ' #game6, #round' + roundNum + ' #game7').show();
        } else {
            updateGameOptions(2, 3, 4, 5, roundNum);
            closeGameOptions(6, 7, 4, 5, roundNum);
        }
    }
    // check if all selects in games 6 and 7 are not set to NONE
    if ((gameNum === 6 || gameNum === 7)) {
        if (checkGameSelections(6, roundNum) && checkGameSelections(7, roundNum)) {
            jQuery('#round' + roundNum + ' #game8, #round' + roundNum + ' #game9').show();
        } else {
            updateGameOptions(4, 5, 6, 7, roundNum);
            closeGameOptions(8, 9, 6, 7, roundNum);
        }
    }
    // check if all selects in games 8 and 9 are not set to NONE
    if ((gameNum === 8 || gameNum === 9)) {
        if (checkGameSelections(8, roundNum) && checkGameSelections(9, roundNum)) {
            jQuery('#round' + roundNum + ' #game10, #round' + roundNum + ' #game11').show();
        } else {
            updateGameOptions(6, 7, 8, 9, roundNum);
            closeGameOptions(10, 11, 8, 9, roundNum);
        }
    }
    // check if all selects in games 10 and 11 are not set to NONE
    if ((gameNum === 10 || gameNum === 11)) {
        updateGameOptions(8, 9, 10, 11, roundNum);
    }
});