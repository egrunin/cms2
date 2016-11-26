<?php
// auth check 
require('auth.php');
// set title and show header
$page_title = 'Schedule Maintenance';
require('header.php'); ?>

<?php
// initialize an empty id variable
$maintenance_id = null;
$product_id = null;
$preferred_time = null;

//check if we have a maintenance ID in the querystring
if ((!empty($_GET['maintenance_id'])) && (is_numeric($_GET['maintenance_id']))) {

    //if we do, store in a variable
    $maintenance_id = $_GET['maintenance_id'];

    //connect
    require('db.php'); 

    //select all the data for the selected maintenance
    $sql = "SELECT * FROM maintenances WHERE maintenance_id = :maintenance_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':maintenance_id', $maintenance_id, PDO::PARAM_INT);
    $cmd->execute();
    $maintenances = $cmd->fetchAll();

    //disconnect
    $conn = null;

    //store each value from the database into a variable
    foreach ($maintenances as $maintenance) {
        $product_id = $maintenance['product_id'];
        $preferred_time = $maintenance['preferred_time'];
    }
}

?>
    <h1>Choose ID and preferred maintenance time</h1>
	
    <form method="post" action="save-maintenance.php">
        <fieldset>
            <label for="product_id">Select your Product ID:</label>
            <select name="product_id" id="product_id">
                <?php
                // connect to 'registrants' sql database to retrieve names
                require('db.php');
                
                // prepare query 
                $sql = "SELECT product_id FROM registrants ORDER BY product_id DESC";
                $cmd = $conn -> prepare($sql);
                
                // run query & store results 
                $cmd -> execute();
                $registrants = $cmd -> fetchAll();
                
                // loop through the results and add each registrant's product Id to dropdown
                foreach ($registrants as $registrant) {
                    echo '<option>' . $registrant['product_id'] . '</option>';
                }
                
                // disconnect
                $conn = null;
                ?>
            </select>
        </fieldset>
        <fieldset>
            <label for="time" class="col-sm-3">Preferred time: *</label>
            <input name="preferred_time" id="preferred_time" required placeholder="date/time" value="<?php echo $preferred_time; ?>"/>
        </fieldset>
    
        <button class="btn btn-primary">Submit</button>   
    </form>
    
<?php require('footer.php');?>