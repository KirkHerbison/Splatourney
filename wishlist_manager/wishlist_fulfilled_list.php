<?php require_once '../view/header.php'; ?>
<h1>FulFilled Items</h1>
<table>
    <tr>
        <th>Wish List Name</th>
        <th>Item Description</th>
        <th>Store</th>
        <th>Quantity</th>
    </tr>
    <?php foreach ($wishlistItems as $wishlistItem) : ?>
        <?php if (count($wishlistItems) > 0) : ?>
            <tr>
                <td>
                    <?php foreach ($wishlists as $wishlist) : ?>
                        <?php
                            if ($wishlist->getId() == $wishlistItem->getWishListID()) {
                                echo $wishlist->getDescription();
                            }
                        ?>
                    <?php endforeach; ?>
                </td>
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
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
<?php require_once '../view/footer.php'; ?>
