<?php ob_start();
// auth check 
require('auth.php'); ?>

<!DOCTYPE html>
    <html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="content-type">
        <title>Registration Saved</title>
    </head>
<body>
    
<?php 

try {
        // initialize variables
        $firstName = null;
        $lastName = null;
        $company_name = null;
        $product_id = null;
        $email = null;
        $registrant_id = null;
        
        // Store form inputs in variables
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $company_name = $_POST['company_name'];
        $product_id = $_POST['product_id'];
        $email = $_POST['email'];
        $registrant_id = $_POST['registrant_id'];
        
        // validate every input
        
        $ok = true;

        if (empty($firstName)){
            echo 'First Name is required<br />';
            $ok = false;
        }
        if (empty($lastName)){
            echo 'Last Name is required<br />';
            $ok = false;
        }
        
        if (empty($company_name)){
            echo 'Business name required<br />';
            $ok = false;
        }
        
        if ((empty($product_id)) || (!is_numeric($product_id)) || ($product_id < 0)) {
            echo 'Product ID required and must be 0 or greater<br />';
            $ok = false;
        }
        
        if (empty($email)){
            echo 'Email is required<br />';
            $ok = false;
        }
        
        //check if the form is ok to save 
        if ($ok == true) {
        
            // CONNECT to the db
            require('db.php');
                
            // set up the SQL command to save the data
                if (empty($registrant_id)) {
                    $sql = "INSERT INTO registrants (firstName, lastName, company_name, product_id, email) 
                VALUES (:firstName, :lastName, :company_name, :product_id, :email)";
                }
                else {
                    $sql = "UPDATE registrants SET firstName = :firstName, lastName = :lastName, company_name = :company_name,
                product_id = :product_id, email = :email WHERE registrant_id = :registrant_id";
                }
            
            // create a command object 
            $cmd = $conn->prepare($sql); 
            
            // input each value into the proper field 
            $cmd -> bindParam(':firstName', $firstName, PDO::PARAM_STR);
            $cmd -> bindParam(':lastName', $lastName, PDO::PARAM_STR);
            $cmd -> bindParam(':company_name', $company_name, PDO::PARAM_STR);
            $cmd -> bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $cmd -> bindParam(':email', $email, PDO::PARAM_STR);
            
            // add the registrant_id if available
                if (!empty($registrant_id)) {
                    $cmd -> bindParam(':registrant_id', $registrant_id, PDO::PARAM_INT);
                }
        
            // save 
            $cmd -> execute();
            
            // DISCONNECT
            $cmd = null;
            
            // redirect
            header('location:registrants.php');
        
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