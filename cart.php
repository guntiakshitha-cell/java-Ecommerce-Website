<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

include "../includes/db.php";

$user_id = $_SESSION['user_id'];

/* ADD TO CART */
if(isset($_POST['add_to_cart'])){

$product_id = $_POST['product_id'];

/* CHECK IF PRODUCT ALREADY EXISTS IN CART */

$stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id=? AND product_id=?");
$stmt->execute([$user_id,$product_id]);

if($stmt->rowCount() > 0){

/* IF PRODUCT EXISTS → INCREASE QUANTITY */

$conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id=? AND product_id=?")
     ->execute([$user_id,$product_id]);

}else{

/* IF PRODUCT NOT IN CART → INSERT */

$conn->prepare("INSERT INTO cart(user_id,product_id,quantity) VALUES(?,?,1)")
     ->execute([$user_id,$product_id]);

}

header("Location: cart.php");
exit();
}
/* REMOVE ITEM */
if(isset($_POST['remove_from_cart'])){
    $product_id = $_POST['product_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id=? AND product_id=?");
    $stmt->execute([$user_id,$product_id]);

    header("Location: cart.php");
    exit();
}

/* UPDATE QUANTITY */
if(isset($_POST['update_quantity'])){
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("UPDATE cart SET quantity=? WHERE user_id=? AND product_id=?");
    $stmt->execute([$quantity,$user_id,$product_id]);

    header("Location: cart.php");
    exit();
}

/* FETCH CART ITEMS WITH PRODUCT DETAILS */
$stmt = $conn->prepare("
SELECT cart.quantity, products.id, products.name, products.price, products.image
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id = ?
");

$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_cost = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Cart</title>
<style>
    

body{
font-family: Arial, sans-serif;
background:#f4f6f9;
margin:0;
padding:0;
}

.container{
width:90%;
max-width:1000px;
margin:40px auto;
background:white;
padding:30px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

h2{
text-align:center;
margin-bottom:30px;
}

.cart-item{
display:flex;
align-items:center;
justify-content:space-between;
border-bottom:1px solid #ddd;
padding:15px 0;
}

.cart-item img{
width:90px;
}

.item-details{
flex:1;
margin-left:20px;
}

.item-name{
font-size:18px;
font-weight:bold;
}

.item-price{
color:#555;
margin-top:5px;
}

.actions{
display:flex;
gap:10px;
align-items:center;
}

input[type="number"]{
width:60px;
padding:5px;
}

button{
background:#007bff;
border:none;
color:white;
padding:8px 12px;
border-radius:5px;
cursor:pointer;
}

button:hover{
background:#0056b3;
}

.remove-btn{
background:#dc3545;
}

.remove-btn:hover{
background:#b02a37;
}

.total{
text-align:right;
font-size:20px;
font-weight:bold;
margin-top:20px;
}

.checkout{
display:flex;
justify-content:space-between;
margin-top:30px;
}

.checkout a{
text-decoration:none;
background:#28a745;
color:white;
padding:10px 18px;
border-radius:5px;
}

.checkout a:hover{
background:#218838;
}

</style>

</head>
<body>
<div class="container">
<h2>Your Cart</h2>

<?php if(empty($cart_items)): ?>
<p>Your cart is empty</p>
<a href="../index.php">Continue Shopping</a>

<?php else: ?>

<?php foreach($cart_items as $item): ?>

<?php $total_cost += $item['price'] * $item['quantity']; ?>

<div class="cart-item">

<img src="../images/<?php echo $item['image']; ?>" width="100">
<div class="item-details">
    <div class="item-name"><?php echo $item['name']; ?></div>
    <div class="iem-price">price: $<?php echo $item['price']; ?></div>
    </div>
    <div class="actions">
<

<form method="POST">
<input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
<input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
<button type="submit" name="update_quantity">Update</button>
</form>

<form method="POST">
<input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
<button class="remove-btn" type="submit" name="remove_from_cart">Remove</button>
</form>

</div>
</div>


<?php endforeach; ?>
<div class="total">
     Total: $<?php echo $total_cost; ?>
     </div> 
     <div class="checkout"> 
        <a href="../index.php">Continue Shopping</a>
         <a href="checkout.php">Checkout</a> </div>


<?php endif; ?>

</body>
</html>
</div>