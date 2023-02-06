<?php

require_once '../model/User.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../model/database.php');
require_once('../model/wishlist_db.php');
require_once('../model/store_db.php');

//gets user for session for use or creates an empty user object so the code does not break
if (isset($_SESSION['userLogedin'])) {
    $userLogedin = $_SESSION['userLogedin'];
} else {
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', false);
}
$error_message = "";

// Get the data from either the GET or POST collection.
$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ($controllerChoice == NULL) {
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ($controllerChoice == NULL) {
        $controllerChoice = 'Not-Set (Null)';
    }
}

//only a logged in user can visit these pages
//they will be sent to login if they are not loged in
if ($userLogedin->getEmail() != '') {

//sends the user to the wishlist_list
    if ($controllerChoice == 'wishlist_list') {
        $wishlists = getAllWishLists();
        include("wishlist_list.php");
    }
//creates a list of wishlists bassed on a last name search and returns
//to the wishlist_list
    else if ($controllerChoice == 'search_wishlists') {
        $wishlists = searchWishlistByLastName(filter_input(INPUT_POST, 'last_name_search'));
        include("wishlist_list.php");
    }
//Sends the user to the wishlist_edit page with the wishlist(s)
//for the selected user ID
    else if ($controllerChoice == 'edit_wishlist') {
        $wishlists = getWishListsForUser(filter_input(INPUT_POST, 'user_id'));
        $stores = get_stores_active();
        include("wishlist_edit.php");
    }
//Adds an item to the wishlist if user clicks the add item button returns
//the updated list or an error message if the item did not validate
    else if ($controllerChoice == 'add_item') {
        if (filter_input(INPUT_POST, 'description') == null || filter_input(INPUT_POST, 'quantity') == null || filter_input(INPUT_POST, 'stores') == null || !is_numeric(filter_input(INPUT_POST, 'quantity'))) {
            $error_message = "Wishlist item did not validate please verify all fields are filled out ";
        } else {
            $wishlistNewItem = new WishListItem(
                    null,
                    filter_input(INPUT_POST, 'wishlistId'),
                    filter_input(INPUT_POST, 'description'),
                    filter_input(INPUT_POST, 'quantity'),
                    filter_input(INPUT_POST, 'stores'),
                    null,
                    null,
                    1,
                    null,
                    null);
            addWishListItem($wishlistNewItem);
        }
        $wishlists = getWishListsForUser(filter_input(INPUT_POST, 'user_id'));
        $stores = get_stores_active();
        include("wishlist_edit.php");
    }
//deletes an item from the wishlist if the user clicks the delete
//button returns to the wishlist edit page
    else if ($controllerChoice == 'delete_item') {
        deleteWishlistItem(filter_input(INPUT_POST, 'item_id'));
        $wishlists = getWishListsForUser(filter_input(INPUT_POST, 'user_id'));
        $stores = get_stores_active();
        include("wishlist_edit.php");
    }
//updates the wishlist if the user clicks the save changes button for the wishlist
    else if ($controllerChoice == 'update_wishlist') {
        $userID = filter_input(INPUT_POST, 'user_id');
        update_description(filter_input(INPUT_POST, 'wishlistId'),
                filter_input(INPUT_POST, 'description'),
                filter_input(INPUT_POST, 'isActive'));
        $wishlists = getWishListsForUser(filter_input(INPUT_POST, 'user_id'));
        $stores = get_stores_active();
        include("wishlist_edit.php");
    }
//Sends an end user to edit their own wishlist
    else if ($controllerChoice == 'edit_my_wishlist') {
        $wishlists = getWishListsForUser($userLogedin->getId());
        $stores = get_stores_active();
        include("wishlist_edit.php");
    }
// creates a new wishlist when the user clicks the create button
// returns an error if no name was entered
// sends user back to their wishlist page
    else if ($controllerChoice == 'create_wishlist') {
        if (filter_input(INPUT_POST, 'new_wishlist_name') != null) {
            $userID = filter_input(INPUT_POST, 'user_id');
            addWishlist(filter_input(INPUT_POST, 'new_wishlist_name'), $userID);
        } else {
            $error_message = "please enter a name for your wishlist";
        }
        $wishlists = getWishListsForUser($userLogedin->getId());
        $stores = get_stores_active();
        include("wishlist_edit.php");
    }
//sends the user the the fulfill page for a specific wishlist
//when the fulfill button is clicked
    else if ($controllerChoice == "fulfill_wishlist") {
        $wishlist = getWishListByID(filter_input(INPUT_POST, 'wishlistId'));
        $stores = get_stores();
        include("wishlist_fulfill.php");
    }
//fulfills the item that the user clicks fulfill button on
    else if ($controllerChoice == "fulfill_item") {
        updateFulfilledBy(filter_input(INPUT_POST, 'item_id'), $userLogedin->getId());
        $wishlist = getWishListByID(filter_input(INPUT_POST, 'wishlistId'));
        $stores = get_stores();
        include("wishlist_fulfill.php");
    }
    //lists all of the items the loged in customer has fulfilled
    else if ($controllerChoice == 'list_fulfilled') {
        $wishlistItems = getWishlistItemsForUser($userLogedin->getId());
        $wishlists = getAllWishLists();
        $stores = get_stores();
        include("wishlist_fulfilled_list.php");
    }
    // saves an edited wishlist item from the wishlist_edit page
    else if ('save_item'){
        $quantity = filter_input(INPUT_POST, 'quantity');
        if(is_numeric(filter_input(INPUT_POST, 'quantity'))){
                    $wishlistItem = new WishListItem(
                    filter_input(INPUT_POST, 'item_id'),
                    null,
                    filter_input(INPUT_POST, 'description'),
                    filter_input(INPUT_POST, 'quantity'),
                    filter_input(INPUT_POST, 'stores'),
                    null,
                    null,
                    null,
                    null,
                    null);
        updateWishlistItem($wishlistItem);
        }else{
            $error_message = "quantity must be a numeric number";
        }

        $stores = get_stores_active();
        $wishlists = getWishListsForUser(filter_input(INPUT_POST, 'user_id'));
        include("wishlist_edit.php");
    }
} else {
    require_once("../user_manager/user_login.php");
}




