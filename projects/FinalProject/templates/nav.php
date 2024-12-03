<!-- BEGIN PAGE HEADER -->
<header class="container">

<!-- BEGIN MAIN NAV -->
<nav class="navbar is-fixed-top is-spaced has-shadow is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
            <span class="icon-text">
                <span class="icon">
                <i class="fas fa-sun fa-lg" style="color: #63E6BE;"></i>
                </span>
                <span>&nbsp;<?= $siteName ?></span>
            </span>
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-start">
            <!-- BEGIN ADMIN MENU -->
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['user_role'] == 'admin') : ?>
    <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
            <span class="icon">
                <i class="fas fa-user-cog"></i>
            </span>
            <span>Admin</span>
        </a>
        <div class="navbar-dropdown">
            <a href="admin_dashboard.php" class="navbar-item">
                Admin Dashboard
            </a>
            <a href="users_manage.php" class="navbar-item">
                Manage Users
            </a>
            <a href="articles.php" class="navbar-item">
                Manage Articles
        </a>
        <a href="tickets.php" class="navbar-item">
                Manage Tickets
        </a> 
                       
        </div>
    </div>
<?php endif; ?>
<!-- END ADMIN MENU -->
        </div>
        <div class="navbar-end">
            <!-- <a class="navbar-item" href="#">Contact Us</a>
            <a class="navbar-item" href="#">Login</a> -->
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-light" href="contact.php">
                        <strong>Contact us</strong>
                    </a>
                    <?php if (isset($_SESSION['loggedin'])) : ?>
                        <a class="button is-light" href="ticket_create.php">
                        <strong>Support</strong>
                        </a>
                    <?php endif; ?>
                    <!-- BEGIN USER MENU -->
                    <?php if (isset($_SESSION['loggedin'])) : ?>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="button navbar-link">
                                <span class="icon">
                                <i class="fas fa-user"></i>
                                </span>
                            </a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="profile.php">Profile</a>
                                <hr class="navbar-divider">
                                <a  class="navbar-item" href="logout.php">Logout</a>
                            </div>
                        </div>
                    <?php else : ?>
                        <a href="login.php" class="button is-link">Login</a>
                    <?php endif; ?>
                    <!-- END USER MENU -->
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- END MAIN NAV -->

   <!-- Optional spacing for styling -->
   <section class="block">&nbsp;</section>
    <section class="block">&nbsp;</section>

<section class="block">
<?php if ($_SERVER['PHP_SELF'] == '/index.php') : ?>
  <!-- BEGIN HERO -->
  <section class="hero is-info">
            <div class="hero-body">
                <p class="title"> 
                    Do you feel like something is missing from your life?
                </p>
                <p class="subtitle">
                Join us to learn all about finding happiness from within...
                </p>
                <a href="contact.php" class="button is-medium is-info is-light is-rounded <?= $_SERVER['PHP_SELF'] === '/contact.php' ? 'is-active' : '' ?>">
                    <span class="icon is-large">
                        <i class="fab fa-2x fa-pagelines"></i>
                    </span>
                    <span>Reach out to a Happiness Guru to start your journey now!</span>
                </a>
            </div>
        </section>
    <?php endif; ?>

    <!-- Notifications Section -->
    <?php if (!empty($_SESSION['messages'])) : ?>
        <section class="notification is-warning">
            <button class="delete"></button>
            <?php foreach ($_SESSION['messages'] as $message) : ?>
                <p><?= htmlspecialchars($message, ENT_QUOTES) ?></p>
            <?php endforeach; ?>
            <?php $_SESSION['messages'] = []; // Clear the messages ?>
        </section>
    <?php endif; ?>
</header>
<!-- END PAGE HEADER -->