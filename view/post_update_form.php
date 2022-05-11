<form action="" method="POST" enctype="multipart/form-data">
    <fieldset id="leftAlign">
    <h3>Update Post</h3>
    <input type="hidden" name="action" value="post-update-action">
    <input type="hidden" name="postid" value="<?php if(isset($postID)) { echo $postID;} ?>">    
    
    <span id="redText">*</span><label for="title">Title</label>
    <input id="title" name="title" type="text" value="<?php if(isset($title)) { echo $title;} ?>">
    <span id='redText'><?php if(isset($titleError)) { echo $titleError;} ?></span>
    <br><br>

    <label for="postmessage">Message</label>
    <input id="postmessage" name="postmessage" type="text" value="<?php if(isset($postmessage)) { echo $postmessage;} ?>">
    <span id='redText'><?php if(isset($postmessageError)) { echo $postmessageError;} ?></span>
    <br><br>
        
    <input id="file" name="file" type="file" value="<?php if(isset($file)) { echo $file;} ?>">
    <span id='redText'><?php if(isset($fileError)) { echo $fileError;} ?></span>
    <br><br>
    
    <span id="redText">*</span><input type="radio" id="public" name="privacysetting" value="public" checked="true">
    <label for="admin">Public</label>
    <input type="radio" id="private" name="privacysetting" value="private">
    <label for="employee">Private</label>
    <span id='redText'><?php if(isset($privacysettingError)) { echo "<br>", $privacysettingError;} ?></span>
    <br><br>
        
    <button id="submitButton" name="postSubmit" type="submit">Update Post</button>
    </fieldset>
    <br>
    
</form>