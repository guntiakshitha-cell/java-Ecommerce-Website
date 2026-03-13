<?php
include('../includes/db.php');  // Database connection
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve the user from the database based on the provided email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists AND if the provided password matches the stored hash
    if ($user && password_verify($password, $user['password'])) {
        
        // Login successful: Store user data in the session
        $_SESSION['user_id'] = $user['id']; // Assuming your user table's primary key is 'id'
        
        // You can optionally store other useful info, like their role
        // $_SESSION['role'] = $user['role']; 

        header("Location: ../index.php"); // Redirect to the homepage/dashboard
        exit();

    } else {
        // Generic error message for both invalid email or invalid password
        // (This is better for security so attackers don't know which part was wrong)
        echo "<script>alert('Invalid email or password!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Form</title>

<style>

body{
margin:0;
height:100vh;
display:flex;
justify-content:center;
align-items:center;

background:linear-gradient(to right,#8e2de2,#ff416c);

font-family:Arial;
}

.container{

background:white;
padding:40px;
border-radius:8px;
width:300px;
text-align:center;

}

h2{
margin-bottom:20px;
}

input{

width:100%;
padding:10px;
margin:10px 0;
border:1px solid #ccc;
border-radius:5px;

}

button{

width:100%;
padding:10px;
border:none;
background:#ff416c;
color:white;
font-size:16px;
border-radius:5px;

}

.link{

margin-top:10px;
font-size:14px;

}

a{
color:#ff416c;
text-decoration:none;
}

</style>

</head>

<body>

<div class="container">

<h2>Login Form</h2>

<form action="login.php" method="POST">

<input type="email" name="email" placeholder="Enter Email" autocomplete="off">

<input type="password" name="password" placeholder="Enter Password" autocomplete="current-password">

<button type="submit" name="login">Login</button>

</form>

<div class="link">

Not a member?
<a href="register.php">Register now</a>

</div>

</div>

</body>
</html>