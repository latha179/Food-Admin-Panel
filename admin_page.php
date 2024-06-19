<?php
 
@include 'config.php';

if(isset($_POST['add_product'])){
    $product_name=$_POST['product_name'];
    $product_price=$_POST['product_price'];
    $product_image=$_FILES['product_image']['name'];
    $product_image_tmp_name=$_FILES['product_image']['tmp_name'];
    $product_image_folder='uploaded_img/'.$product_image;

    if(empty($product_name)|| empty($product_price)|| empty($product_image)){
        $message[]='please fill out all';
    }
    else{
        $insert="insert into Products(name,price,image) values('$product_name','$product_price','$product_image')";
        $upload=mysqli_query($conn,$insert);
        if($upload){
            $message[]='new product added successfully';
        }
        else{
            $message[]="couldn't add the product";
        }
    }
};

if(isset($_GET['delete'])){
    $id=$_GET['delete'];
    mysqli_query($conn,"Delete from Products where id=$id");
    header('location:admin_page.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
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
        <div class="admin-form">
            
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h3>Add a new product</h3>
            <input type="text" placeholder="enter product name" name="product_name" class="box"><br>
            <input type="number" placeholder="enter product price" name="product_price" class="box"><br>
            <input type="file" accept="image/png, image/jpeg,image/jpg" name="product_image" class="box"><br>
            <input type="submit" class="button" name="add_product" value="add product"><br>
        </form>
        </div>

    <?php 
    $select = mysqli_query($conn,"select * from Products");
    ?>

    <div class="product-display">
        <table class="product-display-table">
            <thead>
                <tr>
                    <th>product image</th>
                    <th>product name</th>
                    <th>product price</th>
                    <th>action</th>
                </tr>
            </thead>

            <?php
            while($row=mysqli_fetch_assoc($select)){
            ?>
             <tr>
                <td><img src="uploaded_img/<?php echo $row['image'];?>" height="100" alt=""></td>
                <td><?php echo $row['name'];?> </td>
                <td><?php echo $row['price'];?>/- </td>
                <td>
                    <a class="button" href="admin_update.php?edit=<?php echo $row['id'];?>" ><i class="fas fa-edit"></i>edit</a><br>
                    <a class="button" href="admin_page.php?delete=<?php echo $row['id'];?>" ><i class="fas fa-trash"></i>delete</a>
                </td>
             </tr>
             <?php }?>
        </table>

    </div>

    </div>
</body>
</html>