<?php
    foreach($categories as $category){
        ?>
            <li><a href="<?php echo getHref("index.php", ['category' => $category['cat_title']]); ?>"><?php echo $category['cat_title']; ?></a></li>
        <?php
    }
?>