<?php
/*
Plugin Name: Simp Keyword Rank Tracker Pro
Plugin URI:  https://www.simp.store/simp-keyword-rank-tracker/
Description: With this plugin you can check weekly or daily rank of your web page on Google.
Version:     1.0
Author:      Simp Marketing
Author URI:  https://www.simpmarketing.com
License:     GPL2

*/
// Create a helper function for easy SDK access.
function skrt() {
    global $skrt;

    if ( ! isset( $skrt ) ) {
        // Include Freemius SDK.
        require_once dirname(__FILE__) . '/freemius/start.php';

        $skrt = fs_dynamic_init( array(
            'id'                  => '1996',
            'slug'                => 'simp_keyword_rank_tracker',
            'type'                => 'plugin',
            'public_key'          => 'pk_c183920b1cd95baf8251ab5b55841',
            'is_premium'          => true,
            'is_premium_only'     => true,
            // If your plugin is a serviceware, set this option to false.
            'has_premium_version' => true,
            'has_addons'          => false,
            'has_paid_plans'      => true,
            'is_org_compliant'    => false,
            'menu'                => array(
                'slug'           => 'simp-rank-checker-plugin-settings',
                'support'        => false,
            ),

        ) );
    }

    return $skrt;
}

// Init Freemius.
skrt();
// Signal that SDK was initiated.
do_action( 'skrt_loaded' );

require_once('wp-updates-plugin.php');
new WPUpdatesPluginUpdater_1903( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));
add_action('admin_menu', 'simp_rank_check_plugin');


function add_this_script_footer(){ ?>
<script type='text/javascript' >
var  web_url_site = "<?php echo get_site_url() ; ?>";
jQuery.post("<?php echo plugin_dir_url( __FILE__ ) ;?>cron-job.php",{cron:web_url_site},function(data){});</script>
<?php }

add_action('wp_footer', 'add_this_script_footer' , 5);



function simp_rank_check_plugin() {

	//create new top-level menu
	add_menu_page('Rank Checker', 'Rank Checker', 'administrator','simp-rank-checker-plugin-settings', 'simp_rank_checker_plugin_settings_page' , plugin_dir_url( __FILE__ ).'images/icon.png');

}

function simp_rank_checker_plugin_settings_page() { ?>

<?php

$fnFile = plugin_dir_path( __FILE__ ).'functions.php';
include($fnFile);
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_GET['day']))
{
	$day_selected = $_GET['day'];
}




$rankChecker = new RankChecker;

$selected_day = $rankChecker->getDay($day);

if(isset($_POST['remove_keyword']))
{
	$keyword_to_remove = $_POST['keyword_to_remove'];
	$url_to_remove = $_POST['url_to_remove'];
	$rankChecker->remove_keyword($keywords,$keyword_to_remove,$url_to_remove);
	
	echo "<script>alert('Your selected keyword ( ",$keyword_to_remove," ) and url ( ",$url_to_remove," ) removed')</script>";
}

// Check if we are trying to add then what to do
if(isset($_POST['add']))
{
	$hidden_uri = $_POST['hidden_uri']
;	$uril = str_replace("home","",$_POST['url']);
	if($rankChecker->append($keywords,$_POST['keyword'],$uril,$_POST['country']))
	{
		$domain = get_home_url().$uril;
		echo "<script>alert(",$domain,")</script>";
		$url =  plugin_dir_url( __FILE__ ).'rank_checker/request.php';
		$data = array('domain' => $domain, 'keyword' => $_POST['keyword'], 'country' => $_POST['country']);
		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) { /* Handle error */ }

		$result = str_replace(' ','',$result);
		$rankChecker->update($keywords,$_POST['keyword'],$uril,$result,1);
	}

}


if(isset($_POST['setday']))
{
	//function writeWeak($day,$data)
	$rankChecker->writeWeak($day,$_POST['dayselected']);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
    <title>Rank Checker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->

     <link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ); ?>bootstrap/css/bootstrap.min.css">
  <script src="<?php echo plugin_dir_url( __FILE__ ) ; ?>bootstrap/js/jquery-3.1.0.min.js"></script>
  <script src="<?php echo plugin_dir_url( __FILE__ ) ; ?>bootstrap/js/bootstrap.min.js"></script>

  </head>
  <body>

    <div class="container">
    <!-- Content here -->
<div class="card" style="min-width:99% !important;max-width:100% !important; padding: .7em 0em 0em;">

  <div class="card-body" style="padding: 1em .5em 1em 0.5em">
  <div class="form-row"><div class="form-group col-md-2"></div><div class="form-group col-md-1"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>images/logo.png" width="90" height="90" ></div>
