<?php include "header.php"; 
   include "connection.php";
   $id=$_GET['id'];
   if (empty($id)) {
   header("location:index.php");
   }
   $sql="SELECT * FROM info LEFT JOIN sections ON info.section=sections.sec_id LEFT JOIN users ON info.author_id=users.user_id WHERE sec_id='$id' ORDER BY info.publish_date DESC";
   $run=pg_query($connection,$sql);
   $rows=pg_num_rows($run);
   ?>
<div class="container mt-2">
   <div class="row">
      <div class="col-lg-8">
         <?php if ($rows) {
            while($result=pg_fetch_assoc($run)){
            ?>
         <div class="card shadow">
            <div class="card-body d-flex blog_flex">
               <div class="flex-part1">
                  <a href="single_post.php?id=<?=$result['info_id']?>">
                  <?php $img=$result['info_image'] ?>
                  <img src="admin/upload/<?= $img ?>">
                  </a>
               </div>
               <div class="flex-grow-1 flex-part2">
                  <a href="single_post.php?id=<?=$result['info_id']?>" id="title">
                  <?= ucfirst($result['info_title']) ?>
                  </a>
                  <p>
                     <a href="single_post.php?id=<?=$result['info_id']?>" id="body">
                     <?= strip_tags(substr($result['info_body'], 0,250))."......" ?>
                     </a> <span><br>
                     <a href="single_post.php?id=<?=$result['info_id']?>" class="btn btn-sm btn-outline-success">Read More...
                     </a></span>
                  </p>
                  <ul>
                     <li class="me-2"><a href=""> <span>
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                        <?= $result['username'] ?>
                        </a>
                     </li>
                     <li class="me-2">
                        <a href=""> <span><i class="fa fa-calendar-o" aria-hidden="true"></i></span> 
                        <?php $date=$result['publish_date'] ?>
                        <?= date('d-M-Y',strtotime($date)) ?>
                        </a>
                     </li>
                     <li>
                        <a href=""> <span><i class="fa fa-tag" aria-hidden="true"></i></span> 
                        <?=$result['sec_name'] ?>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <?php } } ?>
      </div>
      <?php include "sidebar.php" ?>
   </div>
</div>
<?php include "footer.php" ?>