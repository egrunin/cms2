<?php ob_start();

// authenticate
require('auth.php');

// set title and show header
$page_title = 'Register';
require('header.php'); ?>


<?php
// initialize an empty id variable
$registrant_id = null;
$firstName = null;
$lastName = null;
$company_name = null;
$product_id = null;
$email = null;

//check for a registrant ID in the querystring
if ((!empty($_GET['registrant_id'])) && (is_numeric($_GET['registrant_id']))) {

    //if yes, store in a variable
    $registrant_id = $_GET['registrant_id'];

    //connect
    require('db.php'); 

    //select all the data for the selected registrant
    $sql = "SELECT * FROM registrants WHERE registrant_id = :registrant_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':registrant_id', $registrant_id, PDO::PARAM_INT);
    $cmd->execute();
    $registrants = $cmd->fetchAll();

    //disconnect
    $conn = null;

    //store each value from the database into a variable
    foreach ($registrants as $registrant) {
        $firstName = $registrant['firstName'];
        $lastName = $registrant['lastName'];
        $company_name = $registrant['company_name'];
        $product_id = $registrant['product_id'];
        $email = $registrant['email'];
    }
}
?>
    
    <h1>Registration Information</h1>
	
    <form method="post" action="save-registrant.php">
        <fieldset>
            <label for="firstName" class="col-sm-3">First Name: *</label>
            <input name="firstName" id="firstName" required placeholder="John" value="<?php echo $firstName; ?>" />
        </fieldset>
        <fieldset>
            <label for="lastName" class="col-sm-3">Last Name: *</label>
            <input name="lastName" id="lastName" required placeholder="Doe" value="<?php echo $lastName; ?>" />
        </fieldset>
        <fieldset>
            <label for="company_name" class="col-sm-3">Company Name: *</label>
            <input name="company_name" id="company_name" required placeholder="Your Business Name" value="<?php echo $company_name; ?>" />
        </fieldset>
        <fieldset>
            <label for="product_id" class="col-sm-3">Product ID: *</label>
            <input name="product_id" id="product_id" required placeholder="#123456" value="<?php echo $product_id; ?>" />
        </fieldset>
        <fieldset>
            <label for="email" class="col-sm-3">Email: *</label>
            <input name="email" id="email" required placeholder="email@host.com" value="<?php echo $email; ?>" />
        </fieldset>
        <input type="hidden" name="registrant_id" id="registrant_id" value="<?php echo $registrant_id; ?>" />
        <button class="btn btn-primary col-sm-offset-2">Save</button>   
    </form>
    
<?php require('footer.php');
ob_flush ?>
