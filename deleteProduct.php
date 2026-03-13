<?php
session_start();

if(!isset($_SESSION['admin_id'])){
header("Location: adminLogin.php");
exit();
}

include "../includes/db.php";

$id=$_GET['id'];

$stmt=$conn->prepare("DELETE FROM products WHERE id=?");
$stmt->execute([$id]);

header("Location: adminDashboard.php");
exit();
?>