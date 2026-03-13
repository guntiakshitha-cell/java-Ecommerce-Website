<?php
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: adminLogin.php");
    exit();
}

include "../includes/db.php";

if(isset($_POST['add_product'])){

$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];

$imageName = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

move_uploaded_file($tmp,"../images/".$imageName);

$stmt = $conn->prepare("INSERT INTO products (name,price,description,image) VALUES (?,?,?,?)");
$stmt->execute([$name,$price,$description,$imageName]);

header("Location: adminDashboard.php");
exit();

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>

<style>

body{
font-family:Arial;
background:#f4f6f9;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
margin:0;
}

.box{
background:white;
padding:30px;
width:350px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

h2{
text-align:center;
}

input,textarea{
width:100%;
padding:10px;
margin:10px 0;
border:1px solid #ccc;
border-radius:5px;
}

button{
width:100%;
padding:10px;
background:#28a745;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
}

button:hover{
background:#218838;
}

</style>

</head>

<body>

<div class="box">

<h2>Add Product</h2>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" placeholder="Product Name" required>

<input type="number" name="price" placeholder="Product Price" required>

<textarea name="description" placeholder="Product Description"></textarea>

<input type="file" name="image" required>

<button type="submit" name="add_product">Add Product</button>

</form>

</div>

</body>
</html>