<?php include('./view/header.php') ?>
    <br>
    <body>
        <div id="wrapper">
        <h2>We're sorry :(</h2>
        <details><summary>Click here for additional details</summary>
            <?php
            // I temp commented out this line to add a similar one. 
            //echo $sqlMessage->getMessage();
            echo "<strong>Basic Error: </strong>", $e->getMessage(), "<br><br>";
            echo "<strong>Detailed Error: </strong>", $e, "<br><br>";
            if(isset($query)) { echo "<Strong>Query Statement: </Strong>", $query;}
            ?></details>
        </div>
    </body>
    <br>
<?php include './view/footer.php'; ?>