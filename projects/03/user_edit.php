<?php
// Step 1: Include config.php file
include 'config.php';

// Step 2: Secure and only allow 'admin' users to access this page
if (!isset($_SESSION['loggedin']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect user to login page or display an error message
    $_SESSION['messages'][] = "You must be an administrator to access that resource.";
    header('Location: login.php');
    exit;
}

// Step 3: Check if the update form was submitted. If so, update user details. Similar steps as in user_add.php but with an UPDATE SQL query
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract, sanitize user input, and assign data to variables
    $full_name = htmlspecialchars($_POST['full_name']);
    $phone = htmlspecialchars($_POST['phone']);
    $role = htmlspecialchars($_POST['role']);

    // Update user records
    $insertStmt = $pdo->prepare("UPDATE `users` SET `full_name`=?,`phone`=?, `role`=? WHERE `id` = ?");
    $insertStmt->execute([$full_name, $phone, $role, $_POST['id']]);
}

// Step 4: Else it's an initial page request, fetch the user's current data from the database by preparing and executing a SQL statement that uses the user gets the user id from the query string (ex. $_GET['id'])
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

     // Prepare and execute the SELECT query to fetch the user data
     $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `id` = ?");
     $stmt->execute([$user_id]);
     $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<?php include 'templates/head.php'; ?>
<?php include 'templates/nav.php'; ?>

<!-- BEGIN YOUR CONTENT -->
<section class="section">
    <h1 class="title">Edit User</h1>
    <form action="" method="post">
        <!-- ID -->
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <!-- Full Name -->
        <div class="field">
            <label class="label">Full Name</label>
            <div class="control">
                <input class="input" type="text" name="full_name" value="<?= $user['full_name'] ?>" required>
            </div>
        </div>
        <!-- Email -->
        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" name="email" value="<?= $user['email'] ?>" disabled>
            </div>
        </div>
        <!-- Password -->
        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" type="password" value="XXXXXXXX" name="password" disabled>
            </div>
        </div>
        <!-- Phone -->
        <div class="field">
            <label class="label">Phone</label>
            <div class="control">
                <input class="input" type="tel" value="<?= $user['phone'] ?>" name="phone">
            </div>
        </div>
        <!-- Bio -->
        <div class="field">
            <label class="label">User Bio</label>
            <div class="control">
                <textarea class="textarea" name="user_bio" disabled><?= $user['user_bio'] ?></textarea>
            </div>
        </div>
        <!-- Role -->
        <div class="field">
            <label class="label">Role</label>
            <div class="control">
                <div class="select">
                    <select name="role">
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="editor" <?= $user['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Submit -->
        <div class="field is-grouped">
            <div class="control">
                <button type="submit" class="button is-link">Update User</button>
            </div>
            <div class="control">
                <a href="users_manage.php" class="button is-link is-light">Cancel</a>
            </div>
        </div>
    </form>
</section>
<!-- END YOUR CONTENT -->

<?php include 'templates/footer.php'; ?>