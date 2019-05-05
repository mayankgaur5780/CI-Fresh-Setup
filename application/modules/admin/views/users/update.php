<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?= lang('dashboard') ?></a></li>
        <li><a href="<?= site_url('admin/users') ?>"><?= lang('all_users') ?></a></li>
        <li class="active"><?= lang('update_user') ?></li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= lang('update_user') ?></h3>
                </div>
                <div class="box-body">
                    <p class="alert message_box hide"></p>
                    <form class="form-horizontal" id="save-frm">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label required"><?= lang('name') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" placeholder="<?= lang('name') ?>" value="<?= $user->name ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label required"><?= lang('email') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="email" placeholder="<?= lang('email') ?>" value="<?= $user->email ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label required"><?= lang('mobile') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="mobile" placeholder="<?= lang('mobile') ?>" value="<?= $user->mobile ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label required"><?= lang('status') ?></label>
                            <div class="col-sm-6">
                                <select class="form-control select2-class" name="status" data-placeholder="<?= lang('choose') ?>">
                                    <option value=""></option>
                                    <?php foreach(config_item('action_status') as $key => $val) { ?>
                                        <option value="<?= $key ?>" <?= $key == $user->status ? 'selected' : '' ?>><?= $val ?></option>
                                    <?php } ?>
                            </select>
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
                </div>
                <div class="box-footer">
                    <div class="col-sm-offset-1 col-sm-6">
                        <button type="button" class="btn btn-success" id="saveBtn"><i class="fa fa-check"></i> <?= lang('save') ?></button>
                        <a class="btn btn-default" onclick="window.history.go(-1); return false;"><?= lang('back') ?></a>
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

        $(document).on('click','#saveBtn',function(e){
            e.preventDefault();
            let btn = $('#saveBtn');
            let loader = $('.message_box');

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
                url: '<?= site_url("admin/users/update_post/{$user->id}") ?>',
                data: fd,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    btn.attr('disabled',true);
                    loader.html('<?= lang('loader_message') ?>').removeClass('alert-success alert-danger hide').addClass('alert-info');
                },
                error: function(jqXHR, exception) {
                    btn.attr('disabled',false);
                    loader.html(formatErrorMessage(jqXHR, exception)).removeClass('alert-info').addClass('alert-danger');
                },
                success: function (data) {
                    btn.attr('disabled',false);
                    loader.html(data.msg).removeClass('hide alert-danger alert-info').addClass('alert-success');
                    window.location.replace('<?= site_url('admin/users') ?>');
                }
            });
        });
    });
</script>