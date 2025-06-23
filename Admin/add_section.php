<?php include "header.php";
   include "../connection.php"
   ?>
<div class="container">
   <h5 class="mb-2 text-gray-800">Sections</h5>
   <div class="row">
      <div class="col-xl-6 col-lg-5">
         <div class="card">
            <div class="card-header">
               <h6 class="font-weight-bold text-secondary mt-2">Add section</h6>
            </div>
            <div class="card-body">
               <form action="" method="POST">
                  <div class="mb-3">
                     <input type="text" name="sec_name" placeholder="Section name" class="form-control" required>
                  </div>
                  <div class="mb-3">
                     <input type="submit" name="add_sec" value="Add" class="btn btn-success">
                     <a href="sections.php" class="btn btn-secondary">Back</a>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<?php include "footer.php";
   if (isset($_POST['add_sec'])) {
   	$sec_name=pg_escape_string($connection,$_POST['sec_name']);
   	$sql="SELECT * FROM sections WHERE sec_name='{$sec_name}'";
   	$query=pg_query($connection , $sql);
   	$row=pg_num_rows($query);
   	if ($row) {
   	 	$msg="section is already exists";
   	 	$_SESSION['msg']=$msg;
   	 	header("location:add_section.php");
   	 }
   	 else 
   	 {
   	  	$sql2="INSERT INTO sections (sec_name) VALUES('$sec_name')";
   	  	$query2=pg_query($connection , $sql2);
   	  	if ($query2) {
   	  		$msg=['section has been added successfully','alert-success'];
   	  		$_SESSION['msg']=$msg;
   	 	    header("location:add_section.php");
   	  	}
   	  	else
   	  	{
   	  		$msg=['failed ! please try again','alert-danger'];
   	  		$_SESSION['msg']=$msg;
   	 	    header("location:add_section.php");
   	  	}
   	 } 
   }
   ?>
