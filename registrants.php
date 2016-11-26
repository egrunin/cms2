<?php ob_start();
// auth check 
require('auth.php'); ?>

<?php
// set title
$page_title = 'Registrants';
require('header.php'); 

try {
    // connect
    require('db.php'); 

    // prepare the query
    $sql = "SELECT * FROM registrants";
    $cmd = $conn -> prepare($sql);

    // run the query and store the results
    $cmd -> execute();
    $registrants = $cmd -> fetchAll();

    // disconnect
    $conn = null;

    // start the grid with HTML
    echo '<table class="table"><thead><th>First Name</th><th>Last Name</th><th>Company Name</th>
                    <th>Product ID</th><th>Email</th><th>Edit</th><th>Delete</th></thead><tbody>';

    /* loop through the data, displaying each value in a new column
    and each registrant in a new row */
    foreach($registrants as $registrant) {
        echo '<tr><td>' . $registrant['firstName'] . '</td>
            <td>' . $registrant['lastName'] . '</td>
            <td>' . $registrant['company_name'] . '</td>
            <td>' . $registrant['product_id'] . '</td>
            <td>' . $registrant['email'] . '</td>
            <td><a href="registrant.php?registrant_id=' . $registrant['registrant_id'] . '" title="Edit">Edit</a></td>
            <td><a href="delete-registrant.php?registrant_id=' . $registrant['registrant_id'] . '" title="Delete" class="confirmation">Delete</a></td>
            </tr>';
    }

    // close the HTML grid
    echo '</tbody></table>';
}

catch (Exception $e) {
    // send IT Dep. an error email
    mail('jack.grunin@gmail.com', 'Product X ERROR', $e);
    
    // redirect to the error page
    header('location:404.php');
}

// footer
require('footer.php');

ob_flush(); ?>
