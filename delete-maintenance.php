<?php ob_start();
require('auth.php'); ?>

<?php
try {
    // identify the record the user wants to delete
    $maintenance_id = null;
    $maintenance_id = $_GET['maintenance_id'];

    if (is_numeric($maintenance_id)) {
        // connect
        require('db.php'); 

        // prepare and execute the SQL DELETE command
        $sql = "DELETE FROM maintenances WHERE maintenance_id = :maintenance_id";

        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':maintenance_id', $maintenance_id, PDO::PARAM_INT);
        $cmd->execute();

        // disconnect
        $conn = null;

        // redirect back to the updated maintenancelist.php
        header('location:maintenancelist.php');
    }
}
catch (Exception $e) {
    mail('jack.grunin@gmail.com', 'Product X Error', $e);
    header('location:error.php');
}

ob_flush(); ?>