<?php include "header.php";
   include "../connection.php";
   if($admin!=1)
   {
   header("location:index.php");
   }
   
   $sql="SELECT * FROM users";
   $query=pg_query($connection,$sql);
   $rows=pg_num_rows($query);
   ?>
<!-- Begin Page Content -->
<div class="container-fluid">
   <!-- Page Heading -->
   <h5 class="mb-2 text-gray-800">USERS</h5>
   <!-- DataTales Example -->
   <div class="card shadow">
      <div class="card-header py-3 d-flex justify-content-between">
         <div>
            <a href="add_user.php">
               <h6 class="font-weight-bold text-secondary mt-2">ADD NEW USER</h6>
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
                     <th>Username</th>
                     <th>Email</th>
                     <th>Role</th>
                     <th colspan="2">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $count=0;
                     if ($rows) {
                        While($result=pg_fetch_assoc($query)){
                           ?>
                  <tr>
                     <td><?= ++$count ?></td>
                     <td><?=$result['username'] ?></td>
                     <td><?=$result['email'] ?></td>
                     <td>
                        <?php 
                           $role=$result['role'];
                           if ($role==1) {
                              echo "Admin";
                           }
                           else if($role==2)
                           {
                              echo "Community member";
                           }
                           else{
                              echo "Villager";
                           }
                        ?>
                 </td>
                 <td>
                    <form class="mt-2" action="" method="POST" onsubmit="return confirm('Are you sure you want to delete ')">
                       <input type="hidden" name="userName" value="<?= $result['username'] ?>">
                       <input type="Submit" name="deleteUser" value="Delete" class="btn btn-sm btn-danger">
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
                 <td>No Record Found</td>
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
<!-- /.container-fluid -->
</div>
<?php include "footer.php";
   if (isset($_POST['deleteUser'])) {
      $id=$_POST['userName'];
      $delete= "DELETE FROM users WHERE username='$id'";
      $run=pg_query($connection,$delete);
      if ($run) {
         $msg=['user has been deleted succesfuly','alert-success'];
            $_SESSION['msg']=$msg;
        header("location:users.php");
      }
      else
      {
        $msg=['Failed!,please try again','alert-danger'];
            $_SESSION['msg']=$msg;
         header("location:users.php");
      }
   }
   ?>