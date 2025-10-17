<?php

add_action( 'wp_ajax_getDatatableLogs', 'myfunc' );
function myfunc()
{
	$API_KEY=get_option('wpp_api_key');
	$columns = array( 
        0 =>'date', 
        1 =>'deliveryTime',
        2=> 'fromaddress',
        3=> 'rcptEmail',
        4=> 'modifyDate',
        5=> 'size',
        6=> 'status',
        7=> 'remarks'
    );

    $limit = $_POST['length'];
    $start = $_POST['start'];
    
    $curl = curl_init();

	      curl_setopt_array($curl, array(
	        CURLOPT_URL => "https://api.pepipost.com/v2/logs?enddate=2019-01-31&startdate=2018-01-01&limit=10",
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_ENCODING => "",
	        CURLOPT_MAXREDIRS => 10,
	        CURLOPT_TIMEOUT => 90,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => "GET",
	        CURLOPT_HTTPHEADER => array(
	          "api_key: ".$API_KEY
	        ),
	      ));
	       $posts = curl_exec($curl);
	      $err = curl_error($curl);

	      curl_close($curl);

	      if ($err) {
	        $posts=array();
	      } else {
	      	//print_r($posts);exit();
	        $posts=json_decode($posts,true);
	      }
    $count_api = $posts['totalRecords'];

   // echo $count_api; exit;
    $totalData= $count_api;
    $totalFiltered = $totalData;
    

    if(empty($_POST['search']['value']))
    {
    	$curl = curl_init();

	      curl_setopt_array($curl, array(
	        CURLOPT_URL => "https://api.pepipost.com/v2/logs?startdate=2018-01-01&limit=".$limit."&offset=".$start."&sort=desc",
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_ENCODING => "",
	        CURLOPT_MAXREDIRS => 10,
	        CURLOPT_TIMEOUT => 90,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => "GET",
	        CURLOPT_HTTPHEADER => array(
	          "api_key: ".$API_KEY
	        ),
	      ));

	      $posts = curl_exec($curl);
	      $err = curl_error($curl);

	      curl_close($curl);

	      if ($err) {
	        $posts=array();
	      } else {
	        $posts=json_decode($posts,true);
	      }
    }
    else
    {
    	$search=$_POST['search']['value'];
	      $curl = curl_init();

	      curl_setopt_array($curl, array(
	        CURLOPT_URL => "https://api.pepipost.com/v2/logs?startdate=2018-01-01&limit=".$limit."&offset=".$start."&sort=desc&email=".$search,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_ENCODING => "",
	        CURLOPT_MAXREDIRS => 10,
	        CURLOPT_TIMEOUT => 90,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => "GET",
	        CURLOPT_HTTPHEADER => array(
	          "api_key: ".$API_KEY
	        ),
	      ));

	      $posts = curl_exec($curl);
	      $err = curl_error($curl);

	      curl_close($curl);

	      if ($err) {
	        $posts=array();
	      } else {
	        $posts=json_decode($posts,true);
	      }
	      $totalFiltered=$posts['totalRecords'];
    }

    $data = array();
  if(!empty($posts))
  {
      foreach ($posts['data'] as $post)
      {
          $nestedData['date'] = date('d-m-Y h:i:s A',strtotime($post['requestedTime']));
          $nestedData['deliveryTime'] = date('d-m-Y h:i:s A',strtotime($post['deliveryTime']));
          $nestedData['fromaddress'] = $post['fromaddress'];
          $nestedData['rcptEmail'] = $post['rcptEmail'];
          $nestedData['modifyDate'] = date('d-m-Y h:i:s A',strtotime($post['modifiedTime']));
          $nestedData['size'] = $post['size'];
          $nestedData['status'] = $post['status'];
          $nestedData['remarks'] = $post['remarks'];
          
          $data[] = $nestedData;
      }
  }

  $json_data = array(
  "draw"            => intval($_POST['draw']),  
  "recordsTotal"    => intval($totalData),  
  "recordsFiltered" => intval($totalFiltered), 
  "data"            => $data   
  );

  echo json_encode($json_data);exit;
}
/**
 * This function outputs the plugin options page.
 */

