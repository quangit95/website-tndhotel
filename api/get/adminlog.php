<?php
if(isset($_SESSION["adminlog"])) {
	$code = 200;
	$dataResponse = ["isAdmin"=>1, "list"=> [
			[],
			[]
		] 
	];
} else {

}
?>