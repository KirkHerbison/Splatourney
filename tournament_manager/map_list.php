<?php require_once '../view/header.php'; ?>
<h1>Map List</h1>
    <?php foreach ($maps as $map) : ?>
        <p><?php echo $map->getDescription(); ?></p>
        <br>
        <img style="max-width: 200px;" src="<?php echo $map->getImageLink(); ?>" alt="<?php echo $map->getDescription(); ?>"/>
    <?php endforeach; ?>
<?php require_once '../view/footer.php'; ?>
