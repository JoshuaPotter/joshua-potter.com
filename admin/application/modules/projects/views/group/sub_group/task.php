<section class="panel panel-default">
    <?php
    $task = isset($_GET['id']) ? $_GET['id'] : 0;
    $t = (!User::is_client()) ? Project::view_task($task) : Project::view_task($task,'Yes');
    if($t->project == $project_id){ ?>
    <header class="header bg-white b-b clearfix">
        <div class="row m-t-sm">
            <div class="col-sm-12 m-b-xs">

                <?php if($t->task_progress < 100) {
                    if(!User::is_client()){
                        if ($t->timer_status == 'On') { ?>
                            <a class="btn btn-sm btn-danger" href="<?=base_url()?>projects/tasks/tracking/off/<?=$t->project?>/<?=$t->t_id?>"><?=lang('stop_timer')?>
                            </a>

                        <?php }else{ ?>
                            <a class="btn btn-sm btn-success" href="<?=base_url()?>projects/tasks/tracking/on/<?=$t->project?>/<?=$t->t_id?>"><?=lang('start_timer')?>
                            </a>
                        <?php }  }
                }
                ?>

                <a href="<?=base_url()?>projects/tasks/file/<?=$t->project?>/<?=$t->t_id?>" data-toggle="ajaxModal" class="btn btn-sm btn-<?=config_item('theme_color')?>"><?=lang('attach_file')?>
                </a>

                <?php if(!User::is_client() || $t->added_by == User::get_id()){ ?>
                    <a href="<?=base_url()?>projects/tasks/edit/<?=$t->t_id?>" data-toggle="ajaxModal" class="btn btn-sm btn-<?=config_item('theme_color')?>"><?=lang('edit_task')?>
                    </a>
                <?php } if(User::is_admin()){ ?>
                    <a href="<?=base_url()?>projects/tasks/delete/<?=$t->project?>/<?=$t->t_id?>" data-toggle="ajaxModal" title="<?=lang('delete_task')?>" class="btn btn-sm btn-danger"><i class="fa fa-trash-o text-white"></i> <?=lang('delete_task')?>
                    </a>
                <?php } ?>
            </div>
        </div>
    </header>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-2"><?=lang('progress')?></div>
                        <div class="col-lg-10">
                            <div class="progress progress-xs <?=($t->task_progress != '100') ? 'progress-striped active' : ''; ?> m-t-sm">
                                <div class="progress-bar progress-bar-<?=config_item('theme_color')?>" data-toggle="tooltip" data-original-title="<?=$t->task_progress?>%" style="width: <?=$t->task_progress?>%">
                                </div>
                            </div>
                        </div>
                        <?=$this->session->flashdata('form_error')?>
                        <div class="col-lg-6">
                            <ul class="list-group no-radius">
                                <li class="list-group-item">
                                    <span class="pull-right"><strong><?=$t->task_name?></strong> </span><?=lang('task_name')?></li>
                                <li class="list-group-item">
										<span class="pull-right">
											<strong>
                                                <?=Project::by_id($project)->project_title;?>
                                            </strong>
										</span>
                                    <?=lang('project')?>
                                </li>
                                <?php if(!User::is_client()){ ?>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?=$t->visible?></span><?=lang('visible_to_client')?></li>
                                <?php } ?>

                                <li class="list-group-item">
											<span class="pull-right">
												<strong>
                            <?php $start_date = ($t->start_date == NULL) ? $t->date_added : $t->start_date; ?>
                            <?=strftime(config_item('date_format'), strtotime($start_date))?>
                                                </strong>
											</span>
                                    <?=lang('start_date')?>
                                </li>

                                <li class="list-group-item">
											<span class="pull-right">
												<strong>
                                                    <?=strftime(config_item('date_format'), strtotime($t->due_date))?>
                                                </strong>
											</span>
                                    <?=lang('due_date')?>
                                </li>
                            </ul>
                        </div>
                        <!-- End details C1-->
                        <div class="col-lg-6">
                            <ul class="list-group no-radius">
                                <li class="list-group-item">
											<span class="pull-right">

                         <strong><?=$this->applib->get_time_spent(Project::task_timer($t->t_id))?></strong>
											</span><?=lang('logged_hours')?>
                                </li>
                                <li class="list-group-item">
											<span class="pull-right">
												<strong><?=$t->estimated_hours?> <?=lang('hours')?></strong>
											</span><?=lang('estimated_hours')?>
                                </li>
                                <?php if(!User::is_client()){ ?>
                                    <li class="list-group-item">
											
											<span class="pull-right small">
                                        <?php foreach (Project::task_team($t->t_id) as $u) { ?>
                                        <span class="label label-default"><?=User::displayName($u->assigned_user)?></span>
                                        <?php } ?>
											</span><?=lang('assigned_to')?>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item">
											<span class="pull-right">
											<span class="label label-success"> <?=$t->timer_status?></span>
											</span><?=lang('timer_status')?>
                                </li>

                                <li class="list-group-item">
									<span class="pull-right">
									<span class="label label-danger"> <?=User::displayName($t->added_by)?></span>
									</span><?=lang('added_by')?>
                                </li>

                            </ul>
                        </div>

                        <div class="line line-dashed line-lg pull-in"></div>
                        <div class="col-lg-12">

                            <blockquote>
                                <?=lang('milestone')?>:
                                <a href="<?=base_url()?>projects/view/<?=$t->project?>/?group=milestones&view=milestone&id=<?=$t->milestone?>" class="text-primary">
                                    <?php echo ($t->milestone) ? Project::view_milestone($t->milestone)->milestone_name : '';
                                    ?>
                                </a>
                            </blockquote>
                            <p>
                            <blockquote class="activate_links"><?=nl2br_except_pre($t->description)?></blockquote>
                            </p>
                            <!-- End details -->
                            <?php
                            $this->load->helper('file');
                            foreach (Project::task_has_files($task) as $key => $f) {
                                $icon = $this->applib->file_icon($f->file_ext);
                                $real_url = ($f->path != NULL)
                                    ? base_url().'resource/project-files/'.$f->path.$f->file_name
                                    : base_url().'resource/project-files/'.$f->file_name;
                                ?>
                                <div class="file-small">
                                    <?php if ($f->is_image == 1) : ?>
                                        <?php if ($f->image_width > $f->image_height) {
                                            $ratio = round(((($f->image_width - $f->image_height) / 2) / $f->image_width) * 100);
                                            $style = 'height:100%; margin-left: -'.$ratio.'%';
                                        } else {
                                            $ratio = round(((($f->image_height - $f->image_width) / 2) / $f->image_height) * 100);
                                            $style = 'width:100%; margin-top: -'.$ratio.'%';
                                        }  ?>
                                        <div class="file-icon icon-small"><a href="<?=base_url()?>projects/tasks/preview/<?=$f->file_id?>/<?=$project_id?>" data-toggle="ajaxModal"><img style="<?=$style?>" src="<?=$real_url?>" /></a></div>
                                    <?php else : ?>
                                        <div class="file-icon icon-small"><i class="fa <?=$icon?> fa-lg"></i></div>
                                    <?php endif; ?>
                                    <a data-toggle="tooltip" data-placement="top" data-original-title="<?=$f->description?>" class="text-info" href="<?=base_url()?>projects/tasks/download/<?=$f->file_id?>">
                                        <?=(empty($f->title) ? $f->file_name : $f->title)?>
                                    </a>
                                    <?php  if($f->uploaded_by == User::get_id() || User::is_admin()){ ?>
                                        <a class="btn btn-xs btn-default" href="<?=base_url()?>projects/tasks/file/delete/<?=$f->file_id?>/<?=$project_id?>" data-toggle="ajaxModal"><i class="fa fa-trash-o"></i></a>
                                        <a class="btn btn-xs btn-default" href="<?=base_url()?>projects/tasks/file/edit/<?=$f->file_id?>/<?=$project_id?>" data-toggle="ajaxModal"><i class="fa fa-edit"></i></a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- End ROW 1 -->


    <!-- Start Comments -->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel panel-body">
                <section class="comment-list block">
                    <article class="comment-item media" id="comment-form">

                        <a class="pull-left thumb-sm avatar">
                            <img src="<?php echo User::avatar_url(User::get_id()); ?>" class="img-circle">
                        </a>



                        <section class="media-body">
                            <section class="panel panel-default">
                                <?php
                                $attributes = 'class="m-b-none"';
                                echo form_open(base_url().'projects/tasks/comment',$attributes); ?>
                                <input type="hidden" name="task_id" value="<?=$t->t_id?>">
                                <input type="hidden" name="project" value="<?=$t->project?>">
                                <textarea class="form-control foeditor-100" name="message" placeholder="<?=$t->task_name?> <?=lang('comment')?>"></textarea>
                                <footer class="panel-footer bg-light lter">
                                    <button class="btn btn-<?=config_item('theme_color');?> pull-right btn-sm" type="submit"><?=lang('post_comment')?></button>
                                    <ul class="nav nav-pills nav-sm"></ul>
                                </footer>
                                </form>
                            </section>
                        </section>
                    </article>
                    <?php foreach (Project::task_has_comments($t->t_id) as $key => $c) {
                        $role_label = (User::login_info($c->posted_by)->role_id == '1') ? 'danger' : 'info';
                        ?>
                        <article id="comment-id-1" class="comment-item">
                            <a class="pull-left thumb-sm avatar">
                                <img src="<?php echo User::avatar_url($c->posted_by); ?>" class="img-circle">
                            </a>
                            <span class="arrow left"></span>
                            <section class="comment-body panel panel-default">
                                <header class="panel-heading bg-white">
                                    <a href="#"><?=ucfirst(User::displayName($c->posted_by))?></a>
                                    <label class="label bg-<?=$role_label?> m-l-xs">
                                        <?php echo User::get_role($c->posted_by); ?></label> 
                                <span class="text-muted m-l-sm pull-right">
<?php echo strftime(config_item('date_format')." %H:%M:%S", strtotime($c->date_posted)) ?>
                                    <?php
                                    if(config_item('show_time_ago') == 'TRUE'){
                                        echo ' - '.Applib::time_elapsed_string(strtotime($c->date_posted));
                                    } ?>


                                    <?php if($c->posted_by == User::get_id()){ ?>

                                        <a href="<?=base_url()?>projects/tasks/delete_comment/<?=$c->comment_id?>" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o text-danger"></i>
                                        </a>
                                    <?php } ?>
                                </span>
                                </header>

                                <div class="panel-body">
                                    <div class="text-muted small activate_links"><?=nl2br_except_pre($c->message)?></div>

                                </div>

                            </section>
                        </article>
                    <?php } ?>

                    <?php if(count(Project::task_has_comments($t->t_id)) <= 0) { ?>
                        <article id="comment-id-1" class="comment-item">
                            <section class="comment-body panel panel-default">
                                <div class="panel-body">
                                    <p>No comments found</p>
                                </div>
                            </section>
                        </article>
                    <?php } ?>

                </section>
            </section>
        </div>
    </div>
    <!-- END COMMENTS -->


</section>