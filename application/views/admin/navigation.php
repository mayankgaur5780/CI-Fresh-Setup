<?php $userMenuList = $this->session->userdata('navigation_admin'); ?>
<?php $current_url = uri_string(); ?>

 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
			<li class="header nav-header"><?= lang('main_navigation') ?></li>
			<?php if(count($userMenuList)) { ?>
				<?php foreach($userMenuList as $navigation) {?>
                    <?php if($navigation['show_in_menu'] == 1) { ?>
                        <?php if(isset($navigation['children']) && count($navigation['children'])) { ?>
                            <li class="treeview">
                                <a href="<?= site_url($navigation['action_path']) ?>">
                                    <i class="<?= $navigation['icon'] ?>"></i> 
                                    <span><?= $navigation['name'] ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
								<ul class="treeview-menu">
									<?php foreach($navigation['children'] as $sub_menu) { ?>
										<?php if($sub_menu['show_in_menu'] == 1) { ?>
											<li class="<?= strpos($current_url, $sub_menu['action_path']) !== false ? 'active' : '' ?>">
												<a href="<?= site_url($sub_menu['action_path']) ?>"><i class="fa fa-circle-o"></i><?= $sub_menu['name'] ?></a>
											</li>
										<?php } ?>
									<?php } ?>
								</ul>
                            </li>
						<?php } else { ?>
                            <li class="<?= strpos($current_url, $navigation['action_path']) !== false ? 'active' : '' ?>">
                                <a href="<?= site_url($navigation['action_path']) ?>">
                                    <i class="<?= $navigation['icon'] ?>"></i> 
                                    <span><?= $navigation['name'] ?></span>
                                </a>
                            </li>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
        </ul>
    </section>
</aside>