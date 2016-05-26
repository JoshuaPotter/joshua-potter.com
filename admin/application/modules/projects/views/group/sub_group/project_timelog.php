<div class="table-responsive">
  <table id="table-project-timelog" class="table table-striped b-t b-light AppendDataTables">
    <thead>
      <tr>   

        <th class="no-sort"><?=lang('user')?></th>

        <th><?=lang('start_time')?></th>
        <th><?=lang('stop_time')?></th>

        

        <th class="col-time"><?=lang('time_spent')?></th>
        <?php  if(!User::is_client()){ ?>
        <th class="col-options no-sort"><?=lang('options')?></th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php
      $timesheet = (User::is_staff()) ? Project::timesheet($project_id,'project',User::get_id())
                                        : Project::timesheet($project_id,'project');
      foreach ($timesheet as $key => $t) {
      ?>
      
      <tr>

        <td>

          <a class="pull-left thumb-sm avatar text-info" href="<?=base_url()?>projects/timesheet/description/<?=$t->timer_id?>?cat=projects" data-toggle="ajaxModal">

          <img src="<?php echo User::avatar_url($t->user); ?>" class="img-rounded" style="border-radius: 6px;">
        
             <span class="m-l-xs"><?=ucfirst(User::displayName($t->user))?></span>
          </a>

          </td>


        <td>
        <span class="label label-success"><?=strftime(config_item('date_format').' %H:%M', $t->start_time)?></span>
        </td>

        <td>
        <span class="label label-danger"><?=strftime(config_item('date_format').' %H:%M', $t->end_time)?></span>
        </td>
        
        
        
          <td>
          <small class="small text-muted"><?=$this->applib->get_time_spent($t->end_time - $t->start_time)?>
          </small>
          </td>
          
        <?php  if(!User::is_client()){ ?>
        <td>

         <?php if($t->billable == '1') { ?>

        <a class="btn btn-xs btn-success" href="<?=base_url()?>projects/timesheet/billable/<?=$t->project?>?group=timesheets&cat=projects&id=<?=$t->timer_id?>" title="<?=lang('billable')?>" data-toggle="tooltip" data-placement="left">
        <i class="fa fa-check"></i>
        </a>

        <?php }else{ ?>
        <a class="btn btn-xs btn-danger" href="<?=base_url()?>projects/timesheet/billable/<?=$t->project?>?group=timesheets&cat=projects&id=<?=$t->timer_id?>" title="<?=lang('not_billable')?>" data-toggle="tooltip" data-placement="left"><i class="fa fa-square-o"></i></a>

        <?php } ?>


          

          <a class="btn btn-xs btn-info" href="<?=base_url()?>projects/timesheet/edit/<?=$t->project?>?group=timesheets&cat=projects&id=<?=$t->timer_id?>" data-toggle="ajaxModal"><i class="fa fa-edit"></i></a>
          <a class="btn btn-xs btn-dark" href="<?=base_url()?>projects/timesheet/delete/<?=$t->project?>?group=timesheets&cat=projects&id=<?=$t->timer_id?>" data-toggle="ajaxModal"><i class="fa fa-trash-o"></i></a>
          
        </td>
        <?php } ?>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>