<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?=site_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i> <?=lang('dashboard')?></a></li>
        <li><a href="<?=site_url('admin/admins')?>"><?=lang('all_admins')?></a></li>
        <li class="active"><?=lang('view')?></li>
	</ol>
</section>

<section class="content">
    <p><a class="btn btn-success" href="<?=site_url("admin/admins/update/{$admin->id}")?>"><?=lang('update')?></a></p>
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#details_tab"><?=lang('basic_details')?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="details_tab">
                        <table class="table table-striped table-bordered no-margin">
                            <tbody>
                                <tr>
                                    <th width="20%"><?= lang('name') ?></th>
                                    <td><?= $admin->name ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('email') ?></th>
                                    <td><?= $admin->email ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('mobile') ?></th>
                                    <td><?= "+{$admin->dial_code} {$admin->mobile}" ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('role') ?></th>
                                    <td><?= $admin->role->name ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('status') ?></th>
                                    <td><?= config_item('action_status')[$admin->status] ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('profile_image') ?></th>
                                    <td>
                                        <?php if($admin->profile_image) {?>
                                            <img src="<?= imageBasePath($admin->profile_image) ?>" width="60" style="float:left;"/>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>