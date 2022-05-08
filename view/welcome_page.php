<?php include_once './view/header.php'; ?>

<main>
    <br>
    <fieldset>
        <h3>All Posts</h3>
        <ul>
            <?php
            if (isset($posts)) {
                foreach ($posts as $post) {
                    $user = accountDB::getUserByID($post['accountID']);
                    echo "<li>";
                    if ($post['postUpdate'] != null) { echo "(edited)<br>"; }
                    echo "<Strong>Title:</Strong> ", $post['title'], "<br>";
                    echo "<Strong>Message:</Strong> ", $post['message'], "<br>";
                    echo "<Strong>Date:</Strong> ", date("m-d-Y H:i:s", strtotime($post['postDate'])), "<br>";
                    echo "<Strong>By:</Strong> ", $user['username'];
                    echo "</li>";
                }
            }
            ?>
        </ul>
    </fieldset>
</main>

<?php include './view/footer.php'; ?>