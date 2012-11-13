<?php
if(!file_exists('assets/config.inc.php')) {
	echo '<a href="setup/">Please install the parking system first!</a>';
} else {
require_once('assets/member.inc.php');
if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = null;
}
// TODO: Graphs need to have dynamic data
// TODO: Cookie: Favorite garages and color data

// Clear Jigoshop Session Data if present (For @chriscct7 only)
//$_SESSION['jigoshop']=null;
// Now let's grab session data
//var_dump($_SESSION);
// And halt so we can read that data
//exit;
$secure=false; //assume not logged in
if ($member->sessionIsSet()==true){
	$secure=true;
}
if($secure==true){ //Dashboard
require_once('assets/member.inc.php');
if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = null;
}
if(isset($_GET['subaction'])) {
	$subaction = $_GET['subaction'];
} else {
	$subaction = null;
}
if($action == 'logout') {
	echo $member->logout();
}
    //   self registration removed
    //   elseif($action == 'register') {
	//   $title   = 'Create an account';
	//   $content = $member->register() . '<p class="options group"><a href="member.php?action=login">Already have an account?</a> &bull; <a href="member.php?action=recover-password">Recover Password</a></p>';
// if($action == 'settings') {
	// $member->LoggedIn();
	// $user = $member->data();
// }
	// elseif($subaction == 'password') {
		// $title   = 'Change Password';
		// $content = $member->changePassword($user->id);
	// } elseif($subaction == 'delete') {
		// $title   = 'Delete Account';
		// $content = $member->deleteAccount($user->id);
	// } elseif($subaction == 'settings') {
		// $title   = 'Settings';
		// $content = '<a href="index.php?action=settings&amp;subaction=password" class="button full">Change Password</a><a href="index.php?action=settings&amp;subaction=delete" class="button full">Delete Account</a>';
	// }
	
	
	?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>BlackHawk Dashboard</title>
		<!-- CSS Reset -->
			<link rel="stylesheet" href="assets/css/reset.css" />
        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
            <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-responsive.min.css" />
        <!-- Blue theme-->
            <link rel="stylesheet" href="assets/css/<?php $color_requested_via_cookie="blue"; echo $color_requested_via_cookie; ?>.css" id="link_theme" /> <!-- default to blue -->
        <!-- breadcrumbs-->
            <link rel="stylesheet" href="assets/lib/jBreadcrumbs/css/BreadCrumb.css" />
        <!-- tooltips-->
            <link rel="stylesheet" href="assets/lib/qtip2/jquery.qtip.min.css" />
        <!-- colorbox -->
            <link rel="stylesheet" href="assets/lib/colorbox/colorbox.css" />    
        <!-- code prettify -->
            <link rel="stylesheet" href="assets/lib/google-code-prettify/prettify.css" />    
        <!-- notifications -->
            <link rel="stylesheet" href="assets/lib/sticky/sticky.css" />    
        <!-- splashy icons -->
            <link rel="stylesheet" href="assets/img/splashy/splashy.css" />
        <!-- main styles -->
            <link rel="stylesheet" href="assets/css/backend.css" />
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans" />
        <!-- Favicon -->
            <link rel="shortcut icon" href="assets/img/favicon.ico" />
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/ie.css" />
            <script src="assets/js/ie/html5.js"></script>
			<script src="assets/js/ie/respond.min.js"></script>
			<script src="assets/lib/flot/excanvas.min.js"></script>
        <![endif]-->
		<script>
			//* hide all elements & show preloader
			document.documentElement.className += 'js';
		</script>
    </head>
    <body class="menu_hover">
		<div id="loading_layer" style="display:none"><img src="assets/img/ajax_loader.gif" alt="" /></div>
		<div class="style_switcher">
			<div class="sepH_c">
				<p class="whitetext_on_switcher">Colors:</p>
				<div class="clearfix">
					<a href="javascript:void(0)" class="style_item jQclr blue_theme style_active" title="blue">blue</a>
					<a href="javascript:void(0)" class="style_item jQclr dark_theme" title="dark">dark</a>
					<a href="javascript:void(0)" class="style_item jQclr green_theme" title="green">green</a>
					<a href="javascript:void(0)" class="style_item jQclr brown_theme" title="brown">brown</a>
					<a href="javascript:void(0)" class="style_item jQclr eastern_blue_theme" title="eastern_blue">eastern blue</a>
					<a href="javascript:void(0)" class="style_item jQclr tamarillo_theme" title="tamarillo">tamarillo</a>
				</div>
			</div>
			<div class="sepH_c">
				<p class="whitetext_on_switcher">Backgrounds:</p>
				<div class="clearfix">
					<span class="style_item jQptrn style_active ptrn_def" title=""></span>
					<span class="ssw_ptrn_a style_item jQptrn" title="ptrn_a"></span>
					<span class="ssw_ptrn_b style_item jQptrn" title="ptrn_b"></span>
					<span class="ssw_ptrn_c style_item jQptrn" title="ptrn_c"></span>
					<span class="ssw_ptrn_d style_item jQptrn" title="ptrn_d"></span>
					<span class="ssw_ptrn_e style_item jQptrn" title="ptrn_e"></span>
				</div>
			</div>
			<div class="sepH_c">
				<p class="whitetext_on_switcher">Layout:</p>
				<div class="clearfix">
					<label class="radio inline"><input type="radio" name="ssw_layout" id="ssw_layout_fluid" value="" checked /> Fluid</label>
					<label class="radio inline"><input type="radio" name="ssw_layout" id="ssw_layout_fixed" value="blackhawk-fixed" /> Fixed</label>
				</div>
			</div>
			<div class="gh_button-group">
				<a href="#" id="resetDefault" class="btn btn-mini">Reset</a>
				<a href="#" id="save" class="btn btn-mini">Save</a>
			</div>
		</div>
		
		<div id="maincontainer" class="clearfix">
			<!-- header -->
            <header>
                <div class="navbar navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
                            <a class="brand" href="index.php"><i class="icon-home icon-white"></i> BlackHawk</a>
                            <ul class="nav user_menu  pull-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php 
									echo $_SESSION['member_name']; // TODO: Pull real name 
									?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
										<li><a href="./profile.php">My Profile</a></li>
										<li><a href="./profile.php?action=changepassword">Change Password</a></li>
										<li class="divider"></li>
										<li><a href="index.php?action=logout">Log Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <nav>
                                <div>
                                    <ul class="nav user_menu pull-right">
                                        <li>
                                            <a href="#"><i class="icon-book icon-white"></i> Help</a>
                                        </li>
                                    </ul>
								<a data-target=".nav-collapse" data-toggle="collapse" class="btn_menu">
								<span class="icon-align-justify icon-white"></span>
							</a>
							<?php //start temp
							$test=false;
							if ($test == true){
								?>
                            <nav>
                                <div class="nav-collapse">
                                    <ul class="nav">
                                        <li class="dropdown">
                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-list-alt icon-white"></i> Forms <b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="form_elements.html">Form elements</a></li>
                                                <li><a href="form_extended.html">Extended form elements</a></li>
                                                <li><a href="form_validation.html">Form Validation</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-th icon-white"></i> Components <b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="alerts_btns.html">Alerts & Buttons</a></li>
                                                <li><a href="icons.html">Icons</a></li>
                                                <li><a href="notifications.html">Notifications</a></li>
                                                <li><a href="tables.html">Tables</a></li>
												<li><a href="tables_more.html">Tables (more examples)</a></li>
                                                <li><a href="tabs_accordion.html">Tabs & Accordion</a></li>
                                                <li><a href="tooltips.html">Tooltips, Popovers</a></li>
                                                <li><a href="typography.html">Typography</a></li>
												<li><a href="widgets.html">Widget boxes</a></li>
												<li class="dropdown">
													<a href="#">Sub menu <b class="caret-right"></b></a>
													<ul class="dropdown-menu">
														<li><a href="#">Sub menu 1.1</a></li>
														<li><a href="#">Sub menu 1.2</a></li>
														<li><a href="#">Sub menu 1.3</a></li>
														<li>
															<a href="#">Sub menu 1.4 <b class="caret-right"></b></a>
															<ul class="dropdown-menu">
																<li><a href="#">Sub menu 1.4.1</a></li>
																<li><a href="#">Sub menu 1.4.2</a></li>
																<li><a href="#">Sub menu 1.4.3</a></li>
															</ul>
														</li>
													</ul>
												</li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-wrench icon-white"></i> Plugins <b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="charts.html">Charts</a></li>
                                                <li><a href="calendar.html">Calendar</a></li>
                                                <li><a href="datatable.html">Datatable</a></li>
                                                <li><a href="file_manager.html">File Manager</a></li>
                                                <li><a href="floating_header.html">Floating List Header</a></li>
                                                <li><a href="google_maps.html">Google Maps</a></li>
                                                <li><a href="gallery.html">Gallery Grid</a></li>
                                                <li><a href="wizard.html">Wizard</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-file icon-white"></i> Pages <b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="chat.html">Chat</a></li>
                                                <li><a href="error_404.html">Error 404</a></li>
												<li><a href="mailbox.html">Mailbox</a></li>
                                                <li><a href="search_page.html">Search page</a></li>
                                                <li><a href="user_profile.html">User profile</a></li>
												<li><a href="user_static.html">User profile (static)</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
							<?php } else{
								
							}
							?>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- main content -->
            <div id="contentwrapper">
                <div class="main_content">
                    
					<div class="row-fluid">
						<div class="span12 tac">
							<ul class="ov_boxes">
								<li>
									<div class="p_bar_up p_canvas"><?php echo '2,4,9,7,12,8,16';?></div>
									<div class="ov_text">
										<strong><?php echo '2304';?></strong>
										Number of Open Spots
									</div>
								</li>
								<li>
									<div class="p_bar_down p_canvas"><?php echo '20,15,18,14,10,13,9,7';?></div>
									<div class="ov_text">
										<strong><?php echo '2304';?></strong>
										Number of Used Spots
									</div>
								</li>
								<li>
									<div class="p_line_up p_canvas"><?php echo '3,5,9,7,12,8,16';?></div>
									<div class="ov_text">
										<strong><?php echo '2304';?></strong>
										Parking Tickets Today
									</div>
								</li>
								<li>
									<div class="p_line_down p_canvas"><?php echo '20,16,14,18,15,14,14,13,12,10,10,8';?></div>
									<div class="ov_text">
										<strong><?php echo '2304';?></strong>
										Something else
									</div>
								</li>
							</ul>
						</div>
					</div>
						
						 <div class="row-fluid">
                        <div class="span12">
							<div class="heading clearfix">
								<h3 class="pull-left">Parking Status</h3>	
								<span class="pull-left label label-important ttip_t" style="margin-left: 10px;" title="Closed Garageg is XXXXX">1 Closed Parking Lot</span>
							</div>
                            <table id="dt_e" class="table table-striped table-bordered dTableR">
                                <thead>
                                    <tr>
                                        <th></th> 
                                        <th>Type</th>
                                        <th>Number</th>
										<th>% Open</th>
                                        <th>Number of Spots</th>
                                        <th>Number Open</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="dataTables_empty" colspan="6">Loading data from server</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
					
					<div class="row-fluid">
						<div class="span5">
							<h3 class="heading">Visitors by Role Type <small>last week</small></h3>
							<div id="fl_2" style="height:200px;width:80%;margin:50px auto 0"></div>
						</div>
						<div class="span7">
							<div class="heading clearfix">
								<h3 class="pull-left">Parking Spots</h3>
							</div>
							<div id="fl_1" style="height:270px;width:100%;margin:15px auto 0"></div>
						</div>
					</div>
					<br /><br /><br />
					<div class="heading clearfix">
					<h3 class="pull-left">Find My Car</h3>
					</div>
					<br />
					<a data-toggle="modal" data-backdrop="static" href="#myModal2" class="btn">Car Location</a></div>
					<div class="modal hide fade" id="myModal2">
								<div class="modal-header">
									<button class="close" data-dismiss="modal">×</button>
									<h3>Car Location</h3>
								</div>
								<div class="modal-body">
									Your car is currently at <?php $location='test';echo $location; ?>.
								</div>
								<div class="modal-footer">
									<a href="#" class="btn" data-dismiss="modal">Close</a>
								</div>
							</div>

            </div>
       </div>
            <!-- jquery -->
            <script src="assets/js/jquery.min.js"></script>
			<!-- smart resize event -->
			<script src="assets/js/jquery.debouncedresize.min.js"></script>
			<!-- hidden elements width/height -->
			<script src="assets/js/jquery.actual.min.js"></script>
			<!-- js cookie plugin -->
			<script src="assets/js/jquery.cookie.min.js"></script>
			<!-- main bootstrap js -->
			<script src="assets/bootstrap/js/bootstrap.min.js"></script>
			<!-- tooltips -->
			<script src="assets/lib/qtip2/jquery.qtip.min.js"></script>
			<!-- jBreadcrumbs -->
			<script src="assets/lib/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min.js"></script>
			<!-- lightbox -->
            <script src="assets/lib/colorbox/jquery.colorbox.min.js"></script>
            <!-- fix for ios orientation change -->
			<script src="assets/js/ios-orientationchange-fix.js"></script>
			<!-- common functions -->
			<script src="assets/js/blackhawk_common.js"></script>
			<script src="assets/lib/jquery-ui/jquery-ui-1.8.20.custom.min.js"></script>
            <!-- touch events for jquery ui-->
            <script src="assets/js/forms/jquery.ui.touch-punch.min.js"></script>
            <!-- multi-column layout -->
            <script src="assets/js/jquery.imagesloaded.min.js"></script>
            <script src="assets/js/jquery.wookmark.js"></script>
            <!-- responsive table -->
            <script src="assets/js/jquery.mediaTable.min.js"></script>
            <!-- small charts -->
            <script src="assets/js/jquery.peity.min.js"></script>
            <!-- sortable/filterable list -->
            <script src="assets/lib/list_js/list.min.js"></script>
            <script src="assets/lib/list_js/plugins/paging/list.paging.min.js"></script>
            <!-- dashboard functions -->
            <script src="assets/js/blackhawk_dashboard.js"></script>
    		<!-- smoke_js -->
			<script src="assets/lib/smoke/smoke.js"></script>
            <!-- notifications functions -->
            <script src="assets/js/blackhawk_notifications.js"></script>
            <!-- datatable -->
            <script src="assets/lib/datatables/jquery.dataTables.min.js"></script>
            <script src="assets/lib/datatables/extras/Scroller/media/js/Scroller.min.js"></script>
            <!-- datatable functions -->
            <script src="assets/js/blackhawk_datatables.js"></script>
			<!-- charts -->
            <script src="assets/lib/flot/jquery.flot.min.js"></script>
            <script src="assets/lib/flot/jquery.flot.resize.min.js"></script>
            <script src="assets/lib/flot/jquery.flot.pie.min.js"></script>
			<script>
				$(document).ready(function() {
					//* show all elements & remove preloader
					setTimeout('$("html").removeClass("js")',1000); // Delay loading for now until MySQL calls are optomized
				});
			</script>
			</div>
	</body>
