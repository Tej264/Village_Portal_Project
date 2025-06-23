<?php
   include "header.php";
   include "../connection.php";
   if (isset($_SESSION['user_data'])) {
       $author_id=$_SESSION['user_data']['0'];
   }
   $sql="SELECT * FROM sections";
   $query=pg_query($connection,$sql);
   ?>
<div class="container">
   <h5 class="mb-2 text-gray-800">Add Information</h5>
   <div class="row">
      <div class="col-xl-8 col-lg-6">
         <div class="card">
            <div class="card-header">
               <h6 class="font-weight-bold text-secondary mt-2">Add Village Related Information</h6>
            </div>
            <div class="card-body">
               <form action="" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                     <input type="text" name="info_title" placeholder="Information Title" class="form-control" required>
                  </div>
                  <div class="mb-3">
                     <label>Discription</label>
                     <textarea requried class="form-control" name="info_body" rows="2" id="info"></textarea>
                  </div>
                  <div class="mb-3">
                     <input type="file" name="info_image" class="form-control">
                  </div>
                  <div class="mb-3">
                     <select class="form-control" name="section" requried >
                        <option value="">Select Section</option>
                        <?php while ($sec=pg_fetch_assoc($query)) { ?>
                        <option value="<?=$sec['sec_id'] ?>"><?=$sec['sec_name'] ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="mb-3">
                     <input type="submit" name="add_info" value="Add" class="btn btn-success">
                     <a href="index.php" class="btn btn-secondary">Back</a>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<?php include "footer.php";
   if (isset($_POST['add_info'])) {
   	$title=pg_escape_string($connection,$_POST['info_title']);
   	$body=pg_escape_string($connection,$_POST['info_body']);
   	$filename=$_FILES['info_image']['name'];
   	$tmp_name=$_FILES['info_image']['tmp_name'];
   	$size=$_FILES['info_image']['size'];
   	$image_ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
   	$allow_type=['jpg','png','jpeg'];
   	$destination="upload/".$filename;
   	$section=pg_escape_string($connection,$_POST['section']);
   	if (in_array($image_ext, $allow_type)) {
   		if ($size <= 2000000) {
   			move_uploaded_file($tmp_name, $destination);
               $sql2="INSERT INTO info(info_title,info_body,info_image,section,author_id)VALUES ('$title','$body','$filename','$section','$author_id')";
               $query2=pg_query($connection,$sql2);
               if ($query2) {
               	$msg=['post published succesfuly','alert-success'];
               	$_SESSION['msg']=$msg;
   	 	        header("location:add_info.php");
               }
               else
               {
               	$msg=['failed please try again','alert-danger'];
               	$_SESSION['msg']=$msg;
   	 	        header("location:add_info.php");
               }
   		}
   		else
   		{
   			$msg=['image size should not greater than 2mb','alert-danger'];
               $_SESSION['msg']=$msg;
             header("location:add_info.php");
         }
      }
      else
      {
         $msg=['file type is not allowed','alert-danger'];
           $_SESSION['msg']=$msg;
         header("location:add_info.php");
      }
   }
   ?>
