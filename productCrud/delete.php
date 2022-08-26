<?php
// connect t database using PDO
// create the new instance of the class
$pdo = new PDO("mysql:host=localhost;port=3306;dbname=products_crud", "root", "");
// show error
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$id = $_POST['id'] ?? null;

$stmt= $pdo->prepare("delete from products where id = :id");
$stmt->bindValue(':id',$id);
$stmt->execute();
header("location:index.php");

if (empty($id)) {

    header("location:index.php");
    exit;
}