</html>
<?php }
else {
if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = null;
}
if ($action != null){
if($action == 'recover-password') {
	$title   = 'Recover your password';
	$content = $member->recoverPassword();
} elseif($action == 'verification') {
	$title   = 'Your account has been verified';
	$content = $member->verification() . '<p class="options group"><a href="index.php?action=login">Already have an account?</a></p>';
}
elseif($action == 'statistics') {
	$title   = 'Redirecting';
	$content = 'Not Available Yet';
}

else {
	$title   = 'Login';
	$content =  $member->login();
}
}
else {
	$title   = 'Welcome';
	$content =  'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';
}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php if($action == null){ ?>
	<title><?php echo $title ?></title>
	<!--CSS Files-->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css" />

<?php } else{ ?>	
			<title><?php echo $title ?></title>
	        <meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<link rel="stylesheet" type="text/css" href="assets/css/backend.css" />
	        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
            <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-responsive.min.css" />
        <!-- theme color-->
            <link rel="stylesheet" href="assets/css/blue.css" />
        <!-- tooltip -->    
			<link rel="stylesheet" href="assets/lib/qtip2/jquery.qtip.min.css" />
        <!-- main styles -->
            <link rel="stylesheet" href="assets/css/style.css" />
    
        <!-- Favicons and the like (avoid using transparent .png) -->
            <link rel="shortcut icon" href="favicon.ico" />
            <link rel="apple-touch-icon-precomposed" href="assets/img/icon.png" />
        <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
        <!--[if lte IE 8]>
            <script src="assets/js/ie/html5.js"></script>
			<script src="assets/js/ie/respond.min.js"></script>
        <![endif]-->
	<?php } ?>
	