if (!function_exists('wp_pepipost_options_page')) :
// Define the function
function wp_pepipost_options_page() {
	
	// Load the options
	global $wpp_options;
	global $is_test_mail;
	
	// Send a test mail if necessary
	if (isset($_POST['wpp_action']) && $_POST['wpp_action'] == __('Send Test', 'wp_pepipost') && isset($_POST['to'])) {
		$to = rtrim(trim($_POST['to']), ",");
		$to = ltrim($to, ",");
		if ( !filter_var($to, FILTER_VALIDATE_EMAIL)) { ?>
		     <div id="login_error" class="error"><p>Please enter valid email address.</p></div>
			 <?php 

			 if (isset($_POST['subject']) && strlen(trim($_POST['subject'])) > 0){?>
		     <!-- <div id="login_error" class="error"><p>Please enter valid email address.</p></div> -->
			 <?php
			 	//echo "Field cannot be blank";
			 }
		} else {
		
		    check_admin_referer('test-email');
		
		    // Set up the mail variables
		    $subject = !empty($_POST['subject']) ? trim($_POST['subject']) : 'Pepipost: ' . __('Test mail to ', 'wp_pepipost') . $to;
		    if ( !empty($_POST['message']) )
			    $message = $_POST['message'];
		    else
			    $message = __('This is a test email generated by the WP Pepipost WordPress plugin.', 'wp_pepipost');
		
		    $error = '';
		    try{
		        // Send the test mail
				$is_test_mail = true;
		        $result = wpp_send_email($to, $subject, $message);
				//echo "<pre>";print_r($result);die;
				if(!empty($result)&& isset($result['is_error']) && $result['is_error']) {
					$error  = isset($result['error']) ? $result['error'] : '';
					$result = false;
				}
		    } catch ( Exception $e ) {echo 'asdasdas';
				$error  = new WP_Error( $e->getMessage() );
				$result = false;
	        }
		    // Output the response
		?>
		<?php if ( $result ) { 
			 $test = 'Test Message Sent';
			 echo '<div id="message" class="updated fade"><p><strong>' . $test . '</strong></p></div>'; 
		?>

  <!-- <div id="message" class="updated"><p><strong><?php// _e('Test Message Sent', 'wp_pepipost'); ?></strong></p> -->
 <?php //var_dump($result); 
?>

</div>
<?php } else { 
        
?>
<div id="login_error" class="error fade"><p><strong><?php _e('Error while sending test message.', 'wp_pepipost'); ?></strong></p>
    <?php if ( !empty($error) ) {
        echo "<p><strong>$error</strong></p>";
    } ?>
</div>
<?php } ?>
	<?php
				    
	    }
	}//ends else part validations
	
	if( isset($_REQUEST['wp_pepipost_option']) && $_REQUEST['wp_pepipost_option'] == 1 ) {
		if ( !empty($_POST['mail_from']) )
			update_option( 'wpp_mail_from', trim($_POST['mail_from']));
		if ( !empty($_POST['mail_reply']) ) {
			update_option( 'wpp_mail_reply', trim($_POST['mail_reply']));
		}
		else
		{
			update_option( 'wpp_mail_reply', '');	
		}
		if ( !empty($_POST['mail_from_name']) ){
			update_option( 'wpp_mail_from_name', trim($_POST['mail_from_name']));
		}
		else
		{
			update_option( 'wpp_mail_from_name', '');	
		}
		if ( !empty($_POST['mailer']) )
			update_option( 'wpp_mailer', trim($_POST['mailer']));		
		if ( !empty($_POST['api_key']) )
			update_option( 'wpp_api_key', trim($_POST['api_key']));
		?>
		<div id="message" class="updated"><p><strong><?php _e('Settings saved successfully', 'wp_pepipost'); ?></strong></p></div>
<?php
	}
	
?>

<div class="wrap">
<div class="w-logo  with_transparent">
	<a class="w-logo-link" href="http://www.pepipost.com/">
		<span class="w-logo-img">
			<img class="for_transparent" src="<?php echo home_url(); ?>/wp-content/plugins/pepipost/images/Pepipost-Png1.png" alt="Pepipost: Cloud Based Triggered and Transactional Email Service">
		</span>
	</a>
	<span class="plugin-text"><h2>Pepipost Email API</h2></span>
	<div id="smtp_error" class="dspln"></div>
</div> <!-- end w-logo -->

<form method="post" action="admin.php?page=wp_pepipost">
<?php wp_nonce_field('wpp_email-options', 'email_options_field'); ?>

<table class="optiontable form-table">
<tr valign="top">
<th scope="row"><label for="mail_from"><?php _e('Api Key', 'wp_pepipost'); ?></label></th>
<td><input name="api_key" type="text" id="api_key" value="<?php print(get_option('wpp_api_key')); ?>" size="40" class="regular-text" required/>
<span class="description"><?php echo 'Enter your Pepipost API key here. You need to signup on <a href="https://app.pepipost.com/index.php/signup/registeruser?utm_campaign=PepiWP&utm_medium=PepiWP&utm_source=PepiWP" target=_blank>Pepipost. </a> In order to get this API key.'; if(get_option('db_version') < 6124) { print('<br /><span style="color: red;">'); _e('<strong>Please Note:</strong> You appear to be using a version of WordPress prior to 2.3. Please ignore the From Name field and instead enter Name&lt;email@domain.com&gt; in this field.', 'wp_pepipost'); print('</span>'); } ?></span></td>
</tr>
</table>

<h3><?php _e('Email Settings', 'wp_pepipost'); 
$frm_name = get_option('wpp_mail_from_name');
$frm_reply = get_option('wpp_mail_reply');
?></h3>
<table class="optiontable form-table">
<tr valign="top">
<th scope="row"><label for="mail_from_name"><?php _e('From Name', 'wp_pepipost'); ?></label></th>
<td><input name="mail_from_name" type="text" id="mail_from_name" value="<?php echo (isset($frm_name)) ? $frm_name: ''// print(get_option('wpp_mail_from_name'));//  ?>" size="40" class="regular-text"  />
<span class="description"><?php _e('Name that emails should be sent from. e.g. YourCompanyName', 'wp_pepipost'); ?></span></td>
</tr>	
<tr valign="top">
<th scope="row"><label for="mail_from"><?php _e('From Email', 'wp_pepipost'); ?></label></th>
<td><input name="mail_from" type="text" id="mail_from" value="<?php print(get_option('wpp_mail_from')); ?>" size="40" class="regular-text" />
<span class="description"><?php _e('Email address that emails should be sent from. e.g. info@yourdomain.com. Here, yourdomain.com should be pre-configured under your Pepipost account. [Settings --> Sending Domain]', 'wp_pepipost'); if(get_option('db_version') < 6124) { print('<br /><span style="color: red;">'); _e('<strong>Please Note:</strong> You appear to be using a version of WordPress prior to 2.3. Please ignore the From Name field and instead enter Name&lt;email@domain.com&gt; in this field.', 'wp_pepipost'); print('</span>'); } ?></span></td>
</tr>
<tr valign="top">
<th scope="row"><label for="mail_reply"><?php _e('Reply To', 'wp_pepipost'); ?></label></th>
<td><input name="mail_reply" type="text" id="mail_reply" value="<?php echo (isset($frm_reply)) ? $frm_reply: ''//print(get_option('wpp_mail_reply')); ?>" size="40" class="regular-text" autocomplete="off" />
<span class="description"><?php _e('Email address that should be set as Reply To.', 'wp_pepipost');  ?></span></td>
</tr>

</table>


<table class="optiontable form-table">
<!--tr valign="top">
<th scope="row"><?php //_e('Mailer', 'wp_pepipost'); ?> </th>
<td><fieldset><legend class="screen-reader-text"><span><?php //_e('Mailer', 'wp_pepipost'); ?></span></legend>
<p><input id="mailer_smtp" type="radio" name="mailer" value="api" <?php //checked('api', get_option('wpp_mailer')); ?> />
<label for="mailer_smtp"><?php //_e('Send all WordPress emails via Pepipost API.', 'wp_pepipost'); ?></label></p>
<p><input id="mailer_mail" type="radio" name="mailer" value="mail" <?php //checked('mail', get_option('wpp_mailer')); ?> />
<label for="mailer_mail"><?php //_e('Use the PHP mail() function to send emails.', 'wp_pepipost'); ?></label></p>
</fieldset></td>
</tr-->
</table>


<p class="submit"><input type="submit" name="submit" id="submit-pepipost" class="button-primary" value="<?php _e('Save Changes'); ?>" /></p>
</p>
<input type="hidden" name="wp_pepipost_option" value="1">
</form>

<h3><?php _e('Send a Test Email', 'wp_pepipost'); ?></h3>

<div id="show_error" class="dspln"></div>
<form method="POST" action="admin.php?page=wp_pepipost<?php //echo plugin_basename(__FILE__); ?>">
<?php wp_nonce_field('test-email'); ?>

<table class="optiontable form-table">
<tr valign="top">
<th scope="row"><label for="to"><?php _e('To:', 'wp_pepipost'); ?></label></th>
<td><input name="to" type="email" id="to" value="" size="40" class="code" required="true" />
<span class="description"><?php _e('Type your email address here.', 'wp_pepipost'); ?></span></td>
</tr>

<tr valign="top">
<th scope="row"><label for="to">Subject</label></th>
<td><input name="subject" type="text" id="subject" value="" size="40" class="code" required="true"/>
<span class="description">Type your email subject here.</span></td>
</tr
<tr valign="top">
<th scope="row"><label for="to">Message</label></th>
<td><textarea name="message" id="email_message" class="code" required="true"></textarea>
<span class="description">Type your message here.</span></td>
</tr>
</table>
<p class="submit"><input type="submit" name="wpp_action" id="wpp_action" class="button-primary" value="<?php _e('Send Test', 'wp_pepipost'); ?>" /></p>
<span class="send_btn_text">If you still have any queries, we are just a chat away! Visit our <a href="https://docs.pepipost.com/" target="_blank"><b>documentation</b></a> or contact on our website <a href="https://pepipost.com/" target="_blank"> <b>chat</b></a></span>
</form>

</div> <!-- end wrap -->
	<?php
	
} // End of wp_pepipost_options_page() function definition
endif;



