<?php include "header.php";
include "../connection.php";
$id=$_GET['id'];
if (empty($id)) {
	header("location:sections.php");
}
$sql="SELECT * FROM sections WHERE sec_id='$id'";
$query=pg_query($connection,$sql);
$row=pg_fetch_assoc($query);
?>
<div class="container">
	<h5 class="mb-2 text-gray-800">SECTIONS</h5>
	<div class="row">
		<div class="col-xl-6 col-lg-5">
			<div class="card">
				<div class="card-header">
					<h6 class="font-weight-bold text-secondary mt-2">Edit Section</h6>
				</div>
				<div class="card-body">
					<form action="" method="POST">
						<div class="mb-3">
							<input type="text" name="sec_name" placeholder="section name" class="form-control" required value="<?=$row['sec_name']?>">
						</div>
						<div class="mb-3">
							<input type="submit" name="update_sec" value="Update" class="btn btn-success">
							<a href="sections.php" class="btn btn-secondary">Back</a>
						</div>
					</form>
				</div>	
			</div>	
		</div>
	</div>
</div>
<?php include "footer.php";
if (isset($_POST['update_sec'])) {
	$sec_name=pg_escape_string($connection,$_POST['sec_name']);
	$sql2="UPDATE sections SET sec_name='{$sec_name}'WHERE sec_id='{$id}'";
	$update=pg_query($connection,$sql2);
	if ($update) {
	  		$msg=['section has been updated succesfuly','alert-success'];
	  		$_SESSION['msg']=$msg;
	 	    header("location:sections.php");
	  	}
	  	else
	  	{
	  		$msg=['failed!,please try again','alert-danger'];
	  		$_SESSION['msg']=$msg;
	 	    header("location:sections.php");
	  	}
}	
?>