</head>
<?php if($action == null){ ?>
<body>
<?php } else{ ?>
<body class="login_page">
<?php } ?>
<div id="wrapper" class="group">
	<div id="header" class="group">
		<h1 id="logo">BlackHawk</h1>
		<div id="user">
			<div id="user-info">Hello, Guest</div>
			<ul id="user-ops">
				<li><a href="index.php?action=login">Login</a></li>
			</ul>
		</div>
	</div>
	<ul id="navigation" class="group">
		<?php if($action != null){ ?><li><a href="index.php">Home Page</a></li><?php } else{ }?>
		<?php if($action != "login"){ ?><li><a href="index.php?action=login">Login</a></li><?php } else{ }?>
		<?php if($action != "statistics"){ ?><li><a href="index.php?action=statistics">Public Statistics</a></li><?php } else{ }?>
	</ul>
	<?php if($action != 'recover-password' && $action != 'login'){ ?>	
	<div  id="main" class="group">
	<h1><?php echo $title; ?></h1>
	<?php echo $content; ?>
	</div>
	<?php } else{ ?>	
	<div class="login_box">
	<?php echo $content; ?>
	<div class="links_b links_btm clearfix">
			<?php if($action != "recover-password"){?><span class="linkform"><a href="index.php?action=recover-password">Forgot password?</a></span><?php } else{ }?>
			<?php if($action != "login"){?><span class="linkform">Never mind, <a href="index.php?action=login">send me back to the sign-in screen</a></span><?php } else{ }?>
		</div>
	</div>
	    <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.actual.min.js"></script>
        <script src="assets/lib/validation/jquery.validate.min.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
		
				//* validation
				$('#login_form').validate({
					onkeyup: false,
					errorClass: 'error',
					validClass: 'valid',
					rules: {
						username: { required: true, minlength: 9, maxlength: 9 },
						password: { required: true, minlength: 6 }
					},
					highlight: function(element) {
						$(element).closest('div').addClass("f_error");
					},
					unhighlight: function(element) {
						$(element).closest('div').removeClass("f_error");
					},
					errorPlacement: function(error, element) {
						$(element).closest('div').append(error);
					}
				});
            });
        </script>
<?php } ?>
	</body>
	</html>
		<?php
		}
}
?>
		