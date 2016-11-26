<?php 
$page_title = 'Product X | Success!';
require('header.php');

// send user a reminder email

$email = $_POST['email'];
mail($email, 'Maintenance appointment REMINDER', 'Dont miss your appointment!',
    'From:rregtc@hotmail.com');
?>

<div class="jumbotron">
    <h1>Email Sent..</h1>
    <p>Check your mailbox!</p>
</div>

<?php require('footer.php'); ?>


