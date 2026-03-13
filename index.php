<?php
session_Start();
if(isset($_POST['logout'])){
    session_destroy();
    header("Location: pages/login.php");
    exit();
}


if(!isset($_SESSION['user_id'])){
    header("Location: pages/login.php");
    exit();
}
include 'includes/db.php';
$stmt=$conn->query('SELECT * FROM products');
$products=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>My Shop</title>
        
        <style>
        body{
    font-family:Arial;
    text-align:center;
    
    margin:0;
}
h1{
    text-align:center;
}
header{
    background:#2f4054;
    color:white;
    padding:20px 50px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    
}
nav a{
    color:white;
    margin-left:20px;
    text-decoration:none;
    
}
.products{
    display:flex;
    justify-content:center;
    gap:30px;
    margin-top:40px;
}
.product{
    background:white;
    width:220px;     
    padding:20px;   
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1); 
    text-align:center; 
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    height:320px; 
}
.product img{
    width:120px;
    height:120px;
    display:block;
    margin:auto;
    object-fit:contain;
}

button{
    background-color:#2ecc71;
    border:none;
    color:white;
    padding:10px 15px;
    cursor:pointer;
    border-radius:5px;
    margin-top:10px;
}
.product button{
    margin-top:auto;
background:#2ecc71;
border:none;
padding:10px;
color:white;
border-radius:5px;
cursor:pointer;
}
</style>

        
    </head>
    <body>
        <header>
            <h1>Welcome to our Store</h1>
            <nav>

<a href="pages/cart.php">🛒 Cart</a>

<?php if(isset($_SESSION['user_id'])): ?>

<form method="POST" style="display:inline;">
<button type="submit" name="logout">Logout</button>
</form>

<?php else: ?>

<a href="pages/login.php">Login</a>
<a href="pages/register.php">Register</a>

<?php endif; ?>

</nav>
        </header>
        <h2>Products</h2>
        <div class="products">

        
            
                <?php if(empty($products)) : ?>
                    <p>No products available.</p>
                    <?php else: ?>
                        <?php foreach ($products as $product) : ?>
                            <div class="product">
                                <h3><?=htmlspecialchars($product['name']); ?>
                                </h3>
                                <p>price: $<?=number_format($product['price'],2); ?></p>
                                <p><?=htmlspecialchars($product['description']); ?></p>
                                <?php if(!empty($product['image'])) : ?>
                                    <img src="images/<?=htmlspecialchars($product['image']); ?>" alt="<?=htmlspecialchars($product['name']);?>">
                                    <?php endif; ?>
                                    <form method="POST" action="pages/cart.php">
                                        <input type="hidden" name="product_id" value="<?=$product['id']; ?>">
                                        <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
                                    </form>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
 

                    
    </body>
</html>                