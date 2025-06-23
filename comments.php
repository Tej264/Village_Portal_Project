<?php
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       $name = pg_escape_string($_POST['name']);
       $comment = pg_escape_string($_POST['comment']);
       $date = date('Y-m-d H:i:s');
   
       $sql = "INSERT INTO comments (info_id, comment_name, comment_text, comment_date) VALUES ('$id', '$name', '$comment', '$date')";
       pg_query($connection, $sql);
   }
   $sql = "SELECT * FROM comments WHERE info_id='$id' ORDER BY comment_date DESC";
   $run = pg_query($connection, $sql);
   ?>
<div class="card shadow mt-4" style="border-radius: 15px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
   <div class="card-body">
      <h5 class="mb-4">Comments</h5>
      <?php while ($comment = pg_fetch_assoc($run)) { ?>
      <div class="media mb-4" style="border: 1px solid #ddd; border-radius: 10px; padding: 10px;">
         <img class="mr-3 rounded-circle" src="admin/precodes/img/undraw_profile.svg" alt="User Avatar" width="30" height="30" style="border: 2px solid #ddd;">
         <div class="media-body">
            <h6 class="mt-0" style="font-weight: bold;"><?= $comment['comment_name'] ?></h6>
            <p><?= $comment['comment_text'] ?></p>
            <small class="text-muted" style="font-size: 12px;"><?= $comment['comment_date'] ?></small>
         </div>
      </div>
      <?php } ?>
      <form method="post" class="mt-4">
         <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" required style="border-radius: 20px;">
         </div>
         <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" name="comment" required style="border-radius: 20px;"></textarea>
         </div>
         <br>
         <button type="submit" class="btn btn-success" style="border-radius: 20px;">Submit Comment</button>
      </form>
   </div>
</div>