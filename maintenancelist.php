<?php ob_start();
require('auth.php'); ?>

<?php
// set title
$page_title = 'Maintenance Timetable';
require('header.php');

    try {
        // connect 
        require('db.php');
    
        // prep query 
        $sql = "SELECT * FROM maintenances ORDER BY product_id";
        $cmd = $conn -> prepare($sql);

        // run query and store results 
        $cmd -> execute();
        $maintenances = $cmd -> fetchAll();
        
        // disconnect
        $conn = null;

        // HTML grid 
        echo '<table class="table">
                <thead>
                    <th>Product ID</th>
                    <th>Preferred Time</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
            <tbody>';

            // loop through the data, displaying each value in a column and each maintenance in a new row
            foreach($maintenances as $maintenance) {
                echo '<tr><td>' . $maintenance['product_id'] . '</td>
                          <td>' . $maintenance['preferred_time'] . '</td>
                          <td><a href="maintenance.php?maintenance_id=' . $maintenance['maintenance_id'] . '" title="Edit">Edit</a></td>
                          <td><a href="delete-maintenance.php?maintenance_id=' . $maintenance['maintenance_id'] . '"title="Delete" class="confirmation">Delete</a></td>
                     </tr>';
            }

            // close grid 
            echo '</tbody></table>';
    }
        
        catch (Exception $e) {
        // send IT Dep. an error email
        mail('jack.grunin@gmail.com', 'Product X ERROR', $e);
    
        // redirect to the error page
        header('location:404.php');
        }
?>
     
<h3>Maintenance appointment reminder</h3>
<form method="post" action="email.php">
    <label for="registrant">EMAIL:</label>
    <select name="email" id="email">
        <?php
        // connect
        require('db.php');
        $sql = "SELECT email FROM registrants";
        $cmd = $conn -> prepare($sql);
        $cmd -> execute();
        $registrants = $cmd -> fetchAll();
        foreach ($registrants as $registrant ) {
            echo '<option>' . $registrant['email'] . '</option>';
        }
        // disconnect
        $conn = null;
        ?>
    </select>
    <button class="btn btn-primary">Send Email</button>
</form>

<?php 

// footer
require('footer.php');

ob_flush(); ?>
        
