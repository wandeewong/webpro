

<div class="panel panel-primary">
    <div class="panel-heading text-center">หมวดหมู่สินค้า</div>
    <div class="list-group">
        <?php
        $sql_group = SELECT($conn,"tb_groups");
        while($group = $sql_group->fetch_assoc())
        {
        ?>
        <a href="search.php?search=<?php echo $group['name_group']; ?>" class="list-group-item"><b><?php echo $group['name_group']; ?></b></a>
        <?php
        }
        ?>
    </div>
</div>


<div class="panel panel-primary">
    <div class="panel-heading text-center">สินค้าน่าสนใจ</div>
    <div class="panel-body">
    <?php
    if(isset($_SESSION['product']))
    {
        $id_group = $_SESSION['product'];
        $sql_product_like = "SELECT * FROM tb_products WHERE id_group = '$id_group' limit 3";
    }
    else
    {
        $sql_product_like = "SELECT * FROM tb_products ORDER BY id_product DESC limit 3";
    }
    $query_product_like = $conn->query($sql_product_like);
    while($product_like = $query_product_like->fetch_assoc())
    {
        $price = ($product_like['price_product']-$product_like['discount_product'])+($product_like['price_product']-$product_like['discount_product'])*7/100;
    ?>
    <a href="product.php?id=<?php echo $product_like['id_product']; ?>" class="thumbnail" style="text-decoration: none;">
        <div class="caption">
            <img src="Images/Products/<?php echo $product_like['image_product']; ?>" width="100px" height="100px" style="vertical-align: top;" alt="No Images">
            <div style="display: inline-block; width:130px;">
                <h5><b><?php echo $product_like['name_product']; ?></b></h5>
                <?php
                if($product_like['discount_product'] > 0)
                {
                ?>
                <h6><span class="text-danger" style="text-decoration: line-through;">THB <?php echo number_format(($product_like['price_product']*7/100)+$product_like['price_product']); ?></span> <span><?php echo number_format(($product_like['discount_product']/$product_like['price_product'])*100);?>%</span></h6>
                <?php
                }
                ?>
                <h5><b>THB <?php echo number_format($price); ?></b></h5>
            </div>
        </div>
    </a>
    <?php
    }
    ?>
    </div>
</div>