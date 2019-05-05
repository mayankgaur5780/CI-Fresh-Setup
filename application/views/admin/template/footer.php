</div>

<footer class="main-footer">
    <strong><?= lang('copyright') ?> &copy; <?= date('Y') ?> <a><?= config_item('company_name') ?></a>.</strong> <?= lang('all_rights_reserved') ?>.
</footer>


<div id="default_container_modal" class="modal fade" tabindex="-1" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content"></div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<div id="default_md_container_modal" class="modal fade" tabindex="-1" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content"></div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	jQuery(function(e) {
		$(document).on('click', 'a[data-toggle="modal"]', function (e) {
			e.preventDefault();
			var target_element = $(this).data('target');
			$(target_element).find('.modal-content').html(`
				<div class="modal-body">
						<div class="row">
							<div class="col-md-12 center"><?= lang("loader_message") ?></div>
						</div>
					</div>
				</div>
			`);
		});
		
		/** for default_container_modal **/
		$('#default_container_modal').on('hidden.bs.modal', function (e) {
			$(this).removeData();
			$(this).find('.modal-content').empty();
		});
		$('#default_container_modal').on('show.bs.modal', function (e) {});
		
		/** for default_md_container_modal **/
		$('#default_md_container_modal').on('hidden.bs.modal', function (e) {
			$(this).removeData();
			$(this).find('.modal-content').empty();
		});
		$('#default_md_container_modal').on('show.bs.modal', function (e) {});
	});
</script>

</div>
</body>
</html>