<?php 
   include "header.php";
   include "../connection.php";
   if(isset($_SESSION['user_data']))
   {
     $userID=$_SESSION['user_data'][0];
   }
   if (!isset($_GET['page'])) {
     $page=1;
   }
   else
   {
     $page=$_GET['page'];
   }
   $limit=7;
   $offset=($page-1)*$limit;
   ?>
<!-- Begin Page Content -->
<div class="container-fluid" id="adminpage">
   <!-- Page Heading -->
   <h5 class="mb-2 text-gray-800">Posted Information</h5>
   <!-- DataTales Example -->
   <div class="card shadow">
      <div class="card-header py-3 d-flex justify-content-between">
         <div>
            <a href="add_info.php">
               <h6 class="font-weight-bold text-secondary mt-2">Add New </h6>
            </a>
         </div>
         <div>
            <form class="navbar-search">
               <div class="input-group">
                  <input type="text" class="form-control bg-white border-0 small" placeholder="Search for...">
                  <div class="input-group-append">
                     <button class="btn btn-success" type="button"> <i class="fa fa-search "></i> </button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
               <thead>
                  <tr>
                     <th>Sr.No</th>
                     <th>Title</th>
                     <th>section</th>
                     <th>Member name</th>
                     <th>Date</th>
                     <th colspan="2">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php 
                     $sql="SELECT * FROM info 
                     LEFT JOIN sections ON info.section=sections.sec_id 
                     LEFT JOIN users ON info.author_id=users.user_id  ORDER BY info.publish_date DESC limit $limit offset $offset"; 
                     $query=pg_query($connection,$sql);
                     $rows=pg_num_rows($query);
                     $count=0;
                     if ($rows) {
                        while ($result=pg_fetch_assoc($query)) {
                          ?>
                  <tr>
                     <td><?= ++$count ?></td>
                     <td><?= $result['info_title'] ?></td>
                     <td><?= $result['sec_name'] ?></td>
                     <td>
                        <?php 
                           if(isset($_SESSION['user_data']))
                           {
                                echo $_SESSION['user_data'][1];
                            }
                           ?>
                     </td>
                     <td><?= date('d-M-Y',strtotime($result['publish_date']) ) ?></td>
                     <td><a href="edit_info.php?id=<?= $result['info_id']?>" class="btn btn-sm btn-success">Edit</a></td>
                     <td>
                        <form class="mt-2" method="POST" onsubmit="return confirm('Are you sure you want to delete ')">
                           <input type="hidden" name="id" value="<?= $result['info_id'] ?>">
                           <input type="hidden" name="image" value="<?= $result['info_image'] ?>">
                           <input type="Submit" name="deletePost" value="Delete" class="btn btn-sm btn-danger">
                        </form>
                     </td>
                  </tr>
                  <?php
                     }
                     }
                     else
                     {
                       ?>
                  <tr>
                     <td colspan="7">No Record Found</td>
                  </tr>
                  <?php
                     }
                     ?>
               </tbody>
            </table>
            <?php 
               $pagination="SELECT * FROM info WHERE author_id='$userID'";
               $run_q=pg_query($connection,$pagination);
               $total_post=pg_num_rows($run_q);
               $pages=ceil($total_post/$limit);
               if($total_post>$limit)
               {
               ?>
            <ul class="pagination pt-2 pb-5">
               <?php for ($i=1; $i <=$pages ; $i++) { ?>     
               <li class="page-item <?=($i==$page) ? $active="":"";?>" >
                  <a href="index.php?page=<?=$i ?>" class="page-link" style="background-color:green; color: white;">
                  <?=$i ?>
                  </a>
               </li>
               <?php } ?>
            </ul>
            <?php } ?>
         </div>
      </div>
   </div>
</div>
</div>
<?php include "footer.php" ;
   if (isset($_POST['deletePost'])) {
      $id= $_POST['id'];
      $image="upload/".$_POST['image'];
      $delete= "DELETE FROM info WHERE info_id='$id'";
      $run=pg_query($connection,$delete);
      if ($run) {
         unlink($image);
         $msg=['post has been deleted succesfuly','alert-success'];
            $_SESSION['msg']=$msg;
         header("location:index.php");
      }
      else
      {
        $msg=['Failed!,please try again','alert-danger'];
            $_SESSION['msg']=$msg;
         header("location:index.php");
      }
   }
   ?>