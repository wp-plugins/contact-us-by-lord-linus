<?php
/* 	Plugin Name: Contact Us By Lord Linus
	Plugin Uri: http://rohitashv.wordpress.com
	Description: This plugin gives you the facility to add a good contact form on your site with a simple shortcode [LORDLINUS_CONTACT_FORM]
	Version: 2.1
	Author: lordlinus
	Author URI: http://businessadwings.com/contact-us
	Licence: GPVl
*/
?>
<?php
register_activation_hook( __FILE__, 'Contact_InstallScript' );
function Contact_InstallScript()
{
	include('install-script.php');
}
function contect_us_menu()
{
	echo "<link rel='stylesheet' type='text/css' href='".plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__)."' />";
	add_menu_page( 'Contact Us', 'Contact Us', 'administrator','contect-us' ,'contect_us',plugins_url('/sms.png',__FILE__));
	add_submenu_page('contect-us', 'Contact Us','Entries','administrator','entries-lord','entries_lord');
	add_submenu_page('contect-us', 'Contact Us','Uninstall','administrator','uninstall','uninstall');
	add_submenu_page('contect-us', 'Contact Us','Embed on Facebook','administrator','facebookembd','facebookembd');
	
}
function facebookembd()
{
	include "facebookembd.php";
}
function entries_lord()
{
	global $wpdb;
	//include("pagination.class.php");
	$o = get_option('lorlinus_contact_us_form');
	//$lord_linus = new contact_class;
	//print_r($lord_linus->contact_show_form());
	$items = mysql_num_rows(mysql_query("SELECT * FROM lord_linus_contact_form;"));
	
	if($items > 0) {
			$p = new pagination;
			$p->items($items);
			$p->limit(10); // Limit entries per page
			$p->target("admin.php?page=entries-lord");
			$p->currentPage($_GET[$p->paging]); // Gets and validates the current page
			$p->calculate(); // Calculates what to show
			$p->parameterName('paging');
			$p->adjacents(1); //No. of page away from the current page
					 
			if(!isset($_GET['paging'])) {
				$p->page = 1;
			} else {
				$p->page = $_GET['paging'];
			}
			 
			//Query for limit paging
			$limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
			 
	} else {
		echo "No Record Found";
	}
?>
 
<div class="wrap">
    <h2>List of Contacts who sent you messages</h2>
 
 
<table class="widefat">
<thead>
   <tr><th>Sr no</th><th>Name</th><th>Email</th><th>Message</th>
        <?php
		for($i=1;$i<6;$i++)
		{
			if($o['field_'.$i]!='')
			{	
				$x = $o['field_'.$i];
				echo "<th> $x </th>";
			}
		}
		?>
    </tr>
</thead>
<tbody>
 <?php
$sql = "SELECT *  FROM `lord_linus_contact_form` ORDER BY id DESC $limit";
$result = mysql_query($sql) or die ('Error, query failed');
 
if (mysql_num_rows($result) > 0 ) {
	$id = 0;
    while ($row = mysql_fetch_assoc($result)) {
            $id             = $id+1;
            $fullname  = htmlentities($row['name']);
            $email       = htmlentities($row['email']);
			$message = htmlentities($row['message']);
 ?>
        <tr style="height:35px;">
            <td><?php echo $id; ?></td>
            <td><?php echo $fullname; ?></td>
            <td><?php echo $email; ?></td>
			<td><?php echo $message; ?></td>
        </tr>
<?php }
} else { ?>
        <tr>
        <td>No Record Found!</td>
        <tr> 
<?php } ?>
</tbody>
</table>

<div class="tablenav">
    <div class='tablenav-pages'>
        <?php echo $p->show();  // Echo out the list of paging. ?>
    </div>
</div>
</div>
	
<?php	
}
function uninstall()
{
	include "uninstall_plugin.php";
}
function contect_us()
{

if ( isset($_POST['save']) )
	{
		$to = htmlentities($_POST['to_email']);
		if ( empty($to) )
			$to = get_option('admin_email');
		$msg_ok = htmlentities($_POST['msg_ok']);
		if ( empty($msg_ok) )
			$msg_ok = "Thank you! Your message was sent successfully.";
		$msg_err = htmlentities($_POST['msg_err']);
		if ( empty($msg_err) )
			$msg_err = "Sorry. An error occured while sending the message!";
		//$captcha = ( isset($_POST['captcha']) ) ? 1 : 0;
		$hideform = ( isset($_POST['hideform']) ) ? 1 : 0;
		
		$o = array(
			'to_email'		=> $to,
			'from_email'	=> htmlentities($_POST['from_email']),
			'msg_ok'		=> $msg_ok,
			'msg_err'		=> $msg_err,
			'submit'		=> htmlentities($_POST['submit']),
			//'captcha'		=> $captcha,
			//'captcha_label'	=> stripslashes($_POST['captcha_label']),
			'field_1'		=>htmlentities($_POST['field_1']),
			'field_2'		=> htmlentities($_POST['field_2']),
			'field_3'		=> htmlentities($_POST['field_3']),
			'field_4'		=> htmlentities($_POST['field_4']),
			'field_5'		=> htmlentities($_POST['field_5']),
			'hideform'			=> $hideform
			);
		update_option('lorlinus_contact_us_form', $o);
	}
	$o = get_option('lorlinus_contact_us_form');
	?>
	
	<div id="poststuff" class="wrap">
		<h2>Contact Us Form By Lord Linus</h2>
		<div class="postbox">
		<h3><?php echo "Options"; ?></h3>
		<div class="inside">
		
		<form action="?page=contect-us" method="post">
	   
	    	<div class="alert alert-info"><strong><?php echo "How to use this contact form"; ?></strong><br/><br/>
			To use this contact form simply use: <b>[LORDLINUS_CONTACT_FORM]</b> into your post or page
			</div>
		 
			<h3><strong><?php echo "Form"; ?></strong></h3>
		<table class="form-table">
    	<tr>
			<th><?php echo "To"; ?></th>
			<td><input name="to_email" type="text" size="70" value="<?php echo $o['to_email'] ?>" /><br />
			<?php echo "Put email, to which you want the contact form"; ?></td>
		</tr>
    	<tr>
			<th><?php echo "From";?> <?php echo " Optional"; ?></th>
			<td><input name="from_email" type="text" size="70" value="<?php echo $o['from_email'] ?>" /><br /><?php echo "Email"; ?></td>
		</tr>
    	<tr>
			<th><?php echo "Thank You message";?></th>
			<td><input name="msg_ok" type="text" size="70" value="<?php echo $o['msg_ok'] ?>" /></td>
		</tr>
    	<tr>
			<th><?php echo "Error Message:"; ?></th>
			<td><input name="msg_err" type="text" size="70" value="<?php echo $o['msg_err'] ?>" /></td>
		</tr>
		
    	<tr>
			<th><?php echo "Additional Fields";?></th>
			<td>
				<p><?php echo "The contact form includes the fields Name, Email, Subject and Message. To add more fields simply add them below"; ?></p>
				<?php
				for ( $x = 1; $x <= 5; $x++ )
					echo '<p>'.'Field'.' '.$x.': <input name="field_'.$x.'" type="text" size="30" value="'.$o['field_'.$x].'" /></p>';
				?>
			</td>
		</tr>
    	<tr>
			<th><?php echo "Once Submitted"; ?>:</th>
			<td><label for="hideform"><input name="hideform" id="hideform" type="checkbox" <?php if($o['hideform']==1) echo 'checked="checked"' ?> /> 
			<?php echo "hide the form"; ?></label></td>
		</tr>
		</table>
		<p class="submit">
			<input name="save" class="button-primary" value="<?php echo "Save Changes"; ?>" type="submit" />
		</p>
		</form>
	</div>
	</div>
	

	
	</div>
<?php
}
add_action( 'admin_menu','contect_us_menu' );
add_action('wp_head', 'addStyle');
function addStyle()
{
	echo "\n<!-- Contact Us Form -->\n"
			."<style type=\"text/css\">\n"
			.".cuf_input {display:none !important; visibility:hidden !important;}\n"
			."#contactsubmit:hover, #contactsubmit:focus {
	background: #849F00 repeat-x;
	color: #FFF;
	text-decoration: none;
	}
	#contactsubmit:active {background: #849F00}
	#contactsubmit {
		color: #FFF;
		background: #738c00 repeat-x;
		display: block;
		float: left;
		height: 28px;
		padding-right: 23px;
		padding-left: 23px;
		font-size: 12px;
		text-transform: uppercase;
		text-decoration: none;
		font-weight: bold;
		text-shadow: 0px 1px 0px rgba(0, 0, 0, 0.2);
		filter: dropshadow(color=rgba(0, 0, 0, 0.2), offx=0, offy=1);
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		-webkit-transition: background 300ms linear;
	-moz-transition: background 300ms linear;
	-o-transition: background 300ms linear;
	transition: background 300ms linear;
	-webkit-box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.2);
	box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.2);
	text-align:center
	}
	.cuf_field {
		-moz-box-sizing:border-box;
		-webkit-box-sizing:border-box;
		box-sizing:border-box;
		background:#fff;
		border:1px solid #A9B3BC;
		padding:8px;
		width:100%;
		margin-top:5px;
	margin-bottom:15px;
		outline:none
	}
	#tinyform {
	clear: both;
		width:500px;
		margin-left:auto;
		margin-right:auto;
		/*margin-top:30px;*/
		padding:20px;
		-webkit-border-radius:5px;
		-moz-border-radius:5px;
		border-radius:5px;
		-webkit-box-shadow:0px 0px 10px 0px rgba(0,0,0,0.2);
		-moz-box-shadow:0px 0px 10px 0px rgba(0,0,0,0.2);
		box-shadow:0px 0px 10px 0px rgba(0,0,0,0.2);
		border:4px solid #FFF;
		-webkit-transition:all 200ms linear;
		-moz-transition:all 200ms linear;
		-o-transition:all 200ms linear;
		transition:all 200ms linear;
	}
	.cuf_textarea {
		-moz-box-sizing:border-box;
		-webkit-box-sizing:border-box;
		box-sizing:border-box;
		background:#fff;
		border:1px solid #A9B3BC;
		padding:8px;
		width:100%;
		margin-top:5px;
		outline:none;
	margin-bottom:15px;
	}\n"
				."</style>\n";
}
add_shortcode('LORDLINUS_CONTACT_FORM','contact_form_shorcode');
function contact_form_shorcode()
{
	$lord_linus = new contact_class;
	print_r($lord_linus->contact_show_form());
}
add_shortcode('LORDLINUS_CONTACT_WIDGET','contact_form_widget');
function contact_form_widget()
{

	echo "<style>#support_btn {top: 50%!important;background: #FECC33!important;border-radius: 0px 0px 7px 7px;font-family: Arial, Helvetica, sans-serif;border: solid 2px #fff;margin: 0;cursor: pointer;overflow: hidden;position: fixed;height: 25px;min-width: 110px;z-index: 10000;white-space: nowrap;padding: 0 10px 35px 10px;}#support_btn:hover {background:#F7D55B!important}#support_btn #middle_left_text {float: left;font-size: 22px;font-weight: bold;text-align: center;color: #444;letter-spacing: 1px;margin-top: 25px;margin-left: 10px;text-decoration:none;}#support_btn.middle_left {left: -50px;background-position: right 0;-webkit-transform: rotate(-90deg);-moz-transform: rotate(-90deg);-o-transform: rotate(-90deg);-ms-transform: rotate(-90deg);transform: rotate(-90deg);}</style> ";
	echo "<div class='middle_left' id='support_btn'><div id='middle_left_text'><a href='#ex1' rel='modal:open'>Contact Us</a></div></div>";
	?>
	<div class='modal' id='ex1' style='display:none;'>
	<?php
	$lord_linus = new contact_class;
	echo "<input type='hidden' name='modal' value='xyz'>";
	print_r($lord_linus->contact_show_form());
	?>
	</div>
	<?php
	echo "<link rel='stylesheet' type='text/css' href='".plugins_url('/bootstrap-assets/css/jquery.modal.css', __FILE__)."' />";
	echo "<script src='".plugins_url('/bootstrap-assets/css/jquery.modal.min.js', __FILE__)."' />";

}
class contact_class
{
	