/**
 *	Stats function to show all statistics data
 *	fetched using pepipost api
 */
if (!function_exists('wp_pepipost_logs')) {
	function wp_pepipost_logs() {
	    //create the object for class, if not exits
        if ( !isset($obj) )
            $obj = new Logs();

//global $wpp_options;



?>
<div class="middle">

<div class="content-header">
<h3 class="clr">Email Logs</h3>
</div>

<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>From Address</th>
                <th>Email</th>
                <th>Size (bytes)</th>
                <th class="deliveryTime">Delivery Time</th>
                <th class="modifiedTime">Modified Time</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <!-- <tbody>
          <?php //foreach ($rows['data'] as $row) {?>
            <tr>
                <td><?php //echo date('Y-m-d H:i:s',strtotime($row['requestedTime'])); ?></td>
                <td><?php //echo $row['fromaddress']; ?></td>
                <td><?php //echo $row['rcptEmail']; ?></td>
                <td><?php //echo $row['size']; ?></td>
                <td><?php //echo $row['deliveryTime']; ?> </td>
                <td><?php //echo date('Y-m-d H:i:s',strtotime($row['modifiedTime'])); ?></td>
                <td><?php //echo $row['status']; ?></td>
                <td><?php //echo $row['remarks']; ?></td>
            </tr>
          <?php //} ?>
        </tbody> -->
        <tfoot>
            <tr>
                <th>Date</th>
                <th>From Address</th>
                <th>Email</th>
                <th>Size (bytes)</th>
                <th>Delivery Time</th>
                <th>Modified Time</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </tfoot>
    </table>

</div>



<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
 
 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>

<script type="text/javascript">
  //<![CDATA[
    $j = jQuery.noConflict();
  $j(document).ready(function() {
    $j('#example').DataTable({
        "bSort": false,
        "processing": true,
        "serverSide": true,

        "columns": [
			{ "data": "date" },
			{ "data": "fromaddress" },
			{ "data": "rcptEmail" },
			{ "data": "size" },
			{ "data": "deliveryTime" },
			{ "data": "modifyDate" },
			{ "data": "status" },
			{ "data": "remarks" }
			
		],
        "ajax":{
            url :"<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php",
            type: "post", 
            data: {action:'getDatatableLogs'},
        },
        language: {
        searchPlaceholder: "Recipients Email",        
    },
        
'columnDefs' : [     // see https://datatables.net/reference/option/columns.searchable
    { 
       'searchable'    : false, 
       'targets'       : [0,1,3,4,5,6,7], 
    }
]
    });
} );
  //]]>
</script>


<?php

	}
}// end of logs



