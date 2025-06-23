<?php include "header.php";
   include "../connection.php";
   if($admin!=1)
   {
     header("location:index.php");
   }
   ?>
<!-- Begin Page Content -->
<div class="container-fluid">
   <!-- Page Heading -->
   <h5 class="mb-2 text-gray-800">Sections</h5>
   <!-- DataTales Example -->
   <div class="card shadow">
      <div class="card-header py-3 d-flex justify-content-between">
         <div>
            <a href="add_section.php">
               <h6 class="font-weight-bold text-primary mt-2">Add New</h6>
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
                     <th>Section Name</th>
                     <th colspan="2">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $sql="SELECT * FROM sections";
                     $query=pg_query($connection,$sql);
                     $rows=pg_num_rows($query);
                     $count=0;
                     if ($rows) {
                         while ($row=pg_fetch_assoc($query)) {
                          ?>
                  <tr>
                     <td><?= ++$count ?></td>
                     <td><?= $row['sec_name'] ?></td>
                     <td>
                        <a href="edit_section.php? id=<?= $row['sec_id'] ?>" class="btn btn-sm btn-success">Edit.  </a>
                     <td>
                        <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete ')">
                           <input type="hidden" name="secID" value="<?= $row['sec_id'] ?>">
                           <input type="Submit" name="deleteSec" value="Delete" class="btn btn-sm btn-danger">
                        </form>
                     </td>
                     </td>
                  </tr>
                  <?php  
                     }
                     } 
                     else
                     {
                     ?>
                  <tr>
                     <td colspan="4">NO Record Found</td>
                  </tr>
                  <?php  
                     }
                     ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
</div>
<?php include "footer.php";
   if (isset($_POST['deleteSec'])) {
      $id=$_POST['secID'];
      $delete= "DELETE FROM sections WHERE sec_id='$id'";
      $run=pg_query($connection,$delete);
      if ($run) {
         $msg=['Section deleted succesfuly','alert-success'];
            $_SESSION['msg']=$msg;
         header("location:sections.php");
      }
      else
      {
        $msg=['Failed!,please try again','alert-danger'];
            $_SESSION['msg']=$msg;
         header("location:sections.php");
      }
   }
   ?>