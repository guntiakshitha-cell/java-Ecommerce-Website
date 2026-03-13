<?php
include('../includes/db.php');  // Database connection
session_start();
session_unset();

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT); // Hash the password
    $role = 'user'; // Default role for users

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    
if ($user) {
    header("Location: login.php?message=already_registered");
    exit();
}


    else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $role]);

        // Log the user in after successful registration
        $_SESSION['user_id'] = $conn->lastInsertId();
        header("Location: ../index.php"); // Redirect to the homepage
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Signup Form</title>

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

<h2>Register</h2>

<form method="POST" autocomplete="off">
    

<input type="text" name="username" placeholder="Username" autocomplete="off">

<input type="email" name="email" placeholder="Email Address" autocomplete="off">



<input type="password" name="password" placeholder="Password" autocomplete="new-password">

<button type="submit" name="register">Register</button>

</form>
<?php if(isset($error_message)): ?>
    <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
<?php endif; ?>


</div>

</body>
</html>