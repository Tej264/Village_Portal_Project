<?php include "header.php";
   include "../connection.php";
   if (isset($_POST['add_user'])) {
   	$username=pg_escape_string($connection,$_POST['username']);
   	$email=pg_escape_string($connection,$_POST['email']);
   	$pass=pg_escape_string($connection,sha1($_POST['password']));
       $c_pass=pg_escape_string($connection,sha1($_POST['c_pass']));
       $role=pg_escape_string($connection,$_POST['role']);
       if (strlen($username)<4|| strlen($username)>100) {
       	$error="username must be between 4 to 100 characters";
       }
       elseif (strlen($pass)<4) {
       	$error="password must be 4 character long";
       }
       elseif ($pass!=$c_pass) {
       	$error="password does not matches";
       }
       else
       {
       	$sql="SELECT * FROM users WHERE email='$email'";
       	$query=pg_query($connection,$sql);
       	$row=pg_num_rows($query);
       	if($row >= 1){
       		$error="Email already exist";
       	}
       	else
       	{
       		$sql2="INSERT INTO users (username,email,password,role) VALUES ('$username','$email','$pass','$role')";
       		$query2=pg_query($connection,$sql2);
       		if($query2){
       			$msg=['user has been updated succesfuly','alert-success'];
   	  		$_SESSION['msg']=$msg;
   	 	    header("location:users.php");
       		}
       		else
       		{
       			$error="failed, please try again";
       		}
       	}
       }
   }
   ?>
<div class="container">
   <div class="row">
      <div class="col-md-5 m-auto bg-info p-4">
         <?php
            if (!empty($error)) {
            	echo "<p class='bg-danger text-white p-2'>".$error."</p>";
            
             } 
            ?>
         <form action="" method="POST">
            <p class="text-center">Add new user</p>
            <div class="mb-3">
               <input type="text" name="username" placeholder="Username" class="form-control" requried value="<?=(!empty($error))? $username:'';?>">
            </div>
            <div class="mb-3">
               <input type="email" name="email" placeholder="Email" class="form-control" requried value="<?=(!empty($error))? $email:'';?>">
            </div>
            <div class="mb-3">
               <input type="password" name="password" placeholder="Password" class="form-control" requried>
            </div>
            <div class="mb-3">
               <input type="password" name="c_pass" placeholder="Confirm Password" class="form-control" requried>
            </div>
            <div class="mb-3">
               <select class="form-control" name="role" requried>
                  <option value="">Select Role</option>
                  <option value="1">Admin</option>
                  <option value="2">Community Member</option>
                  <option value="3">Villager</option>
               </select>
            </div>
            <div class="mb-3">
               <input type="submit" name="add_user" class="btn btn-success" value="create">	
            </div>
         </form>
      </div>
   </div>
</div>
<?php include "footer.php" ?>
