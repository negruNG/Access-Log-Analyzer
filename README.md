## Access-Log-Analyzer

**Technology stack**

1\. Core PHP<br/>
2\. MySQL<br/>
3\. HTML<br/>
4\. Apache Web Server (with XAMPP)<br/>

**Setup instructions**

1\. Copy the project folder to **xampp/htdocs** path. If you are using some other tool for Apache Web Server (like WAMP), please see the documentation for it.<br/>
2\. Run **.sql** scripts.<br/>
3\. Set your database parameters in **DataSource.php** script.<br/>

**About Access-Log-Analyzer**

1\. For listing of available uploaded logs, see **list.php script**.<br/>
You can call this script by entering the following in your web browser: **localhost/project/list.php**<br/>

2\. For uploading log files, see **upload_log.php** script.<br/> 
You can call this script by entering the following in your web browser: **localhost/project/log/upload_log.php**<br/>

3\. For deletion of log files, see **delete_log.php** script.<br/> 
You can call this script by entering the following in your web browser: **localhost/project/log/delete_log.php**

4\. For downloading of log files, see **download_log.php** script.<br/> 
You can call this script by entering the following in your web browser: **localhost/project/log/download_log.php**

5\. For aggregation by IP, see **aggregate_ip.php** script.<br/> 
You can call this script by entering the following in your web browser (this is just an example):<br/> 
**localhost/project/aggregate/ip/aggregate_ip.php?dt_start=2020-11-23 13:47:14&dt_end=2020-11-23 13:47:22**

6\. For aggregation by HTTP method, see **aggregate_method.php** script.<br/> 
You can call this script by entering the following in your web browser (this is just an example):<br/> 
**localhost/project/aggregate/method/aggregate_method.php?dt_start=2020-11-23 13:47:14&dt_end=2020-11-23 13:47:22**<br/> 

7\. For aggregation by URL, see **aggregate_url.php** script.<br/> 
You can call this script by entering the following in your web browser (this is just an example):<br/>  
**localhost/project/aggregate/url/aggregate_url.php?dt_start=2020-11-23 13:47:14&dt_end=2020-11-23 13:47:22**<br/> 

8\. The following PHP scripts create **JSON** files on file system: **list.php, upload_log.php, aggregate_ip.php, aggregate_method.php, aggregate_url.php.**<br/> 
By calling aggregation scripts, **CSV** file is created. It merges (aggregates) all uploaded logs into one file.<br/>  

9\. There are two non-related tables:<br/>
-	**log_description**<br/>
-	**log_entry**<br/>
**log_description** gives details about **name, upload time, size**. <br/>
**log_entry** gives details about each log entry, as given from your example log file:<br/>
 https://temp-bucket-will-be-deleted.s3.amazonaws.com/access.log.gz<br/>
From this table, data is deleted on every new start of aggregation operation. Because of that, it won’t get overpopulated by data.<br/>


