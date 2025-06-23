<?php 
   include "header.php";
   include "../connection.php";
   $infoID=$_GET['id'];
   if (empty($infoID)) {
   	header("location:index.php");
   }
   if (isset($_SESSION['user_data'])) {
       $author_id=$_SESSION['user_data']['0'];
   }
   $sql="SELECT * FROM sections";
   $query=pg_query($connection,$sql);
   $sql2="SELECT * FROM info LEFT JOIN sections ON info.section=sections.sec_id LEFT JOIN users ON info.author_id=users.user_id WHERE info_id='$infoID'";              
   $query2=pg_query($connection,$sql2);
   $result=pg_fetch_assoc($query2);
   ?>
<div class="container">
   <h5 class="mb-2 text-gray-800">Information</h5>
   <div class="row">
      <div class="col-xl-8 col-lg-6">
         <div class="card">
            <div class="card-header">
               <h6 class="font-weight-bold text-secondary mt-2">Edit uploded Information</h6>
            </div>
            <div class="card-body">
               <form action="" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                     <input type="text" name="info_title" placeholder="Information Title" class="form-control" required value="<?=$result['info_title']?>">
                  </div>
                  <div class="mb-3">
                     <label>Discription</label>
                     <textarea requried class="form-control" name="info_body" rows="2" id="info"><?=$result['info_body']?></textarea>
                  </div>
                  <div class="mb-3">
                     <input type="file" name="info_image" class="form-control"><img src="upload/<?=$result['info_image']?>" width='100px'>
                  </div>
                  <div class="mb-3">
                     <select class="form-control" name="section" requried >
                        <option value="">Select Section :
                           <?php while ($secs=pg_fetch_assoc($query)) { ?>
                        <option value="<?=$secs['sec_id'] ?>"
                           <?php 
                              if ($result['section']==$secs['sec_id']) {
                              	echo "selected";
                              }
                              else
                              {
                              	echo "";
                              }
                           ?>>
                       <?=$secs['sec_name'] ?>
                    </option>
                    <?php } ?>
                 </select>
              </div>
              <div class="mb-3">
                 <input type="submit" name="edit_info" value="update" class="btn btn-success">
                 <a href="index.php" class="btn btn-secondary">Back</a>
              </div>
           </form>
        </div>
     </div>
  </div>
   </div>
</div>
<?php include "footer.php";
   if (isset($_POST['edit_info'])) {
   	$title=pg_escape_string($connection,$_POST['info_title']);
   	$body=pg_escape_string($connection,$_POST['info_body']);
   	$filename=$_FILES['info_image']['name'];
   	$tmp_name=$_FILES['info_image']['tmp_name'];
   	$size=$_FILES['info_image']['size'];
   	$image_ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
   	$allow_type=['jpg','png','jpeg'];
   	$destination="upload/".$filename;
   	$section=pg_escape_string($connection,$_POST['section']);
   	if(!empty($filename)){
   	if (in_array($image_ext, $allow_type)) {
   		if ($size <= 2000000) {
  $unlink="upload/".$result['info_image'];
  unlink($unlink);
  move_uploaded_file($tmp_name, $destination);
  $sql3="UPDATE info SET info_title='$title',info_body='$body',info_image='$filename',section='$section',author_id='$author_id' WHERE info_id='$infoID'";
  $query3=pg_query($connection,$sql3);
  if ($query3) {
    $msg=['post update succesfuly','alert-success'];
    $_SESSION['msg']=$msg;
    header("location:index.php");
  } else {
    $msg=['failed please try again','alert-danger'];
    $_SESSION['msg']=$msg;
    header("location:index.php");
  }
} else {
  $msg=['image size should not greater than 2mb','alert-danger'];
  $_SESSION['msg']=$msg;
  header("location:index.php");
}
else {
  $msg=['file type is not allowed','alert-danger'];
  $_SESSION['msg']=$msg;
  header("location:index.php");
}
else {
  $sql3="UPDATE info SET info_title='$title',info_body='$body',section='$section',author_id='$author_id' WHERE info_id='$infoID'";
  $query3=pg_query($connection,$sql3);
  if ($query3) {
    $msg=['post update succesfuly','alert-success'];
    $_SESSION['msg']=$msg;
    header("location:index.php");
  } else {
    $msg=['failed please try again','alert-danger'];
    $_SESSION['msg']=$msg;
    header("location:index.php");
  }
}
}
?>