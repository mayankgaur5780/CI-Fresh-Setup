<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Reset password</title>

<style type="text/css">
	body {
		-webkit-font-smoothing: antialiased;
		-webkit-text-size-adjust: none;
		width: 100% !important;
		height: 100%;
		line-height: 1.6em;
	}

	table td {
		vertical-align: top;
	}

	body {
		background-color: #f6f6f6;
	}

	.body-wrap {
		background-color: #f6f6f6;
		width: 100%;
	}

	.container {
		display: block !important;
		max-width: 600px !important;
		margin: 0 auto !important;
		/* makes it centered */
		clear: both !important;
	}

	.content {
		max-width: 600px;
		margin: 0 auto;
		display: block;
		padding: 20px;
	}

	.content-wrap {
		padding: 20px;
	}

	.content-block {
		padding: 0 0 20px;
	}

	.h1,
	.h2,
	.h3 {
		font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
		color: #000;
		margin: 0;
		line-height: 1.2em;
		font-weight: 400;
		font-size: 18px;
	}

	.btn-warning {
		text-decoration: none;
		color: #286090;
		border: 1px solid #286090;
		padding: 10px 20px;
		line-height: 2em;
		font-weight: bold;
		text-align: center;
		cursor: pointer;
		display: inline-block;
		border-radius: 5px;
		text-transform: capitalize;
	}

	@media only screen and (max-width: 640px) {
		body {
			padding: 0 !important;
		}
		.container {
			padding: 0 !important;
			width: 100% !important;
		}
		.content {
			padding: 0 !important;
		}
		.content-wrap {
			padding: 10px !important;
		}
		.h3 {
			font-weight: 800 !important;
			font-size: 16px !important;
		}
	}

	.center {
		text-align: center !important;
	}
</style>
</head>

<body>
	<table class="body-wrap">
		<tr>
			<td></td>
			<td class="container" width="600">
				<div class="content">
					<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction">
						<tr>
							<td class="content-wrap">
								<meta itemprop="name" content="Confirm Email"/>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td class="content-block">
											<span class="h3">Hi <?= $email ?>,</span>
										</td>
									</tr>
									<tr>
										<td class="content-block">
											You recently requested to reset your password for your account. Click the button below to reset it.
										</td>
									</tr>
									<tr>
										<td class="content-block center">
											<a href="<?= $reset_link ?>" class="btn-warning" itemprop="url">Reset Password</a>
										</td>
									</tr>
									<tr>
										<td class="content-block">
											If you ignore this message, your password won't be changed.
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</body>
</html>
