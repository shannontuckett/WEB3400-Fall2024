<?php
// Include config.php file

// Secure and only allow 'admin' users to access this page

// Prepared statement that retrieves all the tickets in descending order by creation date from the tickets table

// Execute the query

// Fetch and store the results in the $tickets associative array

// Check if the query returned any rows. If not, display the message: "There are no tickets in the database."

?>

<!-- BEGIN YOUR CONTENT -->
<section class="section">
    <h1 class="title">Manage Tickets</h1>
    <!-- Add Ticket Button -->
    <div class="buttons">
        <a href="ticket_create.php" class="button is-link">Create a new ticket</a>
    </div>
    <div class="row columns is-multiline">
        <?php foreach ($tickets as $ticket) : ?>
            <div class="column is-4">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            <?= htmlspecialchars_decode(substr($ticket['title'], 0, 30), ENT_QUOTES) ?>
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
                            <time datetime="2016-1-1">Created: <?= time_ago($ticket['created_at']) ?></time>
                            <br>
                            <p><?= htmlspecialchars_decode(substr($ticket['description'], 0, 40), ENT_QUOTES) ?>...</p>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <a href="ticket_detail.php?id=<?= $ticket['id'] ?>" class="card-footer-item">View</a>
                        <a href="ticket_edit.php?id=<?= $ticket['id'] ?>" class="card-footer-item">Edit</a>
                        <a href="ticket_delete.php?id=<?= $ticket['id'] ?>" class="card-footer-item">Delete</a>
                    </footer>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<!-- END YOUR CONTENT -->
