<?php
include 'config.php';

/*
  Get a user's Gravatar URL for their email address or a placeholder image if they do not have one
  This source code is from https://gravatar.com/site/implement/images/php/
*/
function get_gravatar($email, $s = 128, $d = 'mp', $r = 'g', $img = false, $atts = array())
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

try {
    // Get user info from the database
    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `id` = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    // Fetch user interactions along with article titles
    $stmt = $pdo->prepare('SELECT user_interactions.*, articles.title AS article_title FROM user_interactions JOIN articles ON user_interactions.article_id = articles.id WHERE user_id = ? ORDER BY user_interactions.created_at DESC');
    $stmt->execute([$_SESSION['user_id']]);
    $interactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Handle any database errors (optional)
    die("Database error occurred: " . $e->getMessage());
}

?>
<?php include 'templates/head.php'; ?>
<?php include 'templates/nav.php'; ?>

<!-- BEGIN YOUR CONTENT -->
<section class="section">
    <h1 class="title">Profile</h1>
    <div class="card">
        <div class="card-content">
            <div class="media">
                <div class="media-left">
                    <figure class="image is-128x128">
                        <img class="is-rounded" src="<?= get_gravatar($user['email']) ?>" alt="<?= $user['full_name'] ?> profile image">
                    </figure>
                </div>
                <div class="media-content">
                    <p class="title"><?= $user['full_name'] ?> | <span class="tag is-info is-medium"><?= $user['role'] ?></span></p>
                    <p class="subtitle"><?= $user['email'] ?></p>
                    <p class="subtitle"><?= $user['phone'] ?></p>
                </div>
            </div>

            <div class="content">
                <p><?= $user['user_bio'] ?></p>
                Account created: <time datetime="2016-1-1"><?= $user['created_on'] ?></time><br>
                Account updated: <time datetime="2016-1-1"><?= $user['modified_on'] ?></time><br>
                Last login: <time datetime="2016-1-1"><?= $user['last_login'] ?></time>
            </div>
        </div>
        <footer class="card-footer">
            <a href="profile_update.php" class="card-footer-item">Edit</a>
        </footer>
    </div>
</section>

<!-- My interactions section -->
<section class="section">
  <h2 class="title is-4">My Interactions</h2>
  <?php foreach ($interactions as $interaction) : ?>
  <div class="box">
    <article class="media">
      <div class="media-content">
        <div class="content">
          <p>
            <strong><?= ucfirst($interaction['interaction_type']) ?>:</strong>
            <?php if ($interaction['interaction_type'] === 'comment') : ?>
            <a href="article.php?id=<?= $interaction['article_id'] ?>"><?= $interaction['article_title'] ?></a>
            <?php else : ?>
            <a href="article.php?id=<?= $interaction['article_id'] ?>"><?= $interaction['article_title'] ?></a>
            <?php endif; ?>
            <br>
            <small><?= time_ago($interaction['created_at']) ?></small>
          </p>
        </div>
      </div>
    </article>
  </div>
  <?php endforeach; ?>
</section>

<!-- END YOUR CONTENT -->

<?php include 'templates/footer.php'; ?>