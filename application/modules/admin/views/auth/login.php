<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<link rel="icon" type="image/x-icon" href="<?= site_url('assets/logo/favicon.ico') ?>" />
	<title><?= config_item('site_title');?></title>

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

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a><img height="75" src="<?= site_url('assets/logo/logo.png') ?>" /></a>
			<div class="clearfix"></div>
			<a><?= lang('admin_panel') ?></a>
		</div>

		<div class="login-box-body">
			<p class="login-box-msg"><?= lang('sign_in_to_start_your_session') ?></p>
			<form id="login-form">
				<p class="alert alert-block alert-danger message_box hide"></p>
				<div class="form-group has-feedback">
					<input type="email" class="form-control login_input" name="email" placeholder="<?= lang('email') ?>" value="admin@demo.com">
					<span class="fa fa-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" class="form-control login_input" placeholder="<?= lang('password') ?>" name="password" value="Coff1248!EE">
					<span class="fa fa-lock form-control-feedback"></span>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-12 col-md-8">
						<a href="<?= site_url('admin/forgot/password') ?>"><?= lang('i_forgot_password') ?></a>
					</div>
					<div class="col-xs-12 col-md-4">
						<button type="button" class="btn btn-primary btn-block btn-flat" id="login-submit"><?= lang('sign_in') ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- jQuery 2.2.3 -->
	<script src="<?= site_url('assets/backend/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="<?= site_url('assets/backend/bootstrap/js/bootstrap.min.js'); ?>"></script>

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
	<!-- Custom JS File -->
	<script src="<?= site_url('assets/backend/js/main.js'); ?>"></script>

	<script type="text/javascript">
		jQuery(function($) {		
			$(document).on('click','#login-submit',function(e){
				e.preventDefault();

				$.ajax({
					dataType : 'json',
					type: 'POST',
					url: '<?= site_url('admin/auth/validate_login'); ?>',
					data: $('#login-form').serialize(),
					beforeSend: function() {
						$('#login-submit').attr('disabled',true);
						$('.message_box').html('').addClass('hide');
					},
					error: function(jqXHR, exception) {
						$('#login-submit').attr('disabled',false);
						
						var msg = formatErrorMessage(jqXHR, exception);
						$('.message_box').html(msg).removeClass('hide');
					},
					success: function (data) {
						$('#login-submit').html(data.success).removeClass('btn-primary').addClass('btn-success');
						window.location.replace('<?= site_url('admin/dashboard') ?>');
					}
				});
			});		

			$(document).on('keypress', '.login_input', function(e){
				if(e.which == 10 || e.which == 13) {
					e.preventDefault();
					$('#login-submit').click();
				}
			});
		});
	</script>
</body>
</html>