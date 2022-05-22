<?php include_once './view/header.php'; ?>

<main>
    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>

    <h3>
        <?php echo $account->getUsername(); ?>'s Profile Page
    </h3>
    <p>
        Email: <?php echo $account->getEmail(); ?><br>
        <?php
        if ($account->getFname() != "" && $account->getLname() != "") {
            echo "Name: " . $account->getFname() . " " . $account->getLname() . "<br>";
        }
        ?>
        <?php
        if ($account->getBio() != "") {
            echo "Bio:<br> <textarea rows='4' cols='50' readonly>" . $account->getBio() . "</textarea><br>";
        }
        ?>
    </p>

    <fieldset>
        <h3><?php echo $account->getUsername(); ?>'s Posts<?php
            if (isset($count)) {
                echo " - " . $count;
            }
            ?></h3>
        <?php
        for ($page = 1; $page <= $pages; $page++) {
            if ($page == $currentPage) {
                echo "<a id='currentPage' href='./index.php?action=profileView&username=" . $account->getUsername() . "&page=" . $page . "'> $page </a>";
            } else {
                echo "<a href='./index.php?action=profileView&username=" . $account->getUsername() . "&page=" . $page . "'> $page </a>";
            }
        }
        ?>
        <ul id="postBox">
            <?php
            if (isset($filteredPosts)) {
                if ($filteredPosts == "") {
                    echo "<li>";
                    echo "<Strong>No Posts Found.</Strong>";
                    echo "</li>";
                } else {
                    foreach ($filteredPosts as $post) {
                        echo "<li>";
                        if ($post['postUpdate'] != null) {
                            echo "(edited)<br>";
                        }
                        echo "<Strong>Title:</Strong> ", $post['title'], "<br>";
                        if ($post['message'] != "") {
                            echo "<Strong>Message:</Strong> ", $post['message'], "<br>";
                        }
                        echo "<Strong>Date:</Strong> ", date("m-d-Y H:i:s", strtotime($post['postDate'])), "<br>";
                        if ($post['imgLocation'] != "") {
                            echo "<a href='./download.php?path=" . $post['imgLocation'] . "'>Download File</a>";
                            echo "<img class='' src='" . $post['imgLocation'] . "' alt='post file.'>";
                        }
                        echo "</li>";
                    }
                }
            }
            ?>
        </ul>
    </fieldset>

</main>

<?php include './view/footer.php'; ?>