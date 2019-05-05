<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<link rel="icon" type="image/x-icon" href="<?= site_url('assets/logo/favicon.ico') ?>" />
	<title><?= config_item('site_title');?> | 404</title>

	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="<?= site_url('assets/backend/bootstrap/css/bootstrap.min.css'); ?>" />
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= site_url('assets/backend/plugins/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= site_url('assets/backend/dist/css/AdminLTE.min.css')  ?>">
	<!-- Custom style -->
	<link rel="stylesheet" href="<?= site_url('assets/backend/css/site.css'); ?>" />
	<link rel="stylesheet" href="<?= site_url('assets/backend/css/custom.css'); ?>" />

	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
	<!--[if lte IE 8]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<div class="content-wrapper">
			<section class="content">
				<div class="error-page">
					<h2 class="headline text-yellow">404</h2>
					<div class="error-content">
						<h3><i class="fa fa-warning text-yellow"></i> <?= lang('oops_page_not_found') ?>.</h3>
						<p> 
							<?= lang('404_label') ?> 
							<a href="javascript:history.back();"> <?= lang('return_to_back_page') ?> </a>
						</p>
					</div>
				</div>
			</section>
		</div>
		<footer class="main-footer">
			<strong><?= lang('copyright') ?> &copy; <?= date('Y') ?> <a><?= config_item('company_name') ?></a>.</strong> <?= lang('all_rights_reserved') ?>.
		</footer>
	</div>
	
	<script src="<?= site_url('assets/backend/plugins/jQuery/jquery-2.2.3.min.js') ?>"></script>
	<script src="<?= site_url('assets/backend/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?= site_url('assets/backend/dist/js/app.min.js') ?>"></script>
</body>
</html>