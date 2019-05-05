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
			<h2><?= lang('change_password') ?></h2>
		</div>

		<div class="login-box-body">
			<h5><?= sprintf(lang('reset_password_heading'), $response->name) ?></h5>
			<br>
			<form>
				<p class="alert alert-block alert-danger message_box hide"></p>
				<div class="form-group has-feedback">
					<input type="password" name="password" class="form-control" placeholder="<?= lang('new_password') ?>">
					<span class="fa fa-key form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" name="password_confirmation" class="form-control" placeholder="<?= lang('confirm_password') ?>">
					<span class="fa fa-key form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<button id="submitBtn" type="button" class="btn btn-primary btn-flat pull-right"><?= lang('change_password') ?></button>
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
			<?php $user_id = $this->uri->segment(3); ?>		
			$(document).on('click', '#submitBtn', function (e) {
				e.preventDefault();          
				var btn = $(this);
				
				$.ajax({
					dataType: "json",
					type: "POST",
					url: "<?php echo site_url("admin/auth/reset_password_post/{$response->id}"); ?>",
					data: $('form').serialize(),
					beforeSend: function() {
						$('#submitBtn').attr('disabled',true);
						$('.message_box').html('').addClass('hide');
					},
					error: function(jqXHR, exception) {
						$('#submitBtn').attr('disabled',false);
						
						var msg = formatErrorMessage(jqXHR, exception);
						$('.message_box').html(msg).removeClass('hide');
					},
					success: function (data) {
						$('.message_box').html(data.msg).removeClass('alert-danger hide').addClass('alert-success');
						$('#submitBtn').attr('disabled',false);
						setTimeout(() => {
							window.location.replace('<?= site_url('admin/login') ?>');
						}, 1000);
					}
				});
			
				$(document).on('keyup', '[name="password_confirmation"]', function(e) {
					if(e.which == 13) {
						$('#submitBtn').click();
					}
				});
			});
		});
	</script>
</body>

</html>