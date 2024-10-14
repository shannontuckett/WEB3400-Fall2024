<?php
// Step 1: Include config.php file

// Step 2: Secure and only allow 'admin' users to access this page

/* Step 3: You can use your completed `register.php` page as a guide for this page. However, you must remove the unused fields from the form handler and add a handler for the user role field; if the email already exists, redirect back to `user_add.php`, displaying the message "That email already exists. Please choose another." You must also update the SQL INSERT statement, and when the record is successfully created, redirect back to the `users_manage.php` page with the message "The user account for $full_name was created. They will need to login to activate their account."
*/
?>

<!-- BEGIN YOUR CONTENT -->
<section class="section">
    <h1 class="title">Add User</h1>
    <form action="user_add.php" method="post">
        <!-- Full Name -->
        <div class="field">
            <label class="label">Full Name</label>
            <div class="control">
                <input class="input" type="text" name="full_name" required>
            </div>
        </div>
        <!-- Email -->
        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" name="email" required>
            </div>
        </div>
        <!-- Password -->
        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" type="password" name="password" required>
            </div>
        </div>
        <!-- Phone -->
        <div class="field">
            <label class="label">Phone</label>
            <div class="control">
                <input class="input" type="tel" name="phone">
            </div>
        </div>
        <!-- Role -->
        <div class="field">
            <label class="label">Role</label>
            <div class="control">
                <div class="select">
                    <select name="role">
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                        <option value="user" selected>User</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Submit -->
        <div class="field is-grouped">
            <div class="control">
                <button type="submit" class="button is-link">Add User</button>
            </div>
            <div class="control">
                <a href="users_manage.php" class="button is-link is-light">Cancel</a>
            </div>
        </div>
    </form>
</section>
<!-- END YOUR CONTENT -->