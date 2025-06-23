<?php include "connection.php";
   $select="SELECT * FROM sections";
   $query=pg_query($connection,$select);
   $select2="SELECT * FROM info ORDER BY publish_date limit 5";
   $query2=pg_query($connection,$select2);
   ?>
<div class="col-lg-4">
   <div class="card">
      <div class="card-body d-flex right-section">
         <div id="categories">
            <h6 class="bg-success">
               <a style="color:white;text-decoration:none;font-weight: 1000; " href="index.php">Find Information Related to :</a>
            </h6>
            <ul>
               <?php while($secs=pg_fetch_assoc($query)) { ?>
               <li>
                  <a href="section.php?id=<?=$secs['sec_id']?>" class=" fw-bold">
                  <?=$secs['sec_name'] ?></a>
               </li>
               <?php } ?>
            </ul>
         </div>
         <div id="posts">
            <h6 class="bg-success" style="color:white;text-decoration:none;font-weight: 1000;">Recently Added Information</h6>
            <ul>
               <?php while($posts=pg_fetch_assoc($query2)) { ?>
               <li>
                  <a href="single_post.php?id=<?=$posts['info_id'] ?>" class=" fw-bold"><?=$posts['info_title'] ?></a>
               </li>
               <?php } ?>
            </ul>
         </div>
      </div>
   </div>
</div>