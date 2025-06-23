<?php
   $page=basename($_SERVER['PHP_SELF'],".php");
   include "connection.php";
   $select="SELECT * FROM sections";
   $query=pg_query($connection,$select);
   ?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="style.css">
      <style type="text/css">
         @keyframes color-c {
         0% { color:#ffffff; }
         50% { color: #ffe6ff; }
         100% { color:#e6e6ff; }
         }
         .navbar-brand h2{
         animation-name: color-c;
         animation-duration: 5s;
         animation-iteration-count: infinite;
         font-weight: 1000;
         text-shadow: 4px 4px 6px rgba(0, 0, 0, 0.5);
         text-decoration: underline;
         text-decoration-skip-ink: none;
         text-underline-offset: 4px;
         }
         .bg-searchbtn{
         background-color: #e6ffff;
         }
      </style>
      <title>Village Portal_Dawadi</title>
   </head>
   <body>
      <header>
         <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container">
               <a class="navbar-brand" href="home.php">
                  <h2>Dawadi</h2>
               </a>
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarColor01">
                  <ul class="navbar-nav me-auto">
                     <li class="nav-item">
                        <a class="nav-link <?php if($page=="home"){
                           echo "active";
                           }?>" href="home.php">Home
                        <span class="visually-hidden">(current)</span>
                        </a>
                     </li>
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Sections</a>
                        <div class="dropdown-menu">
                           <?php while($secs=pg_fetch_assoc($query)) { ?>
                           <a class="dropdown-item" href="section.php?id=<?=$secs['sec_id']?>">
                           <?=$secs['sec_name'] ?>
                           </a>
                           <?php } ?>
                          <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="Register.php">Register Yourself in community</a>
                        </div>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link <?php if($page=="login"){
                           echo "active";
                           }?>" href="login.php">Login
                        </a>
                     </li>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link <?php if($page=="Register"){
                           echo "active";
                           }?>" href="Register.php">Register
                        </a>
                     </li>
                  </ul>
                  <?php 
                     if(isset($_GET['keyword']))
                     {
                       $keyword=$_GET['keyword'];
                     }
                     else
                     {
                       $keyword="";
                     }
                     ?>
                  <form class="d-flex" action="search.php" method="GET">
                     <input class="form-control me-sm-2" type="search" placeholder="Search" name="keyword" required maxlength="70" autocomplete="off" value="<?=$keyword ?>">
                     <button class="btn bg-searchbtn my-2 my-sm-0" type="submit">Search</button>
                  </form>
               </div>
            </div>
         </nav>
      </header>
   </body>
</html>


