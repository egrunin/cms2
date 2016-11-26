<?php ob_start();
// auth check 
require('auth.php'); ?>

<?php
try {
    // identify the record the user wants to delete
    $registrant_id = null;
    $registrant_id = $_GET['registrant_id'];

    if (is_numeric($registrant_id)) {
        // connect
        require('db.php'); 

        // prepare and execute the SQL DELETE command
        $sql = "DELETE FROM registrants WHERE registrant_id = :registrant_id";

        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':registrant_id', $registrant_id, PDO::PARAM_INT);
        $cmd->execute();

        // disconnect
        $conn = null;

        // redirect back to the updated registrants.php
        header('location:registrants.php');
    }
}
catch (Exception $e) {
    mail('jack.grunin@gmail.com', 'Product X Error', $e);
    header('location:error.php');
}

ob_flush(); ?>