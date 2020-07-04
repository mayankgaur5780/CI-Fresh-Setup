<section class="content-header">
    <ol class="breadcrumb">
        <li>
            <a href="<?= site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?= lang('dashboard') ?></a>
	    </li>
        <li class="active"><?= lang('all_roles') ?></li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <h3 class="box-title"><?= lang('all_roles') ?></h3>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <a href="<?= site_url('admin/roles/create') ?>" class="btn btn-success pull-right"><?= lang('create_new') ?></a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover dataTable" id="role-table">
                        <thead>
                            <tr>
                                <th><?= lang('name') ?></th>
                                <th><?= lang('status') ?></th>
                                <th><?= lang('action') ?></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
	$(function() {  
        let statusArr = <?= json_encode(config_item('action_status')) ?>;

        $('#role-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= site_url('admin/roles/listing') ?>',
                type: 'POST'
            },
            columns : [
                { data: "name"},
                { 
                    data: "status",
                    mRender: function (data, type, row) {
                        return statusArr[data];
                    }
                },
                {
                    mRender: function (data, type, row) {
                        return `
                            <a href="<?= site_url('admin/roles/update') ?>/${row.id}" title="<?= lang('update') ?>"><i class="fa fa-edit fa-fw"></i></a>
                            <a href="<?= site_url('admin/roles/permissions') ?>/${row.id}" title="<?= lang('permissions') ?>"><i class="fa fa-universal-access fa-fw"></i></a>    
                        `;
                    }, 
                    orderable: false,
                    searchable: false,
                }
	        ]
        });
    });
</script>