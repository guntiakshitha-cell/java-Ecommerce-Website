<?php
session_start();

if(!isset($_SESSION['admin_id'])){
header("Location: adminLogin.php");
exit();
}

include "../includes/db.php";

$id=$_GET['id'];

$stmt=$conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);
$product=$stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['update'])){

$name=$_POST['name'];
$price=$_POST['price'];
$description=$_POST['description'];

$imageName=$product['image']; // keep old image

/* check if new image uploaded */

if(!empty($_FILES['image']['name'])){

$imageName=$_FILES['image']['name'];
$tmp=$_FILES['image']['tmp_name'];

move_uploaded_file($tmp,"../images/".$imageName);

}

$stmt=$conn->prepare("UPDATE products SET name=?,price=?,description=?,image=? WHERE id=?");
$stmt->execute([$name,$price,$description,$imageName,$id]);

header("Location: adminDashboard.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>

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
background:#007bff;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
}

img{
width:120px;
margin-top:10px;
}

</style>
</head>

<body>

<div class="box">

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" value="<?php echo $product['name']; ?>" required>

<input type="number" name="price" value="<?php echo $product['price']; ?>" required>

<textarea name="description"><?php echo $product['description']; ?></textarea>

<p>Current Image</p>

<img src="../images/<?php echo $product['image']; ?>">

<p>Change Image</p>

<input type="file" name="image">

<button type="submit" name="update">Update Product</button>

</form>

</div>

</body>
</html>