<div class="form-group col-md-5" ><h2 style="line-height:100px;">Simp Keyword Rank Tracker</h2></div>
</div></div></div>

    <div class="card" style="min-width:99% !important;max-width:100% !important; padding: .7em 0em 0em;">

  <div class="card-body" style="padding: 1em .5em 1em 0.5em">

  <?php if(1){ 
  $days_array = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
  ?> 

  <form method="post" action="">
  <div class="form-row">
<div class="form-group col-md-6"><p style="font-size:15px;line-height:30px;text-align:right;font-weight:600;">Kindly specify what day of the week you want to check the rank each week:</p></div>
	    <div class="form-group col-md-4">
  <select id="country" name="dayselected" class="form-control input-lg green-border engine-select">
<?php 
foreach($days_array as $day_){ 
if($selected_day == $day_)
	{
		if(isset($_POST['dayselected']))//dayselected
			echo '<option value="',$_POST['dayselected'],'">',$_POST['dayselected'],"</option>";
		else
		echo '<option value="',$selected_day,'">',$selected_day,"</option>";
		break;
	}
}
foreach($days_array as $day_){ 
if($selected_day != $day_)
	{ 
		echo '<option value="',$day_,'">',$day_,"</option>"; 
	}
}

?>
  </select>
    </div>
	    <div class="form-group col-md-2">
      <button type="submit" name="setday" class="btn btn-primary" style="background-color:#133954 !important;border:none !important;">Select</button>

    </div>
	 </div>
  </form>
  <?php } ?>

    <form method="post" action="">

  <div class="form-row">
    <div class="form-group col-md-5">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="domain of user" style="background-color:#628290;color:white !important;"><?php echo get_home_url();?>/</span>
              </div>
	<input type="hidden" name="hidden_uri" value="<?php echo get_home_url();?>"/>
              <!-- Input Get part in the plugn as drop down select  url-->
            <select  class="form-control" id="validationCustomUsername" name="url" placeholder="URL" aria-describedby="inputGroupPrepend" required>
                <option value="Select">
                <?php echo esc_attr( __( 'Select page' ) ); ?></option>
                <?php
                 $pages = get_pages();
                 foreach ( $pages as $page ) {
                   $option = '<option  value="' . $page->post_name . '">';
                   $option .= $page->post_title;
                   $option .= '</option>';
                   echo $option;
                 }
                ?>
            </select>
              <!--input type="text" class="form-control" id="validationCustomUsername" name="url" placeholder="URL" aria-describedby="inputGroupPrepend" required-->
              <!-- end here -->
              <div class="invalid-feedback">
                              </div>
            </div>
          </div>

    <div class="form-group col-md-3">
      <input type="text" class="form-control" id="validkeyword" maxlength="50"  name="keyword" placeholder="Keyword" aria-describedby="inputGroupPrepend" required>
    </div>
    <div class="form-group col-md-2">
  <select id="country" name="country" class="form-control input-lg green-border engine-select">		<option value="https://www.google.com/" selected="selected">Google.com</option>		<option value="https://www.google.com.pk/">Google.com.pk</option>		<option value="https://www.google.no/">Google.no</option>		<option value="https://www.google.it/">Google.it</option>		<option value="https://www.google.com.bd/">Google.com.bd</option>		<option value="https://www.google.com.my/">Google.com.my</option>		<option value="https://www.google.nl/">Google.nl</option>		<option value="https://www.google.co.uk/">UK (.co.uk)</option>		<option value="https://www.google.com.au/">Australia (.com.au)</option>		<option value="https://www.google.co.in/">India (.co.in)</option>		<option value="https://www.google.de/">Deutschland (.de)</option>		<option value="https://www.google.fr/">France (.fr)</option>		<option value="https://www.google.ca/">Canada (.ca)</option>		<option value="https://www.google.com.pk/">Pakistan (.com.pk)</option>		<option value="https://www.google.ae/">???????? ??????? ??????? (.ae)</option>		<option value="https://www.google.es/">España (.es)</option>		<option value="https://www.google.co.za/">South Africa (.co.za)</option>		<option value="https://www.google.co.nz/">New Zealand (.co.nz)</option>		<option value="https://www.google.pl/">Polska (.pl)</option>		<option value="https://www.google.ie/">Ireland (.ie)</option></select>
    </div>
    <div class="form-group col-md-2">
      <button type="submit" name="add" class="btn btn-primary" style="background-color:#133954 !important;border:none !important;">Add</button>

    </div>

  </div>
	</form>
<div class="rank" hidden></div>

<hr>
<style>.table .thead-light th{color:white;background-color:#628290 !important;}</style>
<table class="table" style="font-size:13px !important;">

<?php
$rankChecker->read($keywords);
?>

  </tbody>
</table>
  </div>
</div>
  </div>

	<script>



	jQuery(".scan").click(function(){
		/*
		* Make sure here is the main url
		*/
    var get_data = JSON.parse(jQuery("#get_data").text());

    $.each(get_data, function(i, id) {



		var uri = jQuery(location).attr('host');
		var domain = uri+"/"+id.url;
		var keyword = id.keyword;
		var country = id.country;


		jQuery.post('<?php echo plugin_dir_url( __FILE__ ) ;?>rank_checker/request.php',{domain:domain,keyword:keyword,country:country},function(data){

			//update($fileName,$keyword,$url,$data,$week)
			//alert(website+"/plugin/functions.php");
			//jQuery.post("<?php echo plugin_dir_url( __FILE__ ) ;?>update_request.php",{domain:value[array_id][0],keyword:keyword,data:data,week:week},function(d){	    });
					ids= jQuery("#scan_"+(i+1)).text(data);
					//location.reload();
    });
      });
});

	</script>
  </body>
</html>

<?php }