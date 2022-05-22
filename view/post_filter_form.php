<form action="" method="POST">
    <h3>Filter Posts</h3>
    <input type="hidden" name="action" value="post-filter-action">
    <input type="hidden" name="filtermode" value="no">    
    
    <label for="title">Title</label>
    <input id="title" name="title" type="text" value="<?php if(isset($title)) { echo $title;} ?>">
    <span id='redText'><?php if(isset($titleError) && $titleError != "") { echo "<br>". $titleError;} ?></span>
    <br>

    <label for="postdate">Date</label>
    <input id="postdate" name="postdate" type="date" value="<?php if(isset($postDate)) { echo $postDate;} ?>">
    <span id='redText'><?php if(isset($postdateError) && $postdateError != "") { echo "<br>". $postdateError;} ?></span>
    <br>
    
    <input type="radio" id="auto" name="beforeafter" value="before">
    <label for="before">Before</label>
    <input type="radio" id="manual" name="beforeafter" value="after">
    <label for="after">After</label>
    <span id='redText'><?php if(isset($beforeafterError) && $beforeafterError != "") { echo "<br>". $beforeafterError;} ?></span>
    <br>
        
    <button id="submitButton" name="filterSubmit" type="submit">Filter</button>
    <br>
    
</form>