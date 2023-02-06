<?php require_once '../view/header.php'; ?>
<h1>WishList List</h1>
<form action="wishlist_manager/index.php" method="POST">
    <input type="hidden" name="controllerRequest" value="search_wishlists" /> 
    <br>
    <div>
        <p>Search by last name:</p>
        <input type="text" name="last_name_search">
    </div>
    <br>
    <div>
        <p></p><input type="submit" value="Search">
    </div>
    <br>
    
</form>


<table>
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Description</th>
        <th># Items</th>
        <th>Date Created</th>
        <th>Date Updated</th>
        <th>isActive</th>
        <?php if ($userLogedin->getRoleId() == 'Administrator') { ?>
        <th>Edit User</th>
        <?php }?>
        <th>See List</th>
    </tr>
    <?php foreach ($wishlists as $wishlist) : ?>
        <tr>
            <td><?php echo $wishlist->getId(); ?></td>
            <td><?php echo $wishlist->getFirstName(); ?><br><?php echo $wishlist->getLastName(); ?></td>
            <td><?php echo $wishlist->getDescription(); ?></td>
            <td><?php echo $wishlist->getWishListItemCount(); ?></td>
            <td><?php echo $wishlist->getDateCreated(); ?></td>
            <td><?php echo $wishlist->getDateUpdated(); ?></td>
            <td><?php if ($wishlist->getIsActive() == 1) {
        echo "Active";
    } else {
        echo "Deleted";
    } ?></td>
            <?php if ($userLogedin->getRoleId() == 'Administrator') { ?>
            <td>
                <form action="wishlist_manager/index.php" method="POST">
                    <input type="hidden" name="controllerRequest" value="edit_wishlist" /> 
                    <input type="hidden" name="user_id" value="<?php echo $wishlist->getUserID(); ?>">
                    <input type="hidden" name="wishlist_id" value="<?php echo $wishlist->getId(); ?>">
                    <input type="submit" value="Edit List">
                </form>
            </td>
            <?php }?>
            </td>
            <td>
                <form action="wishlist_manager/index.php" method="POST">
                    <input type="hidden" name="controllerRequest" value="fulfill_wishlist" /> 
                    <input type="hidden" name="wishlistId" value="<?php echo $wishlist->getId(); ?>">
                    <input type="submit" value="Fulfill">

                </form>
            </td>
        </tr>
<?php endforeach; ?>
</table>

<?php require_once '../view/footer.php'; ?>
