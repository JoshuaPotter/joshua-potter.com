<link rel="stylesheet" href="<?=base_url()?>resource/css/tasks.css" type="text/css" />

<div class="row">

    <div class="panel panel-body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active">
                <a class="active" data-toggle="tab" href="#tab-dashboard"><?=lang('dashboard')?></a></li>
            <li><a data-toggle="tab" href="#tab-activities"><?=lang('activities')?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="tab-dashboard">

                <!-- begin dashboard tab-->
                <?php
                $all_tasks = App::counter('tasks',array('project'=>$project_id));

                $done_tasks = App::counter('tasks',array('project'=>$project_id,'task_progress >='=>'100'));

                $in_progress = App::counter('tasks',array('project'=>$project_id,'task_progress <'=>'100'));

                $perc_done = $perc_progress = 0;

                if ($all_tasks > 0) {
                    $perc_done = ($done_tasks/$all_tasks) *100;
                    $perc_progress = ($in_progress/$all_tasks)*100;
                }

                $progress =  Project::get_progress($project_id);

                $project_hours = Project::total_hours($project_id);

                $project_cost = Project::sub_total($project_id);
                $info = Project::by_id($project_id);
                ?>
                <?php if($info->client <= 0) { ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-info-sign"></i>
                        No Client attached to this project.
                    </div>
                <?php } ?>

                <div>
                    <strong><?=lang('progress')?></strong>
                    <div class="pull-right">
                        <strong class="<?=($progress < 100) ? 'text-danger' : 'text-success'; ?>"><?=$progress?>%</strong>
                    </div>
                </div>


                <div class="progress-xxs mb-0 <?=($progress != '100') ? 'progress-striped active' : ''; ?> inline-block progress">
                    <div class="progress-bar progress-bar-<?=config_item('theme_color')?> " data-toggle="tooltip" data-original-title="<?=$progress?>%" style="width: <?=$progress?>%"></div>
                </div>

                <hr>


                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-group no-radius">


                            <?php $currency = ($info->client > 0) ? Client::get_currency_code($info->client)->code : $info->currency; ?>


                            <li class="list-group-item">

              <span class="pull-right">
              <?=$info->project_title?>
              </span><?=lang('project_name')?>


                            </li>
                            <?php if (User::is_admin() || User::is_client() ||
                                User::perm_allowed(User::get_id(),'view_project_clients')){ ?>

                                <?php if($info->client > 0) { ?>
                                    <li class="list-group-item">
                

              <span class="pull-right">
              <a href="<?=site_url()?>companies/view/<?=$info->client?>">
                  <?php echo Client::view_by_id($info->client)->company_name; ?>
              </a>
               </span><?=lang('client_name')?>

                                    </li>
                                <?php } ?>
                            <?php } ?>


                            <li class="list-group-item">


              <span class="pull-right">
              <?=(strtotime($info->start_date) == 0 ? "" : strftime(config_item('date_format'), strtotime($info->start_date)))?>
              </span><?=lang('start_date')?>

                            </li>


                            <li class="list-group-item">

                <span class="pull-right">
                <?=strftime(config_item('date_format'), strtotime($info->due_date))?>
                    <?php if (time() > strtotime($info->due_date) AND $progress < 100){ ?>
                        <span class="badge bg-danger"><?=lang('overdue')?></span>
                    <?php } ?>
              </span><?=lang('due_date')?>
                            </li>

                            <?php if (User::is_admin() || User::is_staff() || Project::setting('show_team_members',$project_id)) { ?>

                                <li class="list-group-item">
                <span class="pull-right">
                <small class="small">
                    <a class="thumb-xs pull-left m-r-sm">
                        <?php foreach (Project::project_team($project_id) as $user) { ?>

                            <img src="<?php echo User::avatar_url($user->assigned_user); ?>" class="img-circle" data-toggle="tooltip" data-title="<?=User::displayName($user->assigned_user)?>" data-placement="left">

                        <?php }  ?>
                    </a>



                </small>
                </span><?=lang('assigned_to')?>
                                </li>
                            <?php } ?>

                            <?php if (User::is_admin() || User::is_client() || User::perm_allowed(User::get_id(),'view_project_cost')){ ?>
                                <li class="list-group-item">
                <span class="pull-right">
                <strong><?=$info->estimate_hours;?> </strong><small><?=lang('hours')?></small>
        
                </span>
                                    <?=lang('estimated_hours')?>
                                </li>
                            <?php } ?>





                        </ul>
                    </div>
                    <!-- End details C1-->


                    <div class="col-lg-6">
                        <ul class="list-group no-radius">
                            <?php if (User::is_admin() || User::is_client() || User::perm_allowed(User::get_id(),'view_project_cost')){ ?>
                                <li class="list-group-item">
                                    <span class="pull-right"><strong><?=$project_hours?> <?=lang('hours')?></strong></span>
                                    <?=lang('logged_hours')?>
                                </li>

                            <?php } ?>


                            <?php if (User::is_admin() || User::is_client() || User::perm_allowed(User::get_id(),'view_project_cost')){ ?>
                                <li class="list-group-item">
                <span class="pull-right">
                <strong>
                    <?php echo Applib::format_currency($currency, $project_cost); ?>
                </strong>
                    <?php if ($info->fixed_rate == 'No') { ?>
                    <small class="small text-muted">
                        <?=$info->hourly_rate."/".lang('hour')?>
                        <?php } ?>

                    </small>
                </span>
                                    <?=lang('project_cost')?>
                                </li>
                            <?php } ?>




                            <?php if (User::is_admin() || User::is_client() || User::perm_allowed(User::get_id(),'view_project_cost')){ ?>
                                <li class="list-group-item">
                <span class="pull-right">
      <?php
      $used_budget = NULL;
      if($info->estimate_hours > 0) $used_budget = round(($project_hours / $info->estimate_hours) * 100,2);
      ?>
                    <strong class="<?=($used_budget >100) ? 'text-danger' : 'text-success'; ?>">
                        <?=($used_budget != NULL) ? $used_budget.' %': 'N/A'; ?>
                    </strong>
        
                </span>
                                    <?=lang('used_budget')?>
                                </li>
                            <?php } ?>

                            <?php if (User::is_admin() ||User::is_client() || User::perm_allowed(User::get_id(),'view_project_expenses')){ ?>

                                <li class="list-group-item">
                <span class="pull-right">
                
                <strong>
                    <?php echo Applib::format_currency($currency, Project::total_expense($project_id))?></strong>

                    <?php if (User::is_admin() || User::perm_allowed(User::get_id(),'add_expenses')){ ?>

                        <a href="<?=site_url()?>expenses/create/?project=<?=$project_id?>" data-toggle="ajaxModal" title="<?=lang('create_expense')?>" class="btn btn-xs btn-<?=config_item('theme_color')?>">
                            <i class="fa fa-plus"></i></a>
                    <?php } ?>

                    <a href="<?=site_url()?>expenses/?project=<?=$project_id?>" data-toggle="tooltip" title="<?=lang('view_expenses')?>" data-placement="left" class="btn btn-xs btn-<?=config_item('theme_color')?>"><i class="fa fa-ellipsis-h"></i></a>
        
                </span>
                                    <?=lang('expenses')?>
                                </li>
                            <?php } ?>

                            <?php if (User::is_admin()){ ?>
                                <li class="list-group-item text-danger">
                <span class="pull-right">
                
                <strong><?php echo Project::unbillable($project_id); ?> <?=lang('hours')?></strong>
        
                </span>
                                    <?=lang('unbillable')?>
                                </li>
                            <?php } ?>


                            <?php if (User::is_admin() || User::is_client() || User::perm_allowed(User::get_id(),'view_project_cost')){ ?>
                                <li class="list-group-item">
                <span class="pull-right">
                <strong class="text-danger">
                    <?=Applib::format_currency($currency, Project::total_expense($project_id) + $project_cost)?>
                </strong>
        
                </span>
                                    <strong><?=lang('billable_amount')?></strong>
                                </li>
                            <?php } ?>



                        </ul>
                    </div>
                </div>
                <div class="line line-dashed line-lg pull-in"></div>

                <div class="small text-muted panel-body m-sm" style="border-left: 2px solid #e8e8e8;"><?=nl2br_except_pre($info->description)?></div>





                <div class="row">

                    <!-- start recent tasks -->

                    <?php if (User::is_admin() || User::is_staff() || Project::setting('show_project_tasks',$project_id)) { ?>

                        <div class="col-sm-6">
                            <section class="panel panel-default b-top tasks-widget">
                                <header class="panel-heading"><?=lang('recent_tasks')?></header>

                                <section class="panel-body">

                                    <section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">

                                        <?php $tasks = Project::has_tasks($project_id);
                                        if(count($tasks) > 0){ ?>
                                            <div class="task-content small">
                                                <ul id="sortable" class="task-list ui-sortable">


                                                    <?php foreach ($tasks as $key => $t) { ?>

                                                        <?php $color = 'danger'; ?>
                                                        <?php if($t->task_progress >= '50') $color = 'warning'; ?>
                                                        <?php if($t->task_progress == '100') $color = 'primary'; ?>

                                                        <li class="list-<?php echo $color; ?> <?php if($t->task_progress >= 100 ) { echo 'task-done'; } ?>">
                                                            <i class=" fa fa-ellipsis-v"></i>
                            <?php if(!User::is_client()) {
                            if(Project::is_task_team($t->t_id) || $t->assigned_to == NULL || User::is_admin()) { ?>
                                <div class="task-checkbox">
                                    <span class="task_complete">
                                        <input type="checkbox" class="list-child" value="" data-id="<?=$t->t_id?>"
                                            <?php if($t->task_progress == '100') { echo 'checked="checked"'; } ?>
                                            <?php if($t->timer_status == 'On') { echo 'disabled="disabled"'; } ?>>
                                    </span>
                                </div>
                            <?php } ?>
                            <?php } ?>
                                                            <div class="task-title">
                                                                <span class="task-title-sp" data-toggle="tooltip" data-original-title="<?=$t->task_progress?>% <?=lang('done')?>" data-placement="right" ><?=$t->task_name?></span>
                                                                <div class="pull-right hidden-phone">
                                                                    <a class="btn btn-<?=config_item('theme_color')?> btn-xs fa fa-info" href="<?=base_url()?>projects/view/<?=$t->project?>?group=tasks&view=task&id=<?=$t->t_id?>"></a>
                                                                </div>
                                                            </div>
                                                        </li>

                                                    <?php } ?>

                                                </ul>
                                            </div>

                                        <?php } else{ ?>
                                            <div class="small text-muted" style="margin-left:5px; padding:5px; margin-top:12px; border-left: 2px solid #16a085; "><?=lang('no_task_in_project')?></div>
                                        <?php } ?>



                                    </section>

                                </section>

                            </section>
                        </div>
                    <?php } ?>

                    <!-- End Recent Task -->


                    <!-- Start Project Checklist -->

                    <div class="col-lg-6">
                        <section class="panel panel-default b-top tasks-widget">
                            <header class="panel-heading"><?=lang('todo_list')?>
                                <span class="pull-right"><a href="<?=base_url()?>projects/todo/add/<?=$project_id?>" data-toggle="ajaxModal" class="btn btn-success btn-xs"><?=lang('create_list')?></a></span>
                            </header>
                            <section class="panel-body">
                                <section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">




                                    <div class="task-content small">
                                        <ul id="sortable" class="task-list ui-sortable">

                                            <?php $todo = $this->db->where(array('project' => $project_id))->get('todo')->result(); ?>
                                            <?php foreach ($todo as $key => &$list) {
                                                if($list->saved_by == User::get_id() || $list->visible == 'Yes'){ unset($todo[$key]); ?>
                                                    <li class="list-<?=($list->status == 'done') ? 'primary task-done': 'danger'; ?>">
                                                        <i class=" fa fa-ellipsis-v"></i>
                                                        <div class="task-checkbox">
                  <span class="todo_complete">
                      <input type="checkbox" <?=($list->status == 'done') ? 'checked="checked"': ''; ?> class="list-child" data-id="<?=$list->id?>" <?php echo ($list->saved_by != User::get_id()) ? 'disabled="disabled"': '';?>>
                      </span>
                                                        </div>

                                                        <div class="task-title">
                                                            <span class="task-title-sp"><?=$list->list_name?></span>
                                                            <div class="pull-right hidden-phone">
                                                                <?php if($list->saved_by == User::get_id()) { ?>
                                                                    <a href="<?=base_url()?>projects/todo/edit/<?=$list->id?>"  data-toggle="ajaxModal" class="btn btn-primary btn-xs fa fa-pencil"></a>
                                                                    <a href="<?=base_url()?>projects/todo/delete/<?=$list->id?>"  data-toggle="ajaxModal" class="btn btn-danger btn-xs fa fa-trash-o"></a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>

                                        </ul>
                                    </div>

                                </section>

                            </section>
                        </section>
                    </div>

                    <!-- END TODO -->


                </div>



                <!-- END ROW -->



                <div class="row">




                    <!-- start recent files -->

                    <?php if (User::is_admin() || User::is_staff() || Project::setting('show_project_files',$project_id)) { ?>
                        <div class="col-sm-6">
                            <section class="panel panel-default b-top">
                                <header class="panel-heading"><?=lang('recent_files')?></header>

                                <section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">

                                    <table class="table table-striped m-b-none">
                                        <thead>
                                        <tr>
                                            <th><?=lang('file_name')?></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $files = Project::has_files($project_id);
                                        if(count($files) > 0){
                                            foreach ($files as $key => $f) {
                                                $icon = $this->applib->file_icon($f->ext);
                                                $path = $f->path;
                                                $file_path = ($path != NULL)
                                                    ? base_url().'resource/project-files/'.$path.$f->file_name
                                                    : base_url().'resource/project-files/'.$f->file_name;
                                                $real_url = $file_path;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php if ($f->is_image == 1) : ?>
                                                            <?php if ($f->image_width > $f->image_height) {
                                                                $ratio = round(((($f->image_width - $f->image_height) / 2) / $f->image_width) * 100);
                                                                $style = 'height:100%; margin-left: -'.$ratio.'%';
                                                            } else {
                                                                $ratio = round(((($f->image_height - $f->image_width) / 2) / $f->image_height) * 100);
                                                                $style = 'width:100%; margin-top: -'.$ratio.'%';
                                                            }  ?>
                                                            <div class="file-icon icon-small"><a href="<?=base_url()?>projects/files/preview/<?=$f->file_id?>/<?=$project_id?>" data-toggle="ajaxModal"><img style="<?=$style?>" src="<?=$real_url?>" /></a></div>
                                                        <?php else : ?>
                                                            <div class="file-icon icon-small"><i class="fa <?=$icon?> fa-lg"></i></div>
                                                        <?php endif; ?>


                                                        <a href="<?=base_url()?>projects/files/download/<?=$f->file_id?>" data-original-title="<?=$f->description?>" data-toggle="tooltip" data-placement="top" title = "">
                                                            <?php
                                                            if (empty($f->title)) {
                                                                echo $this->applib->short_string($f->file_name, 10, 8, 22);
                                                            } else {
                                                                echo $this->applib->short_string($f->title, 20, 0, 22);
                                                            }

                                                            ?>

                                                        </a></td>


                                                    <td class="small">
                                                        <?php echo User::displayName($f->uploaded_by); ?>
                                                    </td>
                                                </tr>
                                            <?php } } else{ ?>
                                            <div class="small text-muted" style="margin-left:5px; padding:5px; margin-top:12px; border-left: 2px solid #16a085; "><?=lang('no_file_in_project')?></div>
                                        <?php } ?>
                                        </tbody>
                                    </table>

                                </section>


                            </section>
                        </div>
                    <?php } ?>

                    <!-- END FILES -->



                    <?php if (User::is_admin() || User::is_staff() || Project::setting('show_project_bugs',$project_id)) { ?>
                        <div class="col-sm-6">
                            <section class="panel panel-default b-top">
                                <header class="panel-heading"><?=lang('recent_bugs')?></header>
                                <section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                                    <table class="table table-striped m-b-none">
                                        <thead>
                                        <tr>
                                            <th><?=lang('action')?></th>
                                            <th><?=lang('reporter')?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $bugs = Project::has_bugs($project_id);
                                        if(count($bugs) > 0){
                                            foreach ($bugs as $key => $b) { ?>
                                                <tr>
                                                    <td>
                                                        <a class="btn btn-xs btn-<?=config_item('theme_color')?>" href="<?=base_url()?>projects/view/<?=$project_id?>/?group=bugs&view=bug&id=<?=$b->bug_id?>"><?=lang('preview')?></a>
                                                    </td>
                                                    <td class="small"><?php echo User::displayName($b->reporter); ?></td>
                                                </tr>

                                            <?php } }else{ ?>
                                            <div class="small text-muted" style="margin-left:5px; padding:5px; margin-top:12px; border-left: 2px solid #16a085; "><?=lang('no_bug_in_project')?></div>
                                        <?php } ?>
                                        </tbody>
                                    </table>

                                </section>

                            </section>
                        </div>
                    <?php } ?>
                    <!-- END FILES -->
                </div>





                <!-- end dashboard tab-->
            </div>

            <!-- start activities tab -->
            <div class="tab-pane fade in" id="tab-activities">



                <div  id="activity">
                    <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
                        <?php if (!User::is_client() || Project::setting('show_project_history',$project_id)) {
                            $activities = Project::activity($project_id);
                            foreach ($activities as $key => $a) { ?>
                                <li class="list-group-item">
                                    <a class="thumb-sm pull-left m-r-sm">

                                        <img src="<?php echo User::avatar_url($a->user); ?>" class="img-rounded" style="border-radius: 6px;">

                                    </a>


                                    <a  class="clear">
                                        <small class="pull-right"><?=strftime(config_item('date_format')." %H:%M:%S", strtotime($a->activity_date)) ?></small>
                                        <strong class="block"><?php echo User::displayName($a->user); ?></strong>
                                        <small>
                                            <?php
                                            if (lang($a->activity) != '') {
                                                if (!empty($a->value1)) {
                                                    if (!empty($a->value2)){
                                                        echo sprintf(lang($a->activity), '<em>'.$a->value1.'</em>', '<em>'.$a->value2.'</em>');
                                                    } else {
                                                        echo sprintf(lang($a->activity), '<em>'.$a->value1.'</em>');
                                                    }
                                                } else { echo lang($a->activity); }
                                            } else { echo $a->activity; }
                                            ?>
                                        </small>
                                    </a>
                                </li>
                            <?php } }?>
                    </ul>
                </div>



            </div>
            <!-- end activities tab -->

        </div>

    </div>
    <!-- End ROW 1 -->