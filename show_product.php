
<div class="col-lg-4">
    <a href="product.php?id=<?php echo $product['id_product']; ?>" class="thumbnail" style="text-decoration: none; height: 450px;">
        <div class="caption">
            <div class="text-center">
                <img src="Images/Products/<?php echo $product['image_product']; ?>" height="200px" width="200px" alt="No Image">
            </div>
                <h4><b><?php echo $product['name_product']; ?></b></h4>
                <?php
                if($product['discount_product'] > 0)
                {
                ?>
                <h5><span class="text-danger" style="text-decoration: line-through;">THB <?php echo number_format(($product['price_product']*7/100)+$product['price_product']); ?></span> <span><?php echo number_format(($product['discount_product']/$product['price_product'])*100);?>%</span></h5>
                <?php
                }
                ?>
                <h4><b>THB <?php echo number_format($price); ?></b></h4>
                <span class="glyphicon glyphicon-heart text-danger"><?php echo $product['like_product']; ?></span>
                <span class="glyphicon glyphicon-eye-open"><?php echo $product['view_product']; ?></span>
            
        </div>
    </a>
</div>