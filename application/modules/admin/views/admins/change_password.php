<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?=site_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i> <?=lang('dashboard')?></a></li>
        <li><a href="<?=site_url('admin/admins')?>"><?=lang('all_admins')?></a></li>
        <li class="active"><?=lang('change_password')?></li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=lang('change_password')?> - <?=$admin->name?></h3>
                </div>
                <div class="box-body">
                    <p class="alert message_box hide"></p>
                    <form class="form-horizontal" id="save-frm">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label required"><?=lang('password')?></label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="password" placeholder="<?=lang('password')?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label required"><?=lang('confirm_password')?></label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="<?=lang('confirm_password')?>">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-footer">
                    <div class="col-sm-offset-1 col-sm-6">
                        <button type="button" class="btn btn-success" id="saveBtn"><i class="fa fa-check"></i> <?=lang('update')?></button>
                        <a class="btn btn-default" onclick="window.history.go(-1); return false;"><?=lang('back')?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    jQuery(function($) {
        $(document).on('click','#saveBtn',function(e){
            e.preventDefault();
            let btn = $('#saveBtn');
            let loader = $('.message_box');

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '<?=site_url("admin/admins/change_password_post/{$admin->id}")?>',
                data: $('#save-frm').serialize(),
                beforeSend: function() {
                    btn.attr('disabled',true);
                    loader.html('<?=lang('loader_message')?>').removeClass('alert-success alert-danger hide').addClass('alert-info');
                },
                error: function(jqXHR, exception) {
                    btn.attr('disabled',false);
                    loader.html(formatErrorMessage(jqXHR, exception)).removeClass('alert-info').addClass('alert-danger');
                },
                success: function (data) {
                    btn.attr('disabled',false);
                    loader.html(data.msg).removeClass('hide alert-danger alert-info').addClass('alert-success');
                    window.location.replace('<?=site_url('admin/admins')?>');
                }
            });
        });
    });
</script>