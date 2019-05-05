<section class="content-header">
    <h1><?= lang('profile') ?></h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?= site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?= lang('dashboard') ?></a>
	    </li>
        <li class="active"><?= lang('profile') ?></li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#basic-info-tab"><?= lang('basic_info') ?></a></li>
                    <li><a data-toggle="tab" href="#change-password-tab"><?= lang('change_password') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="basic-info-tab">
                        <p class="alert message_box hide"></p>
                        <form id="save-frm" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label required"><?= lang('name') ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" placeholder="<?= lang('name') ?>" value="<?= $user->name ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label required"><?= lang('email') ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="email" placeholder="<?= lang('email') ?>" value="<?= $user->email ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label required"><?= lang('mobile') ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="mobile" value="<?= $user->mobile ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?= lang('profile_image') ?></label>
                                <div class="col-sm-6">
                                    <?php if($user->profile_image) {?>
                                        <img src="<?= imageBasePath($user->profile_image) ?>" width="60" style="float:left;"/>
                                    <?php } ?>
                                    <input type="file" name="profile_image">
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="row">
                            <div class="col-sm-offset-1 col-sm-6">
                                <button id="saveBtn" class="btn btn-success" type="button"><i class="fa fa-check"></i> <?= lang('save') ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="change-password-tab">
                        <p class="alert message_box hide"></p>
                        <form id="change-password-frm" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label required"><?= lang('current_password') ?></label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="current_password" placeholder="<?= lang('current_password') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label required"><?= lang('password') ?></label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="password" placeholder="<?= lang('password') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label required"><?= lang('confirm_password') ?></label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="<?= lang('confirm_password') ?>">
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="row">
                            <div class="col-sm-offset-1 col-sm-6">
                                <button id="changePasswordBtn" class="btn btn-success" type="button"><i class="fa fa-check"></i> <?= lang('update') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    jQuery(function($) {
        $('[name="mobile"]').intlTelInput();
        if('<?= $user->dial_code ?>' in dial_codes) {
            $("[name='mobile']").intlTelInput("setCountry", dial_codes['<?= $user->dial_code ?>']);
        }

        $(document).on('click','#saveBtn',function(e) {
            e.preventDefault();
            const btn = $(this);
            const loader = $('#basic-info-tab .message_box');

            if($.trim($('[name="mobile"]').val()) != '' && $('[name="mobile"]').intlTelInput("isValidNumber") == false) {
                $('.message_box').html('<?= lang('invalid_mobile_no') ?>').removeClass('alert-success hide').addClass('alert-danger');;
                return false;
            }

            var phone = $('[name="mobile"]').intlTelInput("getSelectedCountryData");
            $('[name="mobile"]').val(filter_number($('[name="mobile"]').val()));
            var fd = new FormData($('#save-frm')[0]);
            fd.append('dial_code', phone.dialCode);
            
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '<?= site_url('admin/profile/update') ?>',
                data: fd,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    btn.attr('disabled', true);
                    loader.html('<?= lang("loader_message") ?>').removeClass('alert-success alert-danger hide').addClass('alert-info');
                },
                error: function(jqXHR, exception) {
                    btn.attr('disabled', false);
                    loader.html(formatErrorMessage(jqXHR, exception)).removeClass('alert-info').addClass('alert-danger');
                },
                success: function (data) {
                    btn.attr('disabled', false);
                    loader.html(data.msg).removeClass('alert-danger').addClass('alert-success');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            });
        });

        $(document).on('click','#changePasswordBtn',function(e) {
            e.preventDefault();
            const btn = $(this);
            const loader = $('#change-password-tab .message_box');
            
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '<?= site_url('admin/profile/change_password') ?>',
                data: new FormData($('#change-password-frm')[0]),
                processData: false,
                contentType: false,
                beforeSend: function() {
                    btn.attr('disabled', true);
                    loader.html('<?= lang("loader_message") ?>').removeClass('alert-success alert-danger hide').addClass('alert-info');
                },
                error: function(jqXHR, exception) {
                    btn.attr('disabled', false);
                    loader.html(formatErrorMessage(jqXHR, exception)).removeClass('alert-info').addClass('alert-danger');
                },
                success: function (data) {
                    btn.attr('disabled', false);
                    loader.html(data.msg).removeClass('alert-danger').addClass('alert-success');
                }
            });
        });
    });
</script>