<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
			<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
				<small><?=lang('welcome_back')?> ,
				<?php echo User::displayName(User::get_id()); ?> </small>
			</ul>
			
			<?php $user_id = User::get_id(); ?>

			<section class="panel panel-default">
				<div class="row m-l-none m-r-none bg-black lter">
					<div class="col-sm-6 col-md-3 padder-v b-r b-light">
						<a class="clear" href="<?=base_url()?>projects">
							<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-<?=config_item('theme_color')?>"></i> <i class="fa fa-coffee fa-stack-1x text-white"></i>
							</span>
							<span class="h3 block m-t-xs"><strong><?=App::counter('assign_projects',array('assigned_user'=>$user_id))?> </strong>
						</span> <small class="text-muted text-uc"><?=lang('assigned_projects')?> </small> </a>
					</div>
					<div class="col-sm-6 col-md-3 padder-v b-r b-light">
						<a class="clear" href="<?=base_url()?>messages">
							<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-<?=config_item('theme_color')?>"></i> <i class="fa fa-envelope fa-stack-1x text-white"></i>
							</span>
							<span class="h3 block m-t-xs">
						<strong><?=App::counter('messages',array('user_to'=>$user_id,'deleted'=>'No'))?></strong>
						</span> <small class="text-muted text-uc"><?=lang('messages')?>  </small> </a>
					</div>
					<div class="col-sm-6 col-md-3 padder-v b-r b-light">
						<a class="clear" href="<?=base_url()?>tickets">
							<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-<?=config_item('theme_color')?>"></i> <i class="fa fa-ticket fa-stack-1x text-white"></i>
							</span>
							<?php $dept = User::profile_info($user_id)->department; ?>
							<span class="h3 block m-t-xs">
						<strong><?=App::counter('tickets',array('department'=>$dept))?>  </strong></span>
						<small class="text-muted text-uc"><?=lang('tickets')?>  </small> </a>
					</div>
					<div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
						<a class="clear" href="<?=base_url()?>profile/activities">
							<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-<?=config_item('theme_color')?>"></i> <i class="fa fa-calendar-o fa-stack-1x text-white"></i>
							</span>
							<span class="h3 block m-t-xs">
							<strong><?=App::counter('activities',array('user'=>$user_id))?> </strong>
						</span> <small class="text-muted text-uc"><?=lang('activities')?>  </small> </a>
					</div>
				</div> </section>
				<div class="row">
					<div class="col-md-8">
						<section class="panel panel-default">
						<header class="panel-heading font-bold"> <?=lang('recent_projects')?></header>
						<div class="panel-body">
							
							<table class="table table-striped m-b-none text-sm">
								<thead>
									<tr>
                                    	<th class="col-md-6"><?=lang('project_name')?> </th>
										<th class="col-md-4"><?=lang('progress')?></th>
										<th class="col-options no-sort col-md-2"><?=lang('options')?></th>
									</tr> </thead>
									<tbody>
										
						<?php foreach (Welcome::recent_projects($user_id) as $key => $project) { ?>
										<tr>
						<?php $progress = Project::get_progress($project->project_id); ?>
         <td><a href="<?=base_url()?>projects/view/<?=$project->project_id?>"><?=$project->project_title?></a></td>
											<td>
												<?php $bg = ($progress >= 100) ? 'success' : 'danger'; ?>
							<div class="progress progress-xs progress-striped active">
							<div class="progress-bar progress-bar-<?=$bg?>" data-toggle="tooltip" data-original-title="<?=$progress?>%" style="width: <?=$progress?>%">
													</div>
							</div>
											</td>
											
											<td>
		<a class="btn  btn-success btn-xs" href="<?=base_url()?>projects/view/<?=$project->project_id?>">
												<i class="fa fa-suitcase text"></i> <?=lang('project')?></a>
											</td>
										</tr>
										<?php } ?>

										<?php if(count(Welcome::recent_projects($user_id) > 0)) { ?>
										<tr>
											<td><?=lang('nothing_to_display')?></td><td></td><td></td>
										</tr>
										<?php } ?>
										
										
									</tbody>
								</table>
							</div> <footer class="panel-footer bg-white no-padder">
							<div class="row text-center no-gutter">
								<div class="col-xs-3 b-r b-light">
									<span class="h4 font-bold m-t block">
									<?=App::counter('bugs',array('reporter'=>$user_id))?>
									</span> <small class="text-muted m-b block"><?=lang('reported_bugs')?></small>
								</div>
								<div class="col-xs-3 b-r b-light">
									<span class="h4 font-bold m-t block">
									<?=App::counter('projects',array('progress >='=>'100','assign_to'=>$user_id))?>
									</span> <small class="text-muted m-b block"><?=lang('complete_projects')?></small>
								</div>
								<div class="col-xs-3 b-r b-light">
									<span class="h4 font-bold m-t block">
									<?=App::counter('messages',array('user_to'=>$user_id,'status'=>'Unread'))?>
									</span> <small class="text-muted m-b block"><?=lang('unread_messages')?></small>
								</div>
								<div class="col-xs-3">
									<span class="h4 font-bold m-t block">
									<?=App::counter('comments',array('posted_by'=>$user_id))?>
									</span> <small class="text-muted m-b block"><?=lang('project_comments')?></small>
								</div>
							</div> </footer>
						</section>
					</div>
					
					<div class="col-lg-4">
						<section class="panel panel-default">
							<div class="panel-body">
								<div class="clearfix text-center m-t">
									<div class="inline">
										<div style="width: 130px; height: 130px; line-height: 130px;" class="easypiechart easyPieChart" data-percent="100" data-line-width="5" data-bar-color="#FB6B5B" data-track-color="#f5f5f5" data-scale-color="false" data-size="130" data-line-cap="butt" data-animate="1000">
											<div class="thumb-lg">
												
								<img src="<?php echo User::avatar_url($user_id); ?>" class="img-circle">
												
												
											</div>
										<canvas width="130" height="130"></canvas></div>
										<div class="h4 m-t m-b-xs"><?=User::displayName($user_id);?></div>
							<?php
								$deptid = User::profile_info($user_id)->department;
								$deptname = ($deptid > 0) ? App::get_dept_by_id($deptid) : '';

								$project_timers = App::get_by_where('project_timer',array('user'=>$user_id));
								$task_timers = App::get_by_where('tasks_timer',array('user'=>$user_id));
								$project_hours[] = array();
								$task_hours[] = array();

							foreach ($project_timers as $key => $p_elapsed) {
							
							$project_hours[] = round(($p_elapsed->end_time - $p_elapsed->start_time)/3600,2);
												
							}
							if(is_array($project_hours)){
								$total_project_hours = array_sum($project_hours); 
							}else{ $total_project_hours = 0; }

							foreach ($task_timers as $key => $t_elapsed) {
							
							$task_hours[] = round(($t_elapsed->end_time - $t_elapsed->start_time)/3600,2);
							
							}
							if(is_array($task_hours)){ $total_task_hours = array_sum($task_hours); 
								}else{ $total_task_hours = 0; }
							$worked_hours = $total_task_hours + $total_project_hours;
							$total_cost = $worked_hours * User::profile_info(User::get_id())->hourly_rate;
							?>
										<small class="text-muted m-b"><?=$deptname?></small>
									</div>
								</div>
							</div>
							<footer class="panel-footer bg-danger lter text-center">
								<div class="row pull-out">
									<div class="col-xs-6 dk">
										<div class="padder-v">
											<span class="m-b-xs h3 block text-white"><?=lang('worked')?></span>
											<small class="text-muted"><?=$worked_hours?> <?=lang('hours')?></small>
										</div>
									</div>
									<div class="col-xs-6">
										<div class="padder-v">
											<span class="m-b-xs h3 block text-white"><?=lang('earned')?></span>
											<small class="text-muted"><?=Applib::format_currency(config_item('default_currency'),$total_cost)?></small>
										</div>
									</div>
								</div>
							</footer>
						</section>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<section class="panel panel-default b-light">
						<header class="panel-heading"><?=lang('recent_tasks')?></header>
						<div class="panel-body">
							
							
							<div class="list-group bg-white">
		<?php foreach (Welcome::recent_tasks($user_id) as $key => $task) { ?>
		<div class="list-group-item">

		<?php if(Project::is_assigned($user_id, $task->project)) {  ?>

                        <!-- mark as complete checkbox -->
                        <span class="task_complete">
 
                        <input type="checkbox" data-id="<?=$task->t_id?>"
                        <?php if($task->task_progress == '100') { 
                          echo 'checked="checked"'; } ?> 
                          <?php if($task->timer_status == 'On') { echo 'disabled="disabled"'; } ?>>


                        </span>
        <?php }  ?>


								<a href="<?=base_url()?>projects/view/<?=$task->project?>?group=tasks&view=task&id=<?=$task->t_id?>"> <?=$task->task_name?> - <small class="text-muted">
								<?=Project::by_id($task->project)->project_title; ?></small>
								</a>
								</div>
		<?php } ?>
							</div>
						</div>
					</section>
				</div>



				<!-- Recent activities -->
				<div class="col-md-4">
			<section class="panel panel-default b-light">
			<header class="panel-heading"><?= lang('recent_activities') ?></header>
			<div class="panel-body">
				<section class="comment-list block">
					<section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
						
				<?php foreach (Welcome::recent_activities($user_id) as $key => $activity) { ?>

						<article id="comment-id-1" class="comment-item small">
							<div class="pull-left thumb-sm">
								
								<img src="<?=User::avatar_url($activity->user); ?>" class="img-circle">

							</div>
							<section class="comment-body m-b-lg">
								<header class="b-b">
									<strong>
									<?php echo User::displayName($activity->user); ?></strong>
									<span class="text-muted text-xs"> 
									<?php echo Applib::time_elapsed_string(strtotime($activity->activity_date)); ?>
									</span>
								</header>
								<div>
									<?php
									if (lang($activity->activity) != '') {
										if (!empty($activity->value1)) {
											if (!empty($activity->value2)) {
												echo sprintf(lang($activity->activity), '<em>' . $activity->value1 . '</em>', '<em>' . $activity->value2 . '</em>');
											} else {
												echo sprintf(lang($activity->activity), '<em>' . $activity->value1 . '</em>');
											}
										} else {
											echo lang($activity->activity);
										}
									} else {
										echo $activity->activity;
									}
									?>
								</div>
							</section>
						</article>
						<?php } ?>
					</section>
				</section>
			</div>
		</section>
	</div>
		</div>
	</section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>