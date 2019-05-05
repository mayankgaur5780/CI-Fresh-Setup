<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?= lang('dashboard') ?></a></li>
        <li><a href="<?= site_url('admin/roles') ?>"><?= lang('all_roles') ?></a></li>
        <li class="active"><?= lang('update_role') ?></li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <p class="alert message_box hide"></p>
                    <form class="form-horizontal" id="update-form">
                        <input type="hidden" name="navigation_id[]" value="1"> 
                        <?php if(count($navigation)) { ?> 
                            <?php foreach($navigation as $group) { ?>
                                <div class="row">
                                    <div id="permission-user-<?= $group['id'] ?>" class="col-md-12">
                                        <label for="chkAll_<?= $group['id'] ?>" class="col-md-3 col-md-offset-1">
                                            <strong><?= $group['name'] ?></strong>
                                        </label>
                                        <div class="col-md-8">
                                            <label>
                                                <input type="checkbox" id="chkAll_<?= $group['id'] ?>" name="navigation_id[]" value="<?= $group['id'] ?>" class="checkAll" <?= $group['id'] == 1 ? 'disabled' : '' ?> <?= $group['id'] == 1 ? 'checked' : (in_array($group['id'], $rolePermissions) ? 'checked' : '') ?>> 
                                            </label>
                                        </div>
    
                                        <?php if(isset($group['children']) && count($group['children']))  { ?>
                                            <?php foreach ($group['children'] as $nav) { ?>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <label for="chkAll_<?= $nav['id'] ?>" class="col-md-3 col-md-offset-1 small_label"><?= $nav['name'] ?></label>
                                                        <div class="col-md-2">
                                                            <label>
                                                                <input type="checkbox" id="chkAll_<?= $nav['id'] ?>" name="navigation_id[]" value="<?= $nav['id'] ?>" <?= in_array($nav['id'], $rolePermissions) ? 'checked' : '' ?>> 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?> 
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?> 
                        <?php } ?>
                    </form>
                </div>
                <div class="box-footer">
                    <div class="col-md-offset-1 col-md-6">
                        <button type="button" class="btn btn-success" id="updateBtn"><i class="fa fa-check"></i> <?= lang('save_permission') ?></button>
                        <a class="btn btn-default" onclick="window.history.go(-1); return false;"><?= lang('back') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    jQuery(function($) {
        $(document).on('change', '.checkAll', function(e){
            var ContainerID = $(this).val();
            var status = this.checked ? true : false;
            $("#permission-user-"+ContainerID).find("input[type=checkbox]").each(function(){
                this.checked = status;
            })  
        });

        $(document).on('click','#updateBtn',function(e){
            e.preventDefault();
            let btn = $('#updateBtn');
            let loader = $('.message_box');
            
            $.ajax({
                url: '<?= site_url("admin/roles/permissions_post/{$id}") ?>',
                data: $('#update-form').serialize(),
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
                    window.location.replace('<?= site_url('admin/roles') ?>');
                }
            });
        });
    });
</script>