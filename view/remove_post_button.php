<form class="postform" action="" method="POST">
    <input type="hidden" name="action" value="post-remove-action">
    <input type="hidden" name="postid" value="<?php echo $post['postID']; ?>">
    
    <button id="submitButton" name="removeSubmit" type="submit"><img class="postButton" src='images/x.png' alt='remove post.'></button>
    
</form>