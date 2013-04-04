<?php
if(isset($_POST['uninstallapcal']))
{
	global $wpdb;
	$query = "DROP table `lord_linus_contact_form`";
	$wpdb->query($query);
	
	delete_option('lorlinus_contact_us_form');
	$plugin = "contact-us-by-lord-linus/contact-us.php";
	deactivate_plugins($plugin);
	?>
	<div class="alert" style="width:95%; margin-top:10px;">
			<p><strong>Plugin has been successfully removed. It can be re-activated from the
			<a href="plugins.php">Plugins Page</a></strong>.</p>
		</div>
		<?php
		return;
}
?>
<?php
if(isset($_GET['page']) == 'uninstall')
{
?>

<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
  <h3>Remove Plugin</h3> 
</div>

<div class="alert alert-error" style="width:95%;">
	<form method="post">
	<h3>Remove Contact us by lord linus plugin </h3>
	<p>This operation wiil delete all data & settings. If you continue, You will not be able to retrieve or restore your entries.</p>
	<p><button id="uninstallapcal" type="submit" class="btn btn-danger" name="uninstallapcal" value="" onclick="return confirm('Warning! data & settings, including appointment entries will be deleted. This cannot be undone. OK to delete, CANCEL to stop')">Remove Plugin</button></p>
	
	</form>
</div>

<?php

	}
?>