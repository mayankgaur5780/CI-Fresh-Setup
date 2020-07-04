<section class="content-header">
    <ol class="breadcrumb">
        <li>
            <a href="<?= site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?= lang('dashboard') ?></a>
	    </li>
        <li class="active"><?= lang('all_navigation') ?></li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <h3 class="box-title"><?= lang('all_navigation') ?></h3>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <a href="<?= site_url('admin/navigation/create') ?>" class="btn btn-success pull-right"><?= lang('create_new') ?></a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover dataTable" id="data-table">
                        <thead>
                            <tr>
                                <th><?= lang('name') ?></th>
                                <th><?= lang('display_order') ?></th>
                                <th><?= lang('has_parent') ?></th>
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
        let actionArr = <?= json_encode(config_item('other_status')) ?>;

        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= site_url('admin/navigation/listing') ?>',
                type: 'POST'
            },
            columns : [
                { data: "name"},
                { data: "display_order"},
                { 
                    data: "parent_id",
                    mRender: function (data, type, row) {
                        return actionArr[(data != null ? 1 : 0)];
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
                            <a href="<?= site_url('admin/navigation/update') ?>/${row.id}" title="<?= lang('update') ?>"><i class="fa fa-edit fa-fw"></i></a>
                            <a href="<?= site_url('admin/navigation/delete') ?>/${row.id}" title="<?= lang('delete') ?>" class="delete-entry"><i class="fa fa-trash fa-fw"></i></a>    
                        `;
                    }, 
                    orderable: false,
                    searchable: false,
                }
	        ]
        });

        $('#data-table').on('click', '.delete-entry', function(e){
            e.preventDefault();
            
            if (confirm('<?= lang('delete_record_alert') ?>')) {
                var href = $(this).attr('href');
                $.get( href, function( data ) {
                    $('#data-table').DataTable().ajax.reload();
                });
            }
        });
    });
</script>