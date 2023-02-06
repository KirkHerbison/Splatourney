
<?php require_once 'header.php'; 
	// See if $error has been set in the file that is including error.php
	// If not $error a default value.
	if(!isset($error))
		$error = 'Unknown error';
?>

       <div>
       <h1 class="top">Error Page</h1>
        <p class="first_paragraph"><?php  if(isset($error)) echo $error; ?></p>
        <p><a href = "javascript:history.back()">Back to previous page</a></p>
    </div>

<?php require_once 'footer.php'; ?>