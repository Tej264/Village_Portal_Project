<?php include "header.php";
   include "connection.php";
   $id=$_GET['id'];
   if (empty($id)) {
   header("location:index.php");
   }
   $sql="SELECT * FROM info WHERE info_id='$id'";
   $run=pg_query($connection,$sql);
   $result=pg_fetch_assoc($run)
   ?>
<div class="container mt-2">
   <div class="row">
      <div class="col-lg-8">
         <div class="card shadow">
            <div class="card-body">
               <div  id="single_img">
                  <?php $img=$result['info_image'] ?>
                  <a href="admin/upload/<?= $img ?>">
                  <img src="admin/upload/<?= $img ?>" alt="">
                  </a>
               </div>
               <hr>
               <div>
                  <h5><?= ucfirst($result['info_title']) ?></h5>
                  <p><?= $result['info_body'] ?></p>
               </div>
            </div>
         </div>
         <?php include "comments.php" ?>
      </div>
      <?php include "sidebar.php" ?>
   </div>
</div>
<?php include "footer.php" ?>