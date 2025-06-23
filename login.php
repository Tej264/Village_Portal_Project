<?php 
   ob_start();
   session_start();
   include 'connection.php';
   include 'header.php';
  
   if(isset($_SESSION['user_data']))
   {
      header("location:http://localhost/village_portal/admin/index.php");
   }
   ?>
<!DOCTYPE html>
<html>
   <head>
      <style type="text/css">
         .bg-login{
         background-image: linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)),url(images/p3.jpg);
         }
         .text-center{
         text-shadow: 2px 2px 2px black;
         font-weight: bold;
         color:white;
         font-size: 20px
         }	
      </style>
   </head>
   <body>
      <div class="container3 bg-login">
         <div class="row3">
            <div class="col-xl-5 col-md-4 m-auto mt-5 pt-5">
               <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                  <p class="text-center">Enter Into Village Digitaly...</p>
                  <div class="mb-3">
                     <input type="email" name="email" placeholder="Email" class="form-control" required>
                  </div>
                  <div class="mb-3">
                     <input type="password" name="password" placeholder="Password" class="form-control" required>	
                  </div>
                  <div class="mb-3">
                     <input type="submit" name="login_btn" class="btn bg-success" value="login" style="border-radius:5px; background-color: #28a745; color: #fff;">
                  </div>
                  <?php 
                     if (isset($_SESSION['error'])) {
                     	$error=$_SESSION['error'];
                     	echo "<p class='bg-danger p-2 text-white'>".$error."</p>";
                     	unset($_SESSION['error']);
                     }
                     ?>
               </form>
            </div>
         </div>
      </div>
      <?php
         if (isset($_POST['login_btn'])) {
         	$email=pg_escape_string($connection,$_POST['email']);
         	$pass=pg_escape_string($connection,$_POST['password']);
         	$sql="SELECT * FROM users WHERE email='{$email}' AND password='{$pass}'";
         	$query=pg_query($connection,$sql);
         	$data=pg_num_rows($query);
         	if ($data) {
         		$result=pg_fetch_assoc($query);
         		$user_data=array($result['user_id'],$result['username'],$result['role']);
         		$_SESSION['user_data']=$user_data;
         		header("Location:admin/index.php");
         		exit;
         	}
         	else {
         		$_SESSION['error']="Invalid email/password";
         		header("Location: login.php");
         		exit;
         	}
         }
         ?>
   </body>
</html>
<?php
   include 'footer.php';
   ?>
