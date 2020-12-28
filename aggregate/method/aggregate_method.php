<!-- Aggregated by HTTP method -->
<?php

use Phppot\DataSource;
require_once '../../DataSource.php';

//turn off notices and errors
error_reporting(0);

$db = new DataSource();
$conn = $db->getConnection();

//delete on every new start of aggregation operation 
//Because of that, it won’t get overpopulated by data
$query_delete = "delete from log_entry";
$result_delete = mysqli_query($conn, $query_delete);

$directory = "../../uploads/*"; // LOG Files Directory Path

// Open and Write Master LOG/CSV File
$masterLOGFile = fopen('mergedfiles.csv', "w+");

// Process each LOG file inside root directory
foreach(glob($directory) as $file) {

    $data = []; // Empty Data

    // Allow only LOG files
    if (strpos($file, '.log') !== false) {

        // Open and Read individual LOG file
        if (($handle = fopen($file, 'r')) !== false) {
            // Collect LOG each row records
            while (($dataValue = fgetCSV($handle, 10000, " ")) !== false) {
                $data[] = $dataValue;
				
            }
        }

        fclose($handle); // Close individual LOG file 
        
        //unset($data[0]); // Remove first row of LOG, commonly tends to LOG header

        // Check whether record present or not
        if(count($data) > 0) {

            foreach ($data as $value) {
                try {
                   // Insert record into master LOG file
                   fputCSV($masterLOGFile, $value, " ");
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            
            }

        } else {
            echo "[$file] file contains no record to process.";
        }

    } else {
        echo "[$file] is not a LOG file.";
    }

}

// Close master LOG file 
fclose($masterLOGFile);
    
        
        $file = fopen("mergedfiles.csv", "r");
        
        while (($column = fgetcsv($file, 10000, " ")) !== FALSE) {
            
            $ip_address = "";
            if (isset($column[0])) {
                $ip_address = mysqli_real_escape_string($conn, $column[0]);
            }
            $column_2 = "";
            if (isset($column[1])) {
                $column_2 = mysqli_real_escape_string($conn, $column[1]);
            }
            $column_3 = "";
            if (isset($column[2])) {
                $column_3 = mysqli_real_escape_string($conn, $column[2]);
            }
            $log_date = "";
            if (isset($column[3])) {
                $log_date = mysqli_real_escape_string($conn, $column[3]);
            }
            $column_5 = "";
            if (isset($column[4])) {
                $column_5 = mysqli_real_escape_string($conn, $column[4]);
            }
			$method = "";
            if (isset($column[5])) {
                $method = mysqli_real_escape_string($conn, $column[5]);
            }
			$column_7 = "";
            if (isset($column[6])) {
                $column_7 = mysqli_real_escape_string($conn, $column[6]);
            }
			$column_8 = "";
            if (isset($column[7])) {
                $column_8 = mysqli_real_escape_string($conn, $column[7]);
            }
			$url = "";
            if (isset($column[8])) {
                $url = mysqli_real_escape_string($conn, $column[8]);
            }
		    $browser = "";
            if (isset($column[9])) {
                $browser = mysqli_real_escape_string($conn, $column[9]);
            }
			$domain = "";
            if (isset($column[10])) {
                $domain = mysqli_real_escape_string($conn, $column[10]);
            }
			$column_12 = "";
            if (isset($column[11])) {
                $column_12 = mysqli_real_escape_string($conn, $column[11]);
            }
			$column_13 = "";
            if (isset($column[12])) {
                $column_13 = mysqli_real_escape_string($conn, $column[12]);
            }
			$column_14 = "";
            if (isset($column[13])) {
                $column_14 = mysqli_real_escape_string($conn, $column[13]);
            }
		    $column_15 = "";
            if (isset($column[14])) {
                $column_15 = mysqli_real_escape_string($conn, $column[14]);
            }
            
            $sqlInsert = "INSERT into log_entry (ip_address, column_2, column_3, log_date, column_5, method, column_7, column_8, url, browser, domain,
			column_12, column_13, column_14, column_15) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            
			$paramType = "sssssssssssssss";
            $paramArray = array(
				$ip_address, 
				$column_2, 
				$column_3, 
				$log_date, 
				$column_5, 
				$method, 
				$column_7, 
				$column_8, 
				$url, 
				$browser, 
				$domain,
			    $column_12, 
			    $column_13, 
			    $column_14,
				$column_15
            );
							
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
			
            if (! empty($insertId)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
		
		$query_trim = "UPDATE log_entry SET log_date = SUBSTR(log_date,2)";
		$result_trim = mysqli_query($conn, $query_trim);
		
function get_method_data(){
	
	$db = new DataSource();
    $conn = $db->getConnection();
	
	$dt_start = $_GET['dt_start'];
	$dt_end = $_GET['dt_end'];
	
	$query = "select method, count(method) as cnt_method from log_entry where STR_TO_DATE(log_date , '%d/%b/%Y:%H:%i:%s') = '".$dt_start."' group by method;";
	$result = mysqli_query($conn, $query);
	
	$query_between = "select method, count(method) as cnt_method from log_entry where 
	(STR_TO_DATE(log_date , '%d/%b/%Y:%H:%i:%s') between '".$dt_start."' and '".$dt_end."') group by method;";
	$result_between = mysqli_query($conn, $query_between);
	
	$table_data = array();
	
	if(isset($dt_start) and !isset($dt_end)){
	while($row = mysqli_fetch_array($result)){
		
		$table_data[] = array(
		'method'				=> $row["method"],
		'cnt'               => $row["cnt_method"]

		);
	}
	}
	
	if(isset($dt_start) and isset($dt_end)){
	while($row = mysqli_fetch_array($result_between)){
		
		$table_data[] = array(
		'method'				=> $row["method"],
		'cnt'               => $row["cnt_method"]

		);
	}
	}
	
	return json_encode($table_data);
}

echo '<pre>';
print_r(get_method_data());
echo '</pre>';

//create JSON file on file system
$file_name = date('d-m-Y').'.json';
if(file_put_contents($file_name, get_method_data())){
	echo $file_name . 'file created';
}
else{
	echo 'There is some error';
}

?> 
