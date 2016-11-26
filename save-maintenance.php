<?php ob_start();
require('auth.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <title>Maintenance Saved</title>
</head>
<body>
    
<?php 

try {
    // initialize variables
    $product_id = null;
    $preferred_time = null;
    $maintenance_id = null;
    
    // Store form inputs in variables
    $product_id = $_POST['product_id'];
    $preferred_time = $_POST['preferred_time'];
    $maintenance_id = $_POST['maintenance_id'];
    
	// validate every input
    $ok = true;

	if (empty($product_id)){
		echo 'Product ID is required<br />';
		$ok = false;
	}
	
	if (empty($preferred_time)){
		echo 'Date and Time required<br />';
		$ok = false;
	}
	
	//check if the form is ok to save 
	if ($ok == true) {
        // CONNECT to the db
        require('db.php');
        
        // save the data
        if (empty($maintenance_id)) {
        $sql = "INSERT INTO maintenances (product_id, preferred_time) 
            VALUES (:product_id, :preferred_time)";
        }
        else {
            $sql = "UPDATE maintenances SET product_id = :product_id, preferred_time = :preferred_time WHERE maintenance_id = :maintenance_id";
        }
        // create a command object 
        $cmd = $conn->prepare($sql); 
        
        // input each value into the proper field 
        $cmd -> bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $cmd -> bindParam(':preferred_time', $preferred_time, PDO::PARAM_STR);
        
        // add the maintenance id if one exists
        if (!empty($maintenance_id)) {
            $cmd -> bindParam(':maintenance_id', $maintenance_id, PDO::PARAM_INT);
        }
    
        // save 
        $cmd -> execute();
        
        // DISCONNECT
        $cmd = null;
        
        //redirect
        header('location:maintenancelist.php');
	}
}

catch (Exception $e) {
    mail('jack.grunin@gmail.com', 'Registration Error', $e);
    header('location:error.php');
}
?>
</body>
</html>

<?php ob_flush(); ?>