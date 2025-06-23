<?php
include "../connection.php";
include "header.php";
$sql = "SELECT comments.*, info_title 
        FROM comments 
        JOIN info ON comments.info_id = info.info_id 
        ORDER BY comments.comment_date DESC";
$run = pg_query($connection, $sql);
?>
<div class="card shadow mt-4">
    <div class="card-body">
        <h5 class="mb-4">All Comments</h5>
        <?php if (pg_num_rows($run) > 0) { ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Information Title</th>
                    <th>Name</th>
                    <th>Comment</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($comment = pg_fetch_assoc($run)) { ?>
                <tr>
                    <td><?= $comment['info_title'] ?></td>
                    <td><?= $comment['comment_name'] ?></td>
                    <td><?= $comment['comment_text'] ?></td>
                    <td><?= $comment['comment_date'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
        <p>No comments yet.</p>
        <?php } ?>
    </div>
</div>