	var $cuf_script_printed = 0;
	function contact_show_form($params = '')
	{
		$n = ($nr == 0) ? '' : $nr;
		$nr++;
		if ( isset($_POST['cuf_sender'.$n]) )
		$result = $this->sendMail( $n, $params );
		
		$o = get_option('lorlinus_contact_us_form');
		$form = '<div class="contactform" id="cuform'.$n.'">';
		if ( !empty($result) )
		{
			
			if ( $result == $this->o['msg_ok'] )

				$form .= '<p class="contactform_respons">'.$result.'</p>';
			else

				$form .= '<p class="contactform_error">'.$result.'</p>';
		}
			
		if ( empty($result) || (!empty($result) && !$this->o['hideform']) )
		{
			if ( !empty($_POST['cuf_subject'.$n]) )
				$cuf_subject = $_POST['cuf_subject'.$n];
			else if ( is_array($params) && !empty($params['subject']))
				$cuf_subject = $params['subject'];
			else if ( empty($_POST['cuf_subject'.$n]) && !empty($_GET['subject']) )
				$cuf_subject = $_GET['subject'];

			else if ( empty($_POST['cuf_subject'.$n]) && !empty($this->userdata['subject']) )
				$cuf_subject = $this->userdata['subject'];
			else
				$cuf_subject = '';
				
			$cuf_sender = (isset($_POST['cuf_sender'.$n])) ? $_POST['cuf_sender'.$n] : ''; 
			$cuf_email = (isset($_POST['cuf_email'.$n])) ? $_POST['cuf_email'.$n] : '';
			$cuf_msg = (isset($_POST['cuf_msg'.$n])) ? $_POST['cuf_msg'.$n] : '';
			
			$form .= '
				<form action="" method="post" id="tinyform'.$n.'">
				<div>
				<label for="cuf_sender'.$n.'" class="cuf_label"> Name :</label>
				<input name="cuf_sender'.$n.'" id="cuf_sender'.$n.'" size="30" value="'.$cuf_sender.'" class="cuf_field" />
				<label for="cuf_email'.$n.'" class="cuf_label"> E-Mail :</label>
				<input name="cuf_email'.$n.'" id="cuf_email'.$n.'" size="30" value="'.$cuf_email.'" class="cuf_field" />';
			for ( $x = 1; $x <=5; $x++ )
			{
				$i = 'cuf_field_'.$x.$n;
				$cuf_f = (isset($_POST[$i])) ? $_POST[$i] : '';
				$f = $o['field_'.$x];
				if ( !empty($f) )
					$form .= '
					<label for="'.$i.'" class="cuf_label">'.$f.':</label>
					<input name="'.$i.'" id="'.$i.'" size="30" value="'.$cuf_f.'" class="cuf_field" />';
			}
			$form .= '
				<label for="cuf_subject'.$n.'" class="cuf_label"> Subject :</label>
				<input name="cuf_subject'.$n.'" id="cuf_subject'.$n.'" size="30" value="'.$cuf_subject.'" class="cuf_field" />
				<label for="cuf_msg'.$n.'" class="cuf_label"> Your Message:</label>
				<textarea name="cuf_msg'.$n.'" id="cuf_msg'.$n.'" class="cuf_textarea" cols="50" rows="10">'.$cuf_msg.'</textarea>
				';
			$title = (!empty($o['submit'])) ? 'value="'.$o['submit'].'"' : '';
			$form .= '	
				<input type="submit" value="submit'.$n.'" name="submit'.$n.'" id="contactsubmit'.$n.'" class="cuf_submit" '.$title.'  onclick="return checkForm(\''.$n.'\');" />
				</div>
				<div style="clear:both;"></div>
				</form>';
		}
		
		$form .= '</div>'; 
		$form .= $this->addScript();
		return $form;
	}
	
