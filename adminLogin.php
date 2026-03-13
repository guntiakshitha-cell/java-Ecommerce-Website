<?php
session_start();
include "../includes/db.php";

$error="";

if(isset($_POST['admin_login'])){

$email=$_POST['email'];
$password=$_POST['password'];

$stmt=$conn->prepare("SELECT * FROM users WHERE email=? AND role='admin'");
$stmt->execute([$email]);

$admin=$stmt->fetch(PDO::FETCH_ASSOC);




if($admin && $password == $admin['password']){
$_SESSION['admin_id']=$admin['id'];
header("Location: adminDashboard.php");
exit();
}
else{
$error="Invalid Admin Credentials";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>

<style>
body{
font-family:Arial;
background:#f2f4f7;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
margin:0;
}

.login-box{
background:white;
padding:40px;
width:350px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
text-align:center;
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
background:#007bff;
border:none;
color:white;
border-radius:5px;
cursor:pointer;
}

.error{
color:red;
}
</style>
</head>

<body>

<div class="login-box">

<h2>Admin Login</h2>

<?php if($error!=""){ ?>
<p class="error"><?php echo $error; ?></p>
<?php } ?>

<form method="POST">

<input type="email" name="email" placeholder="Admin Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="admin_login">Login</button>

</form>

</div>

</body>
</html>