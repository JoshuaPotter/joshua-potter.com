<section class="panel panel-default">
    <header class="header bg-white b-b clearfix">
        <div class="row m-t-sm">
            <div class="col-sm-12 m-b-xs">
                <?php if(User::is_admin()){ ?>
                    <a href="<?=base_url()?>projects/team/<?=$project_id?>" data-toggle="ajaxModal" class="btn btn-sm btn-<?=config_item('theme_color')?>"><?=lang('update_team')?></a>
                <?php } ?>
            </div>
        </div>
    </header>
    <div class="table-responsive">
        <?php if (!User::is_client() || Project::setting('show_team_members',$project_id)) { ?>
            <table id="table-teams" class="table table-striped b-t b-light AppendDataTables">
                <thead>
                <tr>
                    <th style="width:5px; display:none;"></th>
                    <th class="col-sm-1"><?=lang('user')?></th>
                    <th class="col-sm-2"><?=lang('last_login')?></th>
                    <?php if(!User::is_client()){ ?>
                    <th class="col-sm-2"><?=lang('email')?></th>
                    <?php } ?>
                    <?php if(User::is_admin()){ ?>
                        <th class="col-sm-2"><?=lang('hours')?></th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach(Project::project_team($project_id) as $key => $u) { ?>
                    <tr>
                        <td style="display:none;"><?=$u->assigned_user?></td>

                        <td style="border-left: 2px solid #16a085;">
                            <a class="pull-left thumb-sm avatar" data-toggle="tooltip" title="<?php echo User::displayName($u->assigned_user); ?>" data-placement="right">
                                <img src="<?php echo User::avatar_url($u->assigned_user); ?>" class="img-rounded" style="border-radius: 6px;">

                            </a>
                        </td>
                        <td class="">
        <span class="label label-default">
        <?php if(User::login_info($u->assigned_user)->last_login != '0000-00-00 00:00:00'){
            echo Applib::time_elapsed_string(strtotime(User::login_info($u->assigned_user)->last_login));
        }else{ echo User::login_info($u->assigned_user)->last_login; } ?>
        </span>
        <?php if(User::is_admin()){ ?>
            <br>
                            IP &raquo; <?=User::login_info($u->assigned_user)->last_ip;?>
        <?php } ?>
                        </td>
                        <?php if(!User::is_client()){ ?>
                        <?php $email = User::login_info($u->assigned_user)->email?>
                        <td class="small"><a href="mailto:<?=$email?>"><?=$email?></a></td>
                        <?php } ?>

                        <?php if(User::is_admin()){
                            $p_hours = Project::time_by_user($u->assigned_user,'1',$project_id)->projects_time;
                            $t_hours = Project::time_by_user($u->assigned_user,'1',$project_id)->tasks_time;
                            $total_hours = $p_hours + $t_hours;
                            $format = sprintf('%02d:%02d:%02d', ($total_hours / 3600), ($total_hours / 60 % 60), $total_hours % 60);
                            ?>
                            <td class="">
                                <span class="small"><?=lang('time_spent')?></span> &raquo; <span class="label label-success"><?=$format?></span><br>
                                <span class="small"><?=lang('hourly_rate')?></span> &raquo; <span class="label label-default">
       <?=User::profile_info($u->assigned_user)->hourly_rate?>/<?=lang('hour')?></span>
                            </td>

                        <?php } ?>

                    </tr>
                <?php }  ?>


                </tbody>
            </table>
        <?php } ?>
        <!-- End view team members -->
    </div>
    <!-- End details -->
</section>