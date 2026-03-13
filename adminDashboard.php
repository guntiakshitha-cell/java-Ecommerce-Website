<?php
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: adminLogin.php");
    exit();
}

include "../includes/db.php";

$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<style>

body{
font-family:Arial;
margin:0;
background:#f4f6f9;
}

header{
background:#2f4054;
color:white;
padding:20px 40px;
display:flex;
justify-content:space-between;
align-items:center;
}

header a{
color:white;
text-decoration:none;
margin-left:20px;
}

.container{
width:90%;
margin:30px auto;
}

table{
width:100%;
border-collapse:collapse;
background:white;
}

th,td{
padding:12px;
border:1px solid #ddd;
text-align:center;
}

th{
background:#f2f2f2;
}

img{
width:70px;
}

.edit{
background:#28a745;
color:white;
padding:6px 10px;
border:none;
border-radius:4px;
text-decoration:none;
}

.delete{
background:#dc3545;
color:white;
padding:6px 10px;
border:none;
border-radius:4px;
text-decoration:none;
}

</style>
</head>

<body>

<header>

<h2>Admin Dashboard</h2>

<div>
<a href="addProduct.php">Add Product</a>
<a href="adminLogout.php">Logout</a>
</div>

</header>

<div class="container">

<h2>All Products</h2>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Price</th>
<th>Description</th>
<th>Image</th>
<th>Actions</th>
</tr>

<?php foreach($products as $product): ?>

<tr>

<td><?php echo $product['id']; ?></td>

<td><?php echo $product['name']; ?></td>

<td><?php echo $product['price']; ?></td>

<td><?php echo $product['description']; ?></td>

<td>
<img src="../images/<?php echo $product['image']; ?>">
</td>

<td>
<a class="edit" href="editProduct.php?id=<?php echo $product['id']; ?>">Edit</a>

<a class="delete" href="deleteProduct.php?id=<?php echo $product['id']; ?>"
onclick="return confirm('Delete this product?')">Delete</a>
</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</body>
</html>