<?php
include 'includes/db.php';
if($conn){
    echo "Database connected successfully ";
    
}
else{
    echo "failed to connect to the database";
}
?>