/**
 *	Stats function to show all statistics data
 *	fetched using pepipost api
 */
if (!function_exists('wp_pepipost_stats')) {
	function wp_pepipost_stats() {
	    //create the object for class, if not exits
        if ( !isset($obj) )
            $obj = new Logs();
            
		?>

<div class="wrap">

<!-- Display common html strucure -->
<?php echo $obj->common_html(); ?>
<br>

<h2><?php _e('Stats', 'wp_peipost'); ?></h2>

<?php
	$date = date("d M, Y");
	$start_date = date('Y-m-d');
	$end_date = date('Y-m-d');
	$get_stats = $obj->get_stats( $start_date, $end_date );

	$today_data = isset($get_stats['data']) ? $get_stats['data'] : array();
	
	if ( isset($_POST['dateRangeFormSubmit']) && !empty($_POST['dateRangeFormSubmit']) ) {
		$start_date = date('Y-m-d', strtotime($_POST['wpp_from_date']));
		$end_date = date('Y-m-d', strtotime($_POST['wpp_to_date']));
	} else {

		$start_date = date('Y-m-01');
		$end_date = date('Y-m-t');
	}
	$get_stats = $obj->get_stats( $start_date, $end_date );
    $monthly_data = isset($get_stats['data']) ? $get_stats['data'] : array();
	$monthly_sent = 0;
	$monthly_bounce = 0;
	$monthly_open = 0;
	$monthly_click = 0;
	$monthly_dropped = 0;
	$monthly_invalid = 0;
	$monthly_unsub = 0;
	$monthly_spam = 0;
	//echo '<pre>';print_r($monthly_data);echo '</pre>';
	if ( !empty($monthly_data) && is_array($monthly_data) ) {
		foreach ( $monthly_data as $monthly ) {
			$monthly_sent += $monthly['stats'][0]['metrics']['sent'];
			$monthly_bounce += $monthly['stats'][0]['metrics']['bounce'];
			$monthly_open += $monthly['stats'][0]['metrics']['open'];
			$monthly_click += $monthly['stats'][0]['metrics']['click'];
			$monthly_dropped += $monthly['stats'][0]['metrics']['dropped'];
			$monthly_invalid += $monthly['stats'][0]['metrics']['invalid'];
			$monthly_unsub += $monthly['stats'][0]['metrics']['unsub'];
			$monthly_spam += $monthly['stats'][0]['metrics']['spam'];
		}
	}

	$max_days = date('t');
	$data     = [];

	for( $i = 0; $i < $max_days; $i++ ) {
		$data[] = [
            'y'     => isset( $monthly_data[$i] ) ? $monthly_data[$i] : 0,
            'label' => isset( $monthly_data[$i] ) ? $monthly_data[$i] : 0
        ];
	}

?>
<h4>Report for <?php echo $date; ?></h4>

<script type="text/javascript">
window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer",
	{
		animationEnabled: true,
		title:{
			text: ""
		},
		axisX: {
			title: "<?php echo $date; ?>",
        },
        
		data: [
		{
			type: "column", //change type to bar, line, area, pie, etc
			indexLabel: "{y}",
            indexLabelPlacement: "outside",  
            indexLabelOrientation: "horizontal",
			dataPoints: [
		{  y: <?php echo empty( $today_data[0]['stats'][0]['metrics']['sent'] ) ? 0 : $today_data[0]['stats'][0]['metrics']['sent']; ?>, label: "Delivered" },
        {  y: <?php echo empty( $today_data[0]['stats'][0]['metrics']['bounce'] ) ? 0 : $today_data[0]['stats'][0]['metrics']['bounce']; ?>, label: "Bounced"},
        {  y: <?php echo empty( $today_data[0]['stats'][0]['metrics']['open'] ) ? 0 : $today_data[0]['stats'][0]['metrics']['open']; ?> , label: "Opened"},
        {  y: <?php echo empty( $today_data[0]['stats'][0]['metrics']['click'] ) ? 0 : $today_data[0]['stats'][0]['metrics']['click']; ?>, label: "Clicked" },
        {  y: <?php echo empty( $today_data[0]['stats'][0]['metrics']['dropped'] ) ? 0 : $today_data[0]['stats'][0]['metrics']['dropped']; ?>, label: "Dropped" },
        {  y: <?php echo empty( $today_data[0]['stats'][0]['metrics']['invalid'] ) ? 0 : $today_data[0]['stats'][0]['metrics']['invalid']; ?>, label: "Invalid"},
        {  y: <?php echo empty( $today_data[0]['stats'][0]['metrics']['unsub'] ) ? 0 : $today_data[0]['stats'][0]['metrics']['unsub']; ?>, label: "Unsubscribes"},
        {  y: <?php echo empty( $today_data[0]['stats'][0]['metrics']['spam'] ) ? 0 : $today_data[0]['stats'][0]['metrics']['spam']; ?>, label: "Spam"}
        
        ]
		}
		]
	});
 
	chart.render();
	
	//Second chart
	var chart = new CanvasJS.Chart("chartContainerSec",
	{
		animationEnabled: true,
		title:{
			text: ""
		},
		axisX: {
			title: "<?php echo date('d M', strtotime($start_date)); echo ' - ';echo date('d M, Y', strtotime($end_date)); ?>",
        },
		data: [
		{
			type: "column", //change type to bar, line, area, pie, etc
			indexLabel: "{y}",
            indexLabelPlacement: "outside",  
            indexLabelOrientation: "horizontal",
			dataPoints: [
		{  y: <?php echo empty( $monthly_sent ) ? 0 : $monthly_sent; ?>, label: "Delivered" },
        {  y: <?php echo empty( $monthly_bounce ) ? 0 : $monthly_bounce; ?>, label: "Bounced"},
        {  y: <?php echo empty( $monthly_open ) ? 0 : $monthly_open; ?> , label: "Opened"},
        {  y: <?php echo empty( $monthly_click ) ? 0 : $monthly_click; ?>, label: "Clicked" },
        {  y: <?php echo empty( $monthly_dropped ) ? 0 : $monthly_dropped; ?>, label: "Dropped" },
        {  y: <?php echo empty( $monthly_invalid ) ? 0 : $monthly_invalid; ?>, label: "Invalid"},
        {  y: <?php echo empty( $monthly_unsub ) ? 0 : $monthly_unsub; ?>, label: "Unsubscribes"},
        {  y: <?php echo empty( $monthly_spam ) ? 0 : $monthly_spam; ?>, label: "Spam"}
        
        ]
		}
		]
	});

	chart.render();
}
</script>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<div class="clear"></div>
<?php if ( isset($_POST['dateRangeFormSubmit']) && !empty($_POST['dateRangeFormSubmit']) ) { ?>
<script>
    jQuery(document).ready(function() {
        jQuery('#from_date').val( "<?php echo date( 'm/d/Y', strtotime($start_date) ); ?>" );
        jQuery('#to_date').val( "<?php echo date( 'm/d/Y',strtotime($end_date) ); ?>" );
    });
</script>
<?php } ?>
<div id="dateRangeDiv"><h4>From <?php echo date('d M, Y', strtotime($start_date)); ?> to <?php echo date('d M, Y', strtotime($end_date)); ?></h4>
<form id="dateRangeForm" method="post" action="admin.php?page=wp_pepipost_stats">
<?php wp_nonce_field('wpp_from_to', 'wpp_from_to_field'); ?>
<label for="from">From</label>
<input type="text" id="from_date" name="wpp_from_date" required >
<label for="to">to</label>
<input type="text" id="to_date" name="wpp_to_date" required>

<!-- Date range picker 
<div id="reportrange" style="background: #fff; cursor: pointer; padding: 10px 0px; border: 1px solid #ccc; width: 30%; z-index: 99999; position: absolute">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
</div> -->


<input type="hidden" name="dateRangeFormSubmit" value="1">
</form>
</div>
<div id="chartContainerSec" style="height: 300px; width: 100%;"></div>

<h3><a href="https://app.pepipost.com" target="_blank">For detailed statistics, please visit your Pepipost Dashboard</a>.</h3>

</div> <!-- end wrap -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
$(function() {

    var start = moment().subtract(90, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        	
    }, cb);

    cb(start, end);

});
</script>

<?php

	}
}// end of stats
