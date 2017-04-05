<?php
    /*
        * Error notice page
    */

    if (session_id() == "")
        session_start();

    include('header.php');
	
?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
			<div class="alert alert-danger" role="alert">                    
				<p class="text-center"><strong>The payment could not be completed. The error is :<br/> <?php echo($_GET["err"]); ?></strong></p>
			</div>
			<br />
			<br />

            Return to <a href="index.php">home page</a>.
        </div>
        <div class="col-md-4"></div>
    </div>
<?php
    include('footer.php');
?>