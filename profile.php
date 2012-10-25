<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>BlackHawk: Profile</title>
		<!-- CSS Reset -->
			<link rel="stylesheet" href="assets/css/reset.css" />
        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
            <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-responsive.min.css" />
        <!-- Blue theme-->
            <link rel="stylesheet" href="assets/css/blue.css" id="link_theme" />
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
                            <a class="brand" href="dashboard.html"><i class="icon-home icon-white"></i> BlackHawk</a>
                            <ul class="nav user_menu pull-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php 
									echo 'Johny Smith'; // TODO: Pull real name 
									?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
										<li><a href="./profile.php">My Profile</a></li>
										<li><a href="./profile.php?action=changepassword">Change Password</a></li>
										<li class="divider"></li>
										<li><a href="students.php?action=logout">Log Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <nav>
                                <div>
                                    <ul class="nav">
									    <li>
                                            <a href="./student-campus.php"><i class="icon-book icon-white"></i> Back to Main Menu</a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="icon-book icon-white"></i> Help</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </header>
			<!-- main content -->
            <div id="contentwrapper">
                <div class="main_content">
                    <nav>
                        <div id="jCrumbs" class="breadCrumb module">
                            <ul>
                                <li>
                                    <a href="#"><i class="icon-home"></i></a>
                                </li>
                                <li>
                                    Profile
                                </li>
                            </ul>
                        </div>
                    </nav>
                    
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">User Profile (just a start)</h3>
							<div class="row-fluid">
								<div class="span12">
									<div class="vcard">
										
										<ul>
											<li class="v-heading">
												User info
											</li>
											<li>
												<span class="item-key">Full name</span>
												<div class="vcard-item">John Smith</div>
											</li>
											<li>
												<span class="item-key">Username</span>
												<div class="vcard-item">jsmith</div>
											</li>
											<li>
												<span class="item-key">Email</span>
												<div class="vcard-item">johnSmith@example.com</div>
											</li>
										</ul>
									</div>
								</div>
							</div>	
						</div>
					</div>
                        
                </div>
            </div>
        
			</div></div>
			
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
			<!-- fix for ios orientation change -->
			<script src="assets/js/ios-orientationchange-fix.js"></script>
			<!-- scrollbar -->
			<script src="assets/lib/antiscroll/antiscroll.js"></script>
			<script src="assets/lib/antiscroll/jquery-mousewheel.js"></script>
			<!-- lightbox -->
            <script src="assets/lib/colorbox/jquery.colorbox.min.js"></script>
            <!-- common functions -->
			<script src="assets/js/blackhawk_common.js"></script>
			
			<!-- user profile (static) functions -->
			<script src="assets/js/blackhawk_user_static.js"></script>
			
			<script>
				$(document).ready(function() {
					//* show all elements & remove preloader
					setTimeout('$("html").removeClass("js")',1000);
				});
			</script>
		
		
	</body>
</html>


