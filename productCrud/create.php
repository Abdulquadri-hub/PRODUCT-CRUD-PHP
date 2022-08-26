
<?php
// connect t database using PDO
// create the new instance of the class
$pdo = new PDO("mysql:host=localhost;port=3306;dbname=products_crud", "root", "");
// show error
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$errors = [];
$title = "";
$description = "";
$price = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];

if (empty($title)) {
    $errors[] = "Product title is Required";
}

if (empty($price)) {
    $errors[] = "Product price is Required";
}

if (empty(is_dir("images"))) {
    mkdir('images');
}





if (empty($errors)) 
{

    #short tenary
    $image = $_FILES['image'] ?? null;
    $imagePath = '';
    if ($image && $image['tmp_name']) {
        #image path
        $imagePath = 'images/'.randomString(8).'/'.$image['name'];
        mkdir(dirname($imagePath));
        move_uploaded_file($image['tmp_name'], $imagePath);
    }
$stmt= $pdo->prepare("insert into products set 
title = :title, 
image = :image, 
description = :description, 
price = :price"
);
$stmt->bindValue(':title',$title);
$stmt->bindValue(':image',$imagePath);
$stmt->bindValue(':description',$description);
$stmt->bindValue(':price',$price);
$stmt->execute();
header('location: index.php');
}

}

function randomString($n) 
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for($i = 0; $i < $n; $i++) { 
        
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }
    return $str;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product_Crud</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <style>
        body {
            padding: 70px;
        }
    </style>
</head>
<body>
<h1>Create New Products</h1>

<?php if(!empty($errors)):?>
<div class="alert alert-danger">
    <?php foreach($errors as $error):?>
    <div><?=$error?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label>Product Image</label>
        <br>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label>Product Title</label>
        <input type="text" name="title" class="form-control" value="<?=$title?>">
    </div>

    <div class="form-group">
        <label>Product Description</label>
        <textarea class="form-control" name="description"><?=$description?></textarea>
    </div>

    <div class="form-group">
        <label>Product Price</label>
        <input type="number" step=".01" name="price" class="form-control" value="<?=$price?>">
    </div>
    <br>  
    
    <button class="btn btn-secondary">Create</button>
</form>

</body>
</html>


