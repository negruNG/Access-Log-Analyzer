<!-- Upload log file -->
<?php

//include database parameters script
use Phppot\DataSource;
require_once '../DataSource.php';

//turn off notices and errors
error_reporting(0);

//return the JSON representation of a value
function get_data_of_uploaded_file(){
	
	//delcare new connection
	$db = new DataSource();
    $conn = $db->getConnection();

	//select query
	$query = "select name, upload_time, size from log_description where ID=(select max(ID) from log_description) and size <> 0";
	$result = mysqli_query($conn, $query);
	
	$table_data = array();
	while($row = mysqli_fetch_array($result)){
		$table_data[] = array(
		'name'				=> $row["name"],
		'upload_time'       => $row["upload_time"],
		'size'              => $row["size"]
		);
	}
	return json_encode($table_data, JSON_PRETTY_PRINT);
}

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
    $move = "../uploads/".$_FILES['log']['name'];
	
	//check the file size. 
	//100Mb = 13 107 200 Bytes
	if($file_size > 13107200){
		die("File is > 100Mb.");
	}
	
	$ext= array("log","txt","gz");
     
      if(in_array($file_ext,$ext)=== false){

      die ("The file is not gzipped, txt or log.");
      }

    if(empty($errors)==true){
		
		 //move file
         move_uploaded_file($file_tmp,$move);
         echo "Success";
    }else{
         print_r($errors);
      }
    }
   
$fmtime= "../uploads/".$_FILES['log']['name'];
$file_date = basename(date("Y-m-d h:i:s", filemtime($fmtime)));

//INSERT with SQL Injection prevention technique   
$sqlInsert = "INSERT INTO log_description (name, upload_time, size) VALUES (?, ?, ?)";
$paramType = "sss";
$paramArray = array($file_name, $file_date, $file_size);
$insertId = $db->insert($sqlInsert, $paramType, $paramArray);

//print JSON in browser			
echo '<pre>';
print_r(get_data_of_uploaded_file());
echo '</pre>';

//create JSON file on file system
$file_name = date('d-m-Y').'.json';
if(file_put_contents($file_name, get_data_of_uploaded_file())){
	echo $file_name . 'file created';
}
else{
	echo 'There is some error';
} 
  
?>
<html>
   <body>
      
      <form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="log" />
         <input type="submit"/>
      </form>
      
   </body>
</html>
