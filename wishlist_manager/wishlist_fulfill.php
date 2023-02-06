<?php require_once '../view/header.php'; ?>
<h1>FulFill Wishlist</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Description</th>
        <th>Store</th>
        <th>Quantity</th>
        <th>Fulfilled By</th>
        <th>Fulfill</th>
    </tr>
    <?php foreach ($wishlist->getWishListItems() as $wishlistItem) : ?>
        <?php if ($wishlist->getWishListItemCount() > 0) : ?>
            <tr>
                <td><?php echo $wishlistItem->getId(); ?></td>
                <td><?php echo $wishlistItem->getDescription(); ?></td>
                <td>
                    <?php foreach ($stores as $store) : ?>
                        <?php
                        if ($store->getId() == $wishlistItem->getStoreID()) {
                            echo $store->getName();
                        }
                        ?>
                    <?php endforeach; ?>
                </td>
                <td><?php echo $wishlistItem->getQuantity(); ?></td>
                <td>
                <?php
                if ($wishlistItem->getFulfilledByID() > 0){
                    echo getFulfilledBy($wishlistItem->getFulfilledByID());
                }
                else{
                    echo '';
                }
                ?>
                </td>
                <td>
                    <?php if ($wishlistItem->getFulfilledByID() < 1) : ?>
                    <form action="wishlist_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="fulfill_item" /> 
                        <input type="hidden" name="wishlistId" value="<?php echo $wishlist->getId(); ?>">
                        <input type="hidden" name="item_id" value="<?php echo $wishlistItem->getId(); ?>">
                        <input type="submit" value="Fulfill">
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
<?php require_once '../view/footer.php'; ?>