	function addScript()
	{
		global $cuf_script_printed;
		if ($cuf_script_printed) 
			return;
		
		$script = "
			<script type=\"text/javascript\">
			function checkForm( n )
			{
				var f = new Array();
				f[1] = document.getElementById('cuf_sender' + n).value;
				f[2] = document.getElementById('cuf_email' + n).value;
				f[3] = document.getElementById('cuf_subject' + n).value;
				f[4] = document.getElementById('cuf_msg' + n).value;
				f[5] = f[6] = f[7] = f[8] = f[9] = '-';
			";
		for ( $x = 1; $x <=5; $x++ )
			if ( !empty($this->o['field_'.$x]) )
				$script .= 'f['.($x + 4).'] = document.getElementById("cuf_field_'.$x.'" + n).value;'."\n";
		$script .= '
			var msg = "";
			for ( i=0; i < f.length; i++ )
			{
				if ( f[i] == "" )
					msg = "Please Fill the required details\n\n";
			}
			if ( !isEmail(f[2]) )
				msg += "Invalid Email";
			if ( msg != "" )
			{
				alert(msg);
				return false;
			}
		}
		function isEmail(email)
		{
			var rx = /^([^\s@,:"<>]+)@([^\s@,:"<>]+\.[^\s@,:"<>.\d]{2,}|(\d{1,3}\.){3}\d{1,3})$/;
			var part = email.match(rx);
			if ( part )
				return true;
			else
				return false
		}
		</script>
		';
		$cuf_script_printed = 1;
		return $script;
	}
	function sendMail( $n = '', $params = '' )
	{
		global $wpdb;
		$o = get_option('lorlinus_contact_us_form');
		$result = '';
		$to = $o['to_email'];
		
		$from	= $o['from_email'];
	
		$name	= $_POST['cuf_sender'.$n];
		$email	= $_POST['cuf_email'.$n];
		$subject= $_POST['cuf_subject'.$n];
		$msg	= $_POST['cuf_msg'.$n];
		
		$extra = array();
		foreach ($_POST as $k => $f )
			if ( strpos( $k, 'cuf_field_') !== false )
				$extra[] = $f;
		$extra = serialize($extra);
		$contact_form_query = "INSERT INTO `Lord_linus_contact_form` ( `id`, `name`, `email`, `subject`,`message`, `other_fields`)
								values ('','$name','$email','$subject','$msg','$extra')";
		$wpdb->query($contact_form_query);
		$headers =
		"MIME-Version: 1.0\r\n".
		"Reply-To: \"$name\" <$email>\r\n".
		"Content-Type: text/plain; charset=\"".get_settings('blog_charset')."\"\r\n";
		if ( !empty($from) )
			$headers .= "From: ".get_bloginfo('name')." - $name <$from>\r\n";
		else if ( !empty($email) )
			$headers .= "From: ".get_bloginfo('name')." - $name <$email>\r\n";

		$fullmsg =
		"Name: $name\r\n".
		"Email: $email\r\n".
		$extra."\r\n".
		'Subject: '.$_POST['cuf_subject'.$n]."\r\n\r\n".
		wordwrap($msg, 76, "\r\n")."\r\n\r\n".
		'Referer: '.$_SERVER['HTTP_REFERER']."\r\n".
		'Browser: '.$_SERVER['HTTP_USER_AGENT']."\r\n";
		
		if ( wp_mail( $to, $subject, $fullmsg, $headers) )
		{
			if ( $o['hideform'] )
			{
				unset($_POST['cuf_sender'.$n]);
				unset($_POST['cuf_email'.$n]);
				unset($_POST['cuf_subject'.$n]);
				unset($_POST['cuf_msg'.$n]);
				foreach ($_POST as $k => $f )
					if ( strpos( $k, 'cuf_field_') !== false )
						unset($k);
			}
			$result = $o['msg_ok'];
			
		}
		else
			$result = $o['msg_err'];
		return $result;
	}

}
?>