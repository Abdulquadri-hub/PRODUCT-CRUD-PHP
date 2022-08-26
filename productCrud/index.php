
<?php

// connect using PDO
// create the new instance of the class
$pdo = new PDO("mysql:host=localhost;port=3306;dbname=products_crud", "root", "");
// show error
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = $_GET['search'] ?? '';
if ($search) {
$stmt = $pdo->prepare("select * from products where title like :title order by created_at desc");
$stmt->bindValue(':title', "%$search%");

} else{
    $stmt = $pdo->prepare("select * from products order by created_at desc");
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
        .thumb-image{
            width: 50px;
        }
    </style>
</head>
<body>
<h1>Products CRUD</h1>

    <p>
        <a href="create.php">
            <button class="btn btn-success">Create Product</button>
        </a>
    </p>

<form action="" method="post">
<div class="input-group">
    <input type="text" class="form-control" placeholder="Search for products" value="<?=$search?>" name="search">
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit" >Search</button>
    </div>
</div>
</form>

<table class="table">
    <thead>
    <tr>
    <th scope="col">#</th>
    <th scope="col">Image</th>
    <th scope="col">title</th>
    <th scope="col">Price</th>
    <th scope="col">Created_at</th>
    <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($products as $i => $product):?>
    <tr>
        <th scope="row"><?=$i + 1?></th>
        <td>
            <img src="<?=$product['image']?>" class="thumb-image" alt="">
        </td>
        <td><?=$product['title']?></td>
        <td><?=$product['price']?></td>
        <td><?=date("Y-M-d",strtotime($product['created_at']))?></td>
    <td>
    <a href="update.php?id=<?=$product['id']?>">
        <button class="btn btn-sm btn-outline-secondary">Edit</button>
    </a>
        <form style="display:inline-block;" action="delete.php" method="post">
        <input type="hidden" name="id" value="<?=$product['id']?>">
        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
        </form>
    </td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
</body>
</html>


