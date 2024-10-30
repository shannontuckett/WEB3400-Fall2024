<?php
include 'config.php'; // Ensure this is at the top to use PDO for database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare statement to avoid SQL injection
    $stmt = $pdo->prepare("INSERT INTO contact_us (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);

    // Redirect or display a success message
    $_SESSION['messages'][] = 'Thank you for contacting us!';
    header('Location: contact.php');
    exit;
}
?>

<?php include 'templates/head.php'; ?>
<?php include 'templates/nav.php'; ?>

    <!-- BEGIN YOUR CONTENT -->
     
<section class="section">
    <h1 class="title">Contact Us</h1>
    <form class="box" action="contact.php" method="post">
        <div class="field">
            <label class="label">Your Name</label>
            <div class="control has-icons-left">
                <span class="icon is-left">
                    <i class="fas fa-user"></i>
                </span>
                <input class="input" type="text" name="name" placeholder="Bob Smith" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Your Email</label>
            <div class="control has-icons-left">
                <span class="icon is-left">
                    <i class="fas fa-at"></i>
                </span>
                <input class="input" type="email" name="email" placeholder="bsmith@email.com" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Your message to us</label>
            <div class="control">
                <textarea class="textarea" name="message" required></textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button class="button is-primary">Send Message</button>
            </div>
        </div>
    </form>
</section>
<section class="section">
    <h3 class="title">Or give us a call at</h3>
    <a class="button is-link" href="tel:<?= $contactPhone ?>">
        <span class="icon">
            <i class="fas fa-phone"></i>
        </span>
        <span><?= $contactPhone ?></span>
    </a>
</section>

    <!-- END YOUR CONTENT -->

<?php include 'templates/footer.php'; ?>