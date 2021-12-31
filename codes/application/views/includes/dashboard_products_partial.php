<?php   if (isset($products) && $products != NULL)  {
            $row = 1;
            foreach($products as $product) { 
                ($row % 2 == 1) ? $row_class = "row-odd" : $row_class = "" ; ?>
                <tr class="<?= $row_class?>">
                <!-- Change directory to access the sub-img(substitute image) file if no actual image was specified by the admin -->
<?php           if ($product['primary_img'] != "sub_img.jpg") { ?>  <!-- Dispalay image of product -->
                    <td><img class="image-1" src="/products_img/<?= $product['category'] ?>/<?= $product['primary_img']?>" alt="<?= $product['primary_img']?>" title="<?= $product['primary_img']?>"></td>
<?php           }
                else { ?>                                           <!-- Substitute Image if no image found on the dir or no image set -->
                    <td><img class="image-1" src="/products_img/<?= $product['primary_img']?>" alt="<?= $product['primary_img']?>" title="<?= $product['primary_img']?>"></td>
<?php           }?>
                    <td><?= $product['id']?></td>
                    <td><?= $product['category']?></td>
                    <td><?= $product['name']?></td>
                    <td>$<?= $product['price']?></td>
                    <td><?= $product['stock']?></td>
                    <td><?= $product['sold'] != NULL ? $product['sold'] : "0" ;?></td>
                    <td class="action"><a data-id="<?= $product['id']?>" href="<?= base_url()?>dashboard/productModal/Edit/<?= $product['id']?>">edit</a> <a href="<?= base_url()?>products/productDelete/<?= $product['category']?>/<?= $product['id']?>">delete</a></td>
                </tr>
<?php           $row++;
            }
        }
        else { ?>
                <tr>
                    <td>No Products</td>
                </tr>
<?php   } ?>