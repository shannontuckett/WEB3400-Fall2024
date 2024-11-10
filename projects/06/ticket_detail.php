<?php
// Include config.php file
include 'config.php';

// Secure and only allow 'admin' users to access this page
if (!isset($_SESSION['loggedin']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect user to login page or display an error message
    $_SESSION['messages'][] = "You must be an administrator to access that resource.";
    header('Location: login.php');
    exit;
}
// Check if the $_GET['id'] exists; if it does, get the ticket record from the database and store it in the associative array named $ticket.
if (isset($_GET['id'])) {
    $ticket = $_GET['id'];

    // Retrieve the ticket record from the database
    $stmt = $pdo->prepare("SELECT * FROM `tickets` WHERE `id` = ?");
    $stmt->execute([$_GET['id']]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no ticket with the specified ID is found, display an error
    if (!$ticket) {
        $_SESSION['messages'][] = 'A ticket with that ID does not exist.';
        exit();
    }
}
// Fetch comments for the ticket
$comments = [];
if ($ticket) {
    // Prepare and execute the SQL statement to fetch comments associated with the ticket
    $stmt = $pdo->prepare("SELECT * FROM ticket_comments WHERE ticket_id = ? ORDER BY created_at ASC");
    $stmt->execute([$_GET['id']]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Update ticket status when the user clicks the status link
if (isset($_POST['status']) && in_array($_POST['status'], ['Open', 'In Progress', 'Closed'])) {
    $new_status = $_POST['status'];

    // Prepare and execute the SQL statement to update the ticket status
    $stmt = $pdo->prepare("UPDATE tickets SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$new_status, $ticket_id]);

    // Redirect to the ticket page after updating the status
    header("Location: ticket_details.php?id=$ticket_id");
    exit;
}

// Check if the comment form has been submitted. If true, then INSERT the ticket comment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $comment_text = trim($_POST['comment']);

    // Check that the comment text is not empty
    if (!$comment_text) {
        // Prepare and execute the SQL statement to insert the new comment
        $stmt = $pdo->prepare("INSERT INTO ticket_comments (ticket_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$ticket_id, $_SESSION['user_id'], $comment_text]);

        // Redirect to the same page to display the new comment
        header('Location: ticket_details.php');
        exit;
    }
}

?>

<?php include 'templates/head.php'; ?>
<?php include 'templates/nav.php'; ?>

<!-- BEGIN YOUR CONTENT -->
<section class="section">
    <h1 class="title">Ticket Detail</h1>
    <p class="subtitle">
        <a href="tickets.php">View all tickets</a>
    </p>
    <div class="card">
        <header class="card-header">
            <p class="card-header-title">
                <?= htmlspecialchars($ticket['title'], ENT_QUOTES) ?>
                &nbsp;
                <?php if ($ticket['priority'] == 'Low') : ?>
                    <span class="tag"><?= $ticket['priority'] ?></span>
                <?php elseif ($ticket['priority'] == 'Medium') : ?>
                    <span class="tag is-warning"><?= $ticket['priority'] ?></span>
                <?php elseif ($ticket['priority'] == 'High') : ?>
                    <span class="tag is-danger"><?= $ticket['priority'] ?></span>
                <?php endif; ?>
            </p>
            <button class="card-header-icon">
                <a href="ticket_detail.php?id=<?= $ticket['id'] ?>">
                    <span class="icon">
                        <?php if ($ticket['status'] == 'Open') : ?>
                            <i class="far fa-clock fa-2x"></i>
                        <?php elseif ($ticket['status'] == 'In Progress') : ?>
                            <i class="fas fa-tasks fa-2x"></i>
                        <?php elseif ($ticket['status'] == 'Closed') : ?>
                            <i class="fas fa-times fa-2x"></i>
                        <?php endif; ?>
                    </span>
                </a>
            </button>
        </header>
        <div class="card-content">
            <div class="content">
                <time datetime="2016-1-1">Created: <?= date('F dS, G:ia', strtotime($ticket['created_at'])) ?></time>
                <br>
                <p><?= htmlspecialchars($ticket['description'], ENT_QUOTES) ?></p>
            </div>
        </div>
        <footer class="card-footer">
            <a href="ticket_detail.php?id=<?= $ticket['id'] ?>&status=Closed" class="card-footer-item">
                <span class="icon"><i class="fas fa-times fa-2x"></i></span>
                <span>&nbsp;Close</span>
            </a>
            <a href="ticket_detail.php?id=<?= $ticket['id'] ?>&status=In Progress" class="card-footer-item">
                <span><i class="fas fa-tasks fa_2x"></i></i></span>
                <span>&nbsp;In Progress</span>
            </a>
            <a href="ticket_detail.php?id=<?= $ticket['id'] ?>&status=Open" class="card-footer-item">
                <span><i class="far fa-clock fa-2x"></i></span>
                <span>&nbsp;Re-Open</span>
            </a>
        </footer>
    </div>
    <hr>
    <div class="block">
        <form action="" method="post">
            <div class="field">
                <label class="label"></label>
                <div class="control">
                    <textarea name="msg" class="textarea" placeholder="Enter your comment here..." required></textarea>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-link">Post Comment</button>
                </div>
            </div>
        </form>
        <hr>
        <div class="content">
            <h3 class="title is-4">Comments</h3>
            <?php foreach ($comments as $comment) : ?>
                <p class="box">
                    <span><i class="fas fa-comment"></i></span>
                    <?= date('F dS, G:ia', strtotime($comment['created_at'])) ?>
                    <br>
                    <?= nl2br(htmlspecialchars($comment['comment'], ENT_QUOTES)) ?>
                    <br>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- END YOUR CONTENT -->
<?php include 'templates/footer.php'; ?>