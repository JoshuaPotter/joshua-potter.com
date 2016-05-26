<section id="content">
	<section class="hbox stretch">
		<?php 
		$role = User::login_info(User::get_id())->role_id;
		$this->load->helper('text');
		$p = Project::by_id($project);
		?>

			<!-- Sidebar start -->
			<aside class="aside aside-md bg-white small">
				<section class="vbox">



				
					<header class="dk header b-b merged">
						<a class="btn btn-icon btn-default btn-sm pull-right visible-xs m-r-xs" data-toggle="class:show" data-target="#setting-nav"><i class="fa fa-reorder"></i></a>
							<p class="h4"><?=$p->project_title?></p>
						</header>




						<section class="scrollable bg-light">
							<section class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">

								<section id="setting-nav" class="hidden-xs">
									<ul class="nav nav-pills nav-stacked no-radius">

                    <?php
                        switch ($role) {
                            case 1: $ext = 'admin'; break; 
                            case 2: $ext = 'client'; break; 
                            case 3: $ext = 'staff'; break; 
                        }
                    $menus = $this->db->where('access',$role)->where('visible',1)->where('hook','projects_menu_'.$ext)->order_by('order','ASC')->get('hooks')->result();
                    foreach ($menus as $menu) { 
                        $perm = TRUE;
                        $label = $this->db->where('parent',$menu->module)->where('hook','project_menu_label_'.$ext)->get('hooks')->result();
                    ?>

           
          <?php if($menu->permission != '') { $perm = Project::setting($menu->permission,$p->project_id); } ?>

                    <?php if($perm){ $timer_on = 0;
                    	if ($menu->module == 'project_tasks') { $timer_on = App::counter('tasks',array('project'=>$p->project_id,'timer_status'=>'On')); } ?>

                    <li class="<?php echo ($group == $menu->route) ? 'active' : '';?>">
                        <a href="<?=base_url()?>projects/view/<?=$p->project_id?>/?group=<?=$menu->route?>">
                            <i class="fa fa-fw <?=$menu->icon?>"></i>
                        <?=lang($menu->name)?>

                        <?php if (count($label) > 0) { $lab = modules::run($label[0]->route,$p->project_id); ?>
                        <span class="label label-default pull-right"><?php if ($lab > 0) { echo $lab; }  ?></span><?php } ?>
                        
                        <?php if($timer_on > 0){?><span class="label label-danger pull-right m-r-xs"><i class="fa fa-refresh fa-spin"></i> <?=$timer_on?></span><?php } ?>
                        </a> 
                    </li>
                    <?php } ?>
                    <?php } ?>
										</ul>
										
									</section>
								</section>
							</section>
						</section>
					</aside>





					<!--  Sidebar end -->


					<aside class="bg-light lter b-l">
						<section class="vbox">
							<header class="header bg-white b-b clearfix">
								<div class="row m-t-sm">
									<div class="col-sm-12 m-b-xs">


				<?php if (User::is_admin() || User::perm_allowed(User::get_id(),'delete_projects')){ ?>
									 <a href="<?=base_url()?>projects/delete/<?=$p->project_id?>?group=<?=$group?>" data-toggle="ajaxModal" title="<?=lang('delete_project')?>" class="btn btn-default btn-sm pull-right"><i class="fa fa-trash-o"></i> </a>
				<?php } ?>




				<?php if (User::is_admin() || User::perm_allowed(User::get_id(),'edit_all_projects')){ ?>
									 <a data-toggle="tooltip" data-original-title="<?=lang('edit_project')?>" data-placement="bottom" href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=<?=$group?>&action=edit" class="btn btn-<?=config_item('theme_color')?> btn-sm pull-right"><i class="fa fa-edit"></i> </a>

				<?php } ?>

				<?php if (User::is_admin() || Project::is_assigned(User::get_id(),$p->project_id)){ ?>

							<?php if($p->client > 0) { ?>
							<?php if (User::is_admin() || User::perm_allowed(User::get_id(),'add_invoices')){ ?>
									 <a href="<?=base_url()?>projects/invoice/<?=$p->project_id?>" class="btn btn-<?=config_item('theme_color')?> btn-sm pull-right" data-toggle="ajaxModal"><i class="fa fa-money"></i> <?=lang('invoice_project')?>
									 </a>
									 <?php } ?>
							<?php } ?>
							<?php if (User::is_admin()){ ?>
									 <a href="<?=base_url()?>projects/copy_project/<?=$p->project_id?>" data-toggle="ajaxModal" class="btn btn-<?=config_item('theme_color')?> btn-sm pull-right" title="<?=lang('clone_project')?>" data-placement="bottom"><i class="fa fa-clone"></i> 
									 <?=lang('clone_project')?></a>
							<?php } ?>

									 <?php if ($p->auto_progress == 'TRUE') {
									 	$button_text = 'auto_progress_off';
									 }else{
									 	$button_text = 'auto_progress_on';
									 } ?>

									 <a data-toggle="tooltip" data-original-title="<?=lang($button_text)?>" data-placement="bottom" href="<?=base_url()?>projects/auto_progress/<?=$p->project_id?>" class="btn btn-sm btn-<?=config_item('theme_color')?> pull-right"> <i class="fa fa-rocket text-white"></i> 
									 </a>


									 <?php if ($p->auto_progress == 'TRUE') { ?>
									 <a data-toggle="ajaxModal" title="<?=lang('mark_as_complete')?>" href="<?=base_url()?>projects/mark_as_complete/<?=$p->project_id?>" class="btn btn-sm btn-<?=config_item('theme_color')?> pull-right"> <i class="fa fa-check text-white"></i> 
									 </a>
									 <?php } ?>



			<?php } ?>






			<?php if ($role != '2'){
										if($p->timer == 'On') { $label = 'danger'; } else{ $label = 'success'; } 
										if ($p->timer == 'On') { ?>
										<a data-toggle="tooltip" data-original-title="<?=lang('stop_timer')?>" data-placement="bottom" href="<?=base_url()?>projects/tracking/off/<?=$p->project_id?>" class="btn btn-sm btn-<?=$label?> pull-right"> <i class="fa fa-clock-o text-white"></i> </a>
										<?php }else{ ?>
										<a data-toggle="tooltip" data-original-title="<?=lang('start_timer')?>" data-placement="bottom" href="<?=base_url()?>projects/tracking/on/<?=$p->project_id?>" class="btn btn-sm btn-<?=$label?> pull-right"> <i class="fa fa-clock-o text-white"></i> </a>
										<?php } ?>

			<?php } ?>



									</div>
								</div>
							</header>
							<section class="scrollable wrapper">
								<!-- Load the settings form in views -->
								<?php
								if(isset($_GET['action']) == 'edit'){ 
									$data['project_id'] = $p->project_id;
									$this->load->view('group/edit_project',$data); 
								}
								else{
									$data['project_id'] = $p->project_id;
									$this->load->view('group/'.$group,$data);
								}
								?>
								<!-- End of settings Form -->
							</section>

						</section>
					</aside>
				</section>
				<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
			</section>