<section class="content-header">
    <h1><?=lang('dashboard')?></h1>
    <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> <?=lang('dashboard')?></li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><span class="total_users"><i class="fa fa-spinner fa-pulse"></i></span></h3>
                    <p><?=lang('users')?></p>
                </div>
                <div class="icon"><i class="fa fa-users"></i></div>
                <a href="<?=site_url('admin/users')?>" class="small-box-footer"><?=lang('more_info')?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
jQuery(function ($) {
    function getDashboardStats()
    {
        $.ajax({
            dataType: 'json',
            type: 'GET',
            url: '<?= site_url("admin/dashboard/get_stats") ?>',
            success: result => {
                $.each(result, (index, el) => {
                    $(`.${index}`).text(el);
                })
            }
        });
    }

    setTimeout(() => {
        getDashboardStats();
    }, 200);
});
</script>