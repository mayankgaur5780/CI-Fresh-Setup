<section class="content-header">
    <ol class="breadcrumb">
        <li>
            <a href="<?= site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?= lang('dashboard') ?></a>
	    </li>
        <li class="active"><?= lang('all_admins') ?></li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <h3 class="box-title"><?= lang('all_admins') ?></h3>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <a href="<?= site_url('admin/admins/create') ?>" class="btn btn-success pull-right"><?= lang('create_new') ?></a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover dataTable" id="data-table">
                        <thead>
                            <tr>
                                <th><?= lang('role') ?></th>
                                <th><?= lang('name') ?></th>
                                <th><?= lang('email') ?></th>
                                <th><?= lang('mobile') ?></th>
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

        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= site_url('admin/admins/listing') ?>',
                type: 'POST'
            },
            columns : [
                { data: "role"},
                { data: "name"},
                { data: "email"},
                { 
                    data: "mobile",
                    mRender: function (data, type, row) {
                        return `+${row.dial_code} ${data}`;
                    }
                },
                { 
                    data: "status",
                    mRender: function (data, type, row) {
                        return statusArr[data];
                    }
                },
                {
                    mRender: function (data, type, row) {
                        return `
                            <a href="<?= site_url('admin/admins/update') ?>/${row.id}" title="<?= lang('update') ?>"><i class="fa fa-edit fa-fw"></i></a>
                            <a href="<?= site_url('admin/admins/view') ?>/${row.id}" title="<?= lang('view') ?>"><i class="fa fa-eye fa-fw"></i></a>    
                            <a href="<?= site_url('admin/admins/change_password') ?>/${row.id}" title="<?= lang('change_password') ?>"><i class="fa fa-key fa-fw"></i></a>    
                            <a href="<?= site_url('admin/admins/delete') ?>/${row.id}" title="<?= lang('delete') ?>" class="delete-entry"><i class="fa fa-trash fa-fw"></i></a>    
                        `;
                    }, 
                    orderable: false,
                    searchable: false,
                }
	        ]
        });

        $('#data-table').on('click', '.delete-entry', function(e){
            e.preventDefault();
            if (confirm("<?= lang('are_you_sure') ?>")) {
                var href = $(this).attr('href');
                $.get( href, function( data ) {
                    $('#data-table').DataTable().ajax.reload();
                });
            }
        });
    });
</script>