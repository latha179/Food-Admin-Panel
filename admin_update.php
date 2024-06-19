<?php

@include 'config.php';

$id=$_GET['edit'];

if(isset($_POST['update_product'])){
    $product_name=$_POST['product_name'];
    $product_price=$_POST['product_price'];
    $product_image=$_FILES['product_image']['name'];
    $product_image_tmp_name=$_FILES['product_image']['tmp_name'];
    $product_image_folder='uploaded_img/'.$product_image;

    if(empty($product_name)|| empty($product_price)|| empty($product_image)){
        $message[]='please fill out all';
    }
    else{
        $update="update Products set name='$product_name',price='$product_price',image='$product_image'
        where id=$id";
        $upload=mysqli_query($conn,$update);
        if($upload){
            $message[]='new product added successfully';
            header('location:admin_page.php');
        }
        else{
            $message[]="couldn't add the product";
        }
    }
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin update page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php

if(isset($message)){
    foreach($message as $message){
        echo '<span class="message">'.$message.'</span>';
    }
}

?>
 <div class="container">
        <div class="admin-form centered">

        <?php
        $select =mysqli_query($conn,"select * from Products where id=$id");
        while($row=mysqli_fetch_assoc($select)){
        ?>
            
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h3>Add a new product</h3>
            <input type="text" placeholder="enter product name" value="<?php $row['name'];?>" name="product_name" class="box"><br>
            <input type="number" placeholder="enter product price" value="<?php $row['name'];?>" name="product_price" class="box"><br>
            <input type="file" accept="image/png, image/jpeg,image/jpg" name="product_image" class="box"><br>
            <input type="submit" class="button" name="update_product" value="update product"><br>
            <a href="admin_page.php" class="button">Go Back</a>
        </form>

        <?php }; ?>
        </div>

</div>

</body>
</html>  