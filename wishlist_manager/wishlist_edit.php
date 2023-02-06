<?php require_once '../view/header.php'; ?>
<h1>WishList List</h1>
<form action="wishlist_manager/index.php" method="POST">
    <input type="hidden" name="controllerRequest" value="create_wishlist" />
    <input type="hidden" name="user_id" value="<?php echo $userLogedin->getId() ?>" />
    <span style='color: red'><?php echo $error_message ?></span>
    <br>
    <div>
        <p>Create WishList:</p>
        <input type="text" name="new_wishlist_name">
    </div>
    <br>
    <div>
        <p></p><input type="submit" value="Create">
    </div>
    <br>
</form>
<?php foreach ($wishlists as $wishlist) : ?>
    <hr>
    <br>
    <form action="wishlist_manager/index.php" method="POST" >
        <input type="hidden" name="user_id" value="<?php echo $wishlist->getUserId(); ?>" /> 
        <br>
        <div>
            <p>WishListId: </p>
            <input type="text" name="wishlistId" value="<?php echo $wishlist->getId(); ?>" readonly>
            <p>Full Name: </p>
            <input type="text" name="full_name" value="<?php echo $wishlist->getFirstName(); ?> <?php echo $wishlist->getLastName(); ?>" readonly>
        </div>
        <br>
        <div>
            <p>Description: </p>
            <input type="text" name="description" value="<?php echo $wishlist->getDescription(); ?>">
            <p>Date Created: </p>
            <input type="text" name="date_created" value="<?php echo $wishlist->getDateCreated(); ?>" readonly>
        </div>
        <br>
        <div>
            <p>Date Updated: </p>
            <input type="text" name="date_updated" value="<?php echo $wishlist->getDateUpdated(); ?>" readonly>
            <p>Status: </p>
            <select name="isActive">
                <option value="1" >Active</option>
                <option value="0" <?php
                if ($wishlist->getIsActive() == 0) {
                    echo "selected";
                }
                ?>>Deleted</option>
            </select>
        </div>
        <br>
        <div>
            <p></p>
            <input type="hidden" name="controllerRequest" value="update_wishlist" /> 
            <input type="submit" value="Save Changes">
            </form>
        </div>
        <br>

        <table>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Store</th>
                <th>Quantity</th>
                <th>Save</th>
                <th>Delete</th>
            </tr>
            <?php foreach ($wishlist->getWishListItems() as $wishlistItem) : ?>
                <?php if ($wishlist->getWishListItemCount() > 0) : ?>
                    <tr>
                    <form action="wishlist_manager/index.php" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $wishlist->getUserId(); ?>" /> 
                        <td><?php echo $wishlistItem->getId(); ?></td>
                        <td><input type="text" name="description" value="<?php echo $wishlistItem->getDescription(); ?>"></td>
                        <td><select name="stores" >
                                <option hidden>Store Deleted </option>
                                <?php foreach ($stores as $store) : ?>
                                    <option value="<?php echo $store->getId(); ?>" <?php
                                    if ($store->getId() == $wishlistItem->getStoreID()) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $store->getName(); ?></option>
                                        <?php endforeach; ?>
                        </td>
                        <td><input type="text" name="quantity" value="<?php echo $wishlistItem->getQuantity(); ?>"></td>
                        <td>                

                            <input type="hidden" name="controllerRequest" value="save_item" />
                            <input type="hidden" name="wishlistId" value="<?php echo $wishlist->getId(); ?>" />
                            <input type="hidden" name="item_id" value="<?php echo $wishlistItem->getId(); ?>">
                            <input type="submit" value="Save Changes">
                    </form>
                    </td>
                    <td>
                        <form action="wishlist_manager/index.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $wishlist->getUserId(); ?>" /> 
                            <input type="hidden" name="wishlistId" value="<?php echo $wishlist->getId(); ?>" />
                            <input type="hidden" name="controllerRequest" value="delete_item" /> 
                            <input type="hidden" name="item_id" value="<?php echo $wishlistItem->getId(); ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr> 
            <form action="wishlist_manager/index.php" method="POST">
                <td>NEW</td>
                <input type="hidden" name="wishlistId" value="<?php echo $wishlist->getId(); ?>" />
                <td><input type="text" name="description" value=""></td>
                <td><select name="stores" >
                        <?php foreach ($stores as $store) : ?>
                            <option value="<?php echo $store->getId(); ?>"><?php echo $store->getName(); ?></option>
                        <?php endforeach; ?>
                </td>
                <td><input type="text" name="quantity" value=""></td>
                <td>                
                    <input type="hidden" name="controllerRequest" value="add_item" />
                    <input type="hidden" name="user_id" value="<?php echo $wishlist->getUserId(); ?>" /> 
                    <input type="submit" value="Add Item">
            </form>
            </td>
            <td>
                N/A
            </td>     
            </tr>
        </table>
    <?php endforeach; ?>
    <?php require_once '../view/footer.php'; ?>
