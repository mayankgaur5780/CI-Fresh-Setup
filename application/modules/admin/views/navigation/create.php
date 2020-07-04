<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?= lang('dashboard') ?></a></li>
        <li><a href="<?= site_url('admin/navigation') ?>"><?= lang('all_navigation') ?></a></li>
        <li class="active"><?= lang('create_navigation') ?></li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= lang('create_navigation') ?></h3>
                </div>
                <div class="box-body">
                    <p class="alert message_box hide"></p>
                    <form class="form-horizontal" id="create-form">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label required"><?= lang('name') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" placeholder="<?= lang('name') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label required"><?= lang('action_path') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="action_path" placeholder="<?= lang('action_path') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label required"><?= lang('display_order') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="display_order" placeholder="<?= lang('display_order') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label"><?= lang('icon') ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="icon" placeholder="<?= lang('icon') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label"><?= lang('parent') ?></label>
                            <div class="col-sm-6">
                                <select class="form-control select2-class" name="parent_id" data-placeholder="<?= lang('choose') ?>">
                                    <option value=""></option>
                                    <?php if(count($navigation_list)) { ?>
                                        <?php foreach($navigation_list as $row) { ?>
                                            <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label required"><?= lang('show_in_menu') ?></label>
                            <div class="col-sm-6">
                                <select class="form-control select2-class" name="show_in_menu" data-placeholder="<?= lang('choose') ?>">
                                    <option value=""></option>
                                    <?php foreach(config_item('other_status') as $key => $val) { ?>
                                        <option value="<?= $key ?>" <?= $key == 1 ? 'selected' : '' ?>><?= $val ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label required"><?= lang('show_in_permission') ?></label>
                            <div class="col-sm-6">
                                <select class="form-control select2-class" name="show_in_permission" data-placeholder="<?= lang('choose') ?>">
                                    <option value=""></option>
                                    <?php foreach(config_item('other_status') as $key => $val) { ?>
                                        <option value="<?= $key ?>" <?= $key == 1 ? 'selected' : '' ?>><?= $val ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label required"><?= lang('status') ?></label>
                            <div class="col-sm-6">
                                <select class="form-control select2-class" name="status" data-placeholder="<?= lang('choose') ?>">
                                    <option value=""></option>
                                    <?php foreach(config_item('action_status') as $key => $val) { ?>
                                        <option value="<?= $key ?>" <?= $key == 1 ? 'selected' : '' ?>><?= $val ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-footer">
                    <div class="col-sm-offset-1 col-sm-6">
                        <button type="button" class="btn btn-success" id="createBtn"><i class="fa fa-check"></i> <?= lang('create') ?></button>
                        <a class="btn btn-default" onclick="window.history.go(-1); return false;"><?= lang('back') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    jQuery(function($) {
      $(document).on('click','#createBtn',function(e){
            e.preventDefault();
            let btn = $('#createBtn');
            let loader = $('.message_box');
            
            $.ajax({
                url: '<?= site_url('admin/navigation/create_post') ?>',
                data: $('#create-form').serialize(),
                dataType: 'json',
                type: 'POST',
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
                    window.location.replace('<?= site_url('admin/navigation') ?>');
                }
            });
        });
    });
</script>