<!-- Download uploaded log -->
<?php

//turn off notices and errors
error_reporting(0);

$files = scandir("../uploads/");
for($a=2; $a <= count($files); $a++){
	?>
	<a download="<?php echo $files[$a] ?>" href="../uploads/<?php echo $files[$a] ?>"><?php echo $files[$a] ?></a>
	<?php
}


?>
