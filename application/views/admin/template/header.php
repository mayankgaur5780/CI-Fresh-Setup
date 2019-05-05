<?php
	$user = $this->session->userdata('admin');
	$locale = get_lang();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <link rel="icon" type="image/x-icon" href="<?= site_url('assets/logo/favicon.ico') ?>" />
		<title><?php echo config_item('site_title');?></title>
		
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		
		<!-- bootstrap -->
		<link rel="stylesheet" href="<?php echo site_url('assets/backend/bootstrap/css/bootstrap.min.css'); ?>" />
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo site_url('assets/backend/plugins/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
		<!-- DataTables -->
		<link rel="stylesheet" href="<?php echo site_url('assets/backend/plugins/datatables/dataTables.bootstrap.css'); ?>">

        <?php if($locale == 'en') { ?>
            <!-- Theme style -->
            <link rel="stylesheet" href="<?= site_url('assets/backend/dist/css/AdminLTE.min.css') ?>">
            <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
            <link rel="stylesheet" href="<?= site_url('assets/backend/dist/css/skins/_all-skins.min.css') ?>">
		<?php } else { ?>
            <!-- Theme style -->
            <link rel="stylesheet" href="<?= site_url('assets/backend/dist/css/AdminLTE-rtl.min.css') ?>">
            <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
            <link rel="stylesheet" href="<?= site_url('assets/backend/dist/css/skins/_all-skins-rtl.min.css') ?>">
		<?php } ?>

        <!-- Date Picker -->
        <link rel="stylesheet" href="<?= site_url('assets/backend/plugins/datepicker/datepicker3.css') ?>">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?= site_url('assets/backend/plugins/daterangepicker/daterangepicker.css') ?>">
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="<?= site_url('assets/backend/plugins/timepicker/bootstrap-timepicker.min.css') ?>">
        <!-- Bootstrap date-time Picker -->
        <link rel="stylesheet" href="<?= site_url('assets/backend/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') ?>">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?= site_url('assets/backend/plugins/select2/select2.min.css') ?>">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?= site_url('assets/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>">
        <!-- Star Rating -->
        <link rel="stylesheet" href="<?= site_url('assets/backend/plugins/star-rating-svg-master/src/css/star-rating-svg.css') ?>">
        <!-- Tel Input -->
        <link rel="stylesheet" href="<?= site_url('assets/backend/plugins/intl-tel-input/css/intlTelInput.css') ?>">
		<!-- Custom style -->
		<link href="<?php echo site_url('assets/backend/css/site.css');?>" type="text/css" rel="stylesheet" />
		<link href="<?php echo site_url('assets/backend/css/custom.css');?>" type="text/css" rel="stylesheet" />

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
		<!--[if lte IE 8]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5sshiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->


        <!-- jQuery 2.2.3 -->
        <script src="<?= site_url('assets/backend/plugins/jQuery/jquery-2.2.3.min.js') ?>"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="<?= site_url('assets/backend/plugins/jQueryUI/jquery-ui.min.js') ?>"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?= site_url('assets/backend/bootstrap/js/bootstrap.min.js') ?>"></script>
        <!-- DataTables -->
        <script src="<?= site_url('assets/backend/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
        <script src="<?= site_url('assets/backend/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
        <script src="<?= site_url('assets/backend/plugins/datatables/dataTables.buttons.min.js') ?>"></script>
        <script src="<?= site_url('assets/backend/plugins/datatables/buttons.flash.min.js') ?>"></script>
        <script src="<?= site_url('assets/backend/plugins/datatables/jszip.min.js') ?>"></script>
        <script src="<?= site_url('assets/backend/plugins/datatables/vfs_fonts.js') ?>"></script>
        <script src="<?= site_url('assets/backend/plugins/datatables/buttons.html5.min.js') ?>"></script>
        <!-- moment -->
        <script src="<?= site_url('assets/backend/plugins/moment/moment.min.js') ?>"></script>
        <script src="<?= site_url('assets/backend/plugins/moment/moment-with-locales.min.js') ?>"></script>
        <script src="<?= site_url('assets/backend/plugins/moment/moment-timezone.min.js') ?>"></script>
        <script src="<?= site_url('assets/backend/plugins/moment/moment-timezone-with-data.min.js') ?>"></script>
        <!-- daterangepicker -->
        <script src="<?= site_url('assets/backend/plugins/daterangepicker/daterangepicker.js') ?>"></script>
        <!-- datepicker -->
        <script src="<?= site_url('assets/backend/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
        <!-- bootstrap time picker -->
        <script src="<?= site_url('assets/backend/plugins/timepicker/bootstrap-timepicker.min.js') ?>"></script>
        <!-- bootstrap date-time picker -->
        <script src="<?= site_url('assets/backend/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ?>"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?= site_url('assets/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>"></script>
        <!-- Slimscroll -->
        <script src="<?= site_url('assets/backend/plugins/slimScroll/jquery.slimscroll.min.js') ?>"></script>
        <!-- CK Editor -->
        <script src="<?= site_url('assets/backend/plugins/ckeditor/ckeditor.js') ?>"></script>
        <!-- Chart JS -->
        <script src="<?= site_url('assets/backend/plugins/chartjs/Chart.min.js') ?>"></script>
        <!-- Select2 -->
        <script src="<?= site_url('assets/backend/plugins/select2/select2.full.min.js') ?>"></script>
        <!-- Tel Input -->
        <script src="<?= site_url('assets/backend/plugins/intl-tel-input/js/intlTelInput.js') ?>"></script>
        <!-- Star Rating -->
        <script src="<?= site_url('assets/backend/plugins/star-rating-svg-master/src/jquery.star-rating-svg.js') ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?= site_url('assets/backend/dist/js/app.min.js') ?>"></script>
        <!-- Main JS -->
        <script src="<?= site_url('assets/backend/js/main.js') ?>"></script>

        <script type="text/javascript">
            // <!-- Http Errors -->
            const ajax_errors = {
                http_not_connected: "<?= lang('http_not_connected') ?>",
                request_forbidden: "<?= lang('request_forbidden') ?>",
                not_found_request: "<?= lang('not_found_request') ?>",
                session_expire: "<?= lang('session_expire') ?>",
                service_unavailable: "<?= lang('service_unavailable') ?>",
                parser_error: "<?= lang('parser_error') ?>",
                request_timeout: "<?= lang('request_timeout') ?>",
                request_abort: "<?= lang('request_abort') ?>"
            };
        </script>
	</head>

	<body class="hold-transition skin-blue sidebar-mini <?= "{$locale}_lang" ?>">
	    <div class="wrapper">
	        <header class="main-header">
	            <a href="<?php echo site_url('admin/dashboard'); ?>" class="logo">
	                <span class="logo-mini"><img src="<?= site_url('assets/logo/logo.png') ?>" width="50"></span>
	                <span class="logo-lg"><img src="<?= site_url('assets/logo/logo.png') ?>" width="40"> <b><?= config_item('company_name'); ?></b></span>
	            </a>
	            <nav class="navbar navbar-static-top">
	                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	                    <span class="sr-only"><?= lang('toggle_navigation') ?></span>
	                </a>
	
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
				            <li class="dropdown user user-menu">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                	<?php
                                		$profile_image = !is_null($user->profile_image) ? imageBasePath($user->profile_image) : site_url('assets/backend/images/default-user.png');
                                	?>
	                                <img src="<?= $profile_image ?>" class="user-image">
	                                <span class="hidden-xs"><?= $user->name ?></span>
	                            </a>
	                            <ul class="dropdown-menu">
	                                <li class="user-header">
	                                    <img src="<?= $profile_image ?>" class="img-circle">
	                                    <p><?= $user->name ?></p>
	                                </li>
	                                <li class="user-footer">
	                                    <div class="pull-left">
	                                        <a href="<?= site_url('admin/profile') ?>" class="btn btn-default btn-flat"><?= lang('profile') ?></a>
	                                    </div>
	                                    <div class="pull-right">
	                                        <a href="<?= site_url('admin/profile/sign_out') ?>" class="btn btn-default btn-flat"><?= lang('sign_out') ?></a>
	                                    </div>
	                                </li>
	                            </ul>
	                        </li>
	                    </ul>
	                </div>
	            </nav>
	        </header>
	
            <?php $this->load->view('admin/navigation'); ?>
            
	        <div class="content-wrapper">