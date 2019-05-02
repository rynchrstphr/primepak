<?php 

	include 'core/db.php';

	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$que = "DELETE FROM loantypetbl WHERE id = '$id'";
	    if($db->query($que) === true)
	    {   
	        echo '<script type="text/javascript">'; 
	        echo 'alert("Loan Type Deleted Saved");'; 
	        echo 'window.location.href = "loantypes.php";';
	        echo '</script>';
	    }    
	    else
	    {
	      echo "ERROR: Could not able to execute $sql. " . $db->error;   
	    }
	}
		

?>