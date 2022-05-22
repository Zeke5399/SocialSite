<?php include_once './view/header.php'; ?>

<main>
    <br>
    <fieldset>
        <?php include './view/post_filter_form.php'; ?>

        <h3>All Posts<?php
            if (isset($count)) {
                echo " - " . $count;
            }
            ?></h3>

        <?php
        if (isset($filterMode)) {
            for ($page = 1; $page <= $pages; $page++) {
                if ($page == $currentPage) {
                    echo "<a id='currentPage' href='./index.php?action=post-filter-action&page=". $page ."&filtermode=yes&title=". $title ."&postdate=". $postDate ."&beforeafter=". $beforeAfter ."'> $page </a>";
                } else {
                    echo "<a href='./index.php?action=post-filter-action&page=". $page ."&filtermode=yes&title=". $title ."&postdate=". $postDate ."&beforeafter=". $beforeAfter ."'> $page </a>";
                }
            }
        } else {
            for ($page = 1; $page <= $pages; $page++) {
                if ($page == $currentPage) {
                    echo "<a id='currentPage' href='./index.php?action=welcome_page&page=" . $page . "'> $page </a>";
                } else {
                    echo "<a href='./index.php?action=welcome_page&page=" . $page . "'> $page </a>";
                }
            }
        }
        ?>
        <ul>
            <?php
            if (isset($filteredPosts)) {
                foreach ($filteredPosts as $post) {
                    $user = accountDB::getUserByID($post['accountID']);
                    echo "<li>";
                    if ($post['postUpdate'] != null) {
                        echo "(edited)<br>";
                    }
                    echo "<Strong>Title:</Strong> ", $post['title'], "<br>";
                    if ($post['message'] != "") {
                        echo "<Strong>Message:</Strong> ", $post['message'], "<br>";
                    }
                    echo "<Strong>Date:</Strong> ", date("m-d-Y H:i:s", strtotime($post['postDate'])), "<br>";
                    echo "<Strong>By:</Strong> <a href='./index.php?action=profileView&username=" . $user['username'] . "'>", $user['username'], "</a><br>";
                    if ($post['imgLocation'] != "") {
                        echo "<a href='./download.php?path=" . $post['imgLocation'] . "'>Download File</a>";
                        echo "<img class='' src='" . $post['imgLocation'] . "' alt='post file.'>";
                    }
                    echo "</li>";
                }
            }
            ?>
        </ul>
    </fieldset>
</main>

<?php include './view/footer.php'; ?>