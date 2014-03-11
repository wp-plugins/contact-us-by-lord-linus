<div class="span12" style="margin-top:20px;">
<div class="span4">

<div class="alert alert-info">
<p>Now You can easily show your Contact us page into your <strong>Facebook Fan Page</strong>. This section adds a tab to your facebook fan page by clicking
on that tab your fans will be able to contact with you through facebook page only
For installation, you have to do one time work. simply follow the given steps in the right hand side :</p>
<h4>Enter your Facebook App Code here</h4>

<form action="#" method="post">
<input type="text" name="fbcode" value="<?php echo get_option('lorlinus_fb_code');?>" required="required">
<input type="submit" name="submittfb" class="btn btn-primary" value="Submit">
</form>
<?php
if((get_option('lorlinus_fb_code')) OR isset($_POST['submittfb']))
{
	$return_uri = "http://".$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	if(isset($_POST['fbcode']))
	{
	   $fbcode = $_POST['fbcode'];
	}
	else
		$fbcode = get_option('lorlinus_fb_code');
	update_option('lorlinus_fb_code',$fbcode);
	?>
	<a href= "http://www.facebook.com/dialog/pagetab?app_id= <?php echo $fbcode;?>&next=<?php echo $return_uri;?>">
	<img src="<?php echo plugins_url('/facebook/install.jpg', __FILE__); ?>"> </a>
	<?php
	if(isset($_GET['tabs_added']))
	{
		echo "<br/><div class='alert alert-success'>Your tab has been added successfully. Please check your facebook page to see it in action</div>";
	}
	
}

?>
</div>
</div>

<div class="span7 alert alert-danger">
<h3>Instruction to embed contact form page on your facebook fan page</h3>
<p>
<strong> Step 1 : </strong> Create a Facebook Fan Page (if you dont have any facebook fan page). <a href="http://rohitashv.wordpress.com/2013/03/22/facebook-create-a-facebook-fan-page/" target="_blank">Here is a simple tutorial </a>to create a facebook fan page
<br/><br/>
<strong> Step 2: </strong> Login to your <a href="http://developers.facebook.com/" target="_blank"> Facebook Developer Account </a>. You will see a screen as given in the following pic:
<br/><br/>
<img src="<?php echo plugins_url('/facebook/1.jpg', __FILE__); ?>">
<br/>
<br/>
<strong> Step 3: </strong> If you are coming to this site for the first time then you can click on "Register as a developer", After that you will be asked to accept the terms, verfiy 
your phone no and then proceed further. complete the steps : 
<br/><br/>
<img src="<?php echo plugins_url('/facebook/3.jpg', __FILE__); ?>">
<br/><br/>
<strong> Step 4:</strong> In the next screen Click on "Create New App" Button given on right top corner, you will see the screen given below:<br/><br/>
<img src="<?php echo plugins_url('/facebook/7.jpg', __FILE__); ?>">
<br/><br/>

In this you have to fill the following details : <br/><br/>
<strong>1 . Display Name : </strong> Name which you want to show on facebook tab (eg Contact Us)<br/><br/>
<strong>2 . App Domain : </strong> Name of your domain like localhost or example.com (dont start with http or https)<br/><br/>
<strong>3 . Click on "Page Tab Option" :</strong> <br/><br/>
<strong>4 . Page Tab name : </strong> Name of your tab <br/><br/>
<strong>5 . Page tab url : </strong> Url of your contact us page (http://example.com/contact-us), on click of your page tab,this page will be shown on your facebook fan page<br/><br/>
<strong>6 . Secure page tab url : </strong> This is same as Page tab url except that it starts with https instead of http
<br/><br/>
<strong> Step 5: </strong> Save the changes and copy the "Facebook App Id" and paste it in the above given text box and submit the code, this app id 
can be found with the help of this pic :<br/><br/>
<img src="<?php echo plugins_url('/facebook/9.jpg', __FILE__); ?>">

<br/><br/>In case of any query you can contact us through wordpress support center or via mail at info[at]businessadwings[dot]com<br/><br/>
</p>
</div>
</div>