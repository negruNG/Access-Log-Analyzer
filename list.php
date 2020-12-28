<!-- List of available uploaded logs-->
<?php

//include database parameters script
use Phppot\DataSource;
require_once 'DataSource.php';

//turn off notices and errors
error_reporting(0);

//return the JSON representation of a value
function get_data(){
	
	//delcare new connection
	$db = new DataSource();
    $conn = $db->getConnection();
	
	//select query
	$query = "select name, upload_time, size from log_description where size <> 0";
	
	$result = mysqli_query($conn, $query);
	
	$table_data = array();
	
	//query data and fetch each array element
	while($row = mysqli_fetch_array($result)){
		$table_data[] = array(
		'name'				=> $row["name"],
		'upload_time'       => $row["upload_time"], 
		'size'              => $row["size"] 
		);	
	}
	return json_encode($table_data, JSON_PRETTY_PRINT);
}	

//print data in browser
echo '<pre>';
print_r(get_data());
echo '</pre>';

//create JSON file on file system
$file_name = date('d-m-Y').'.json';
if(file_put_contents($file_name, get_data())){
	echo $file_name . 'file created';
}
else{
	echo 'There is some error';
}

?>
