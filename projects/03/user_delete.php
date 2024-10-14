<?php
// Step 1: Include config.php file

// Step 2: Secure and only allow 'admin' users to access this page

// Step 3: Check if the $_GET['id'] exists; if it does, get the user the record from the database and store it in the associative array $user. If a user record with that ID does not exist, display the message "A user with that ID did not exist."

// Step 4: Check if $_GET['confirm'] == 'yes'. This means they clicked the 'yes' button to confirm the removal of the record. Prepare and execute a SQL DELETE statement where the user id == the $_GET['id']. Else (meaning they clicked 'no'), return them to the users_manage.php page.

?>

<!-- BEGIN YOUR CONTENT -->
<section class="section">
    <h1 class="title">Delete User Account</h1>
    <p class="subtitle">Are you sure you want to delete the user: <?= $user['full_name'] ?></p>
    <div class="buttons">
        <a href="?id=<?= $user['id'] ?>&confirm=yes" class="button is-success">Yes</a>
        <a href="?id=<?= $user['id'] ?>&confirm=no" class="button is-danger">No</a>
    </div>
</section>
<!-- END YOUR CONTENT -->