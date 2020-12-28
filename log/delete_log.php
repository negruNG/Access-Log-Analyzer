<!-- Delete uploaded log -->
<?php

//include database parameters script
use Phppot\DataSource;
require_once '../DataSource.php';

//turn off notices and errors
error_reporting(0);

//delcare new connection
$db = new DataSource();
$conn = $db->getConnection();

if(isset($_FILES['log'])){
      $errors= array();
      $file_name = basename($_FILES['log']['name']);
      $file_size =basename($_FILES['log']['size']);
      $file_tmp =$_FILES['log']['tmp_name'];
      $file_type=$_FILES['log']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['log']['name'])));
      $path = "../uploads/".$_FILES['log']['name'];

      if(!unlink($path)){
         echo "Error";
      }else{
         echo "Delete Success";
      }
}

mysqli_query($conn, "delete from log_description where name =  '".$file_name."'");
   
?>

<html>
   <body>
      
      <form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="log" />
         <input type="submit"/>
      </form>
      
   </body>
</html>
