<?php $action = (isset($action)) ? $action : ''; ?>



<?php if($action == 'add_time') { ?>




<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title"><?=lang('time_entry')?></h4>
		</div>
		
		<?php
		$attributes = array('class' => 'bs-example form-horizontal');
		echo form_open(base_url().'projects/timesheet/add_time',$attributes); ?>
		<input type="hidden" name="project" value="<?=$project?>">
		<input type="hidden" name="cat" value="<?=$cat?>">
		<div class="modal-body">
			<?php
			if ($cat == 'tasks') { ?>
			<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('task_name')?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<select name="task" class="form-control">
						<?php foreach (Project::has_tasks($project) as $key => $t) {  ?>
						<option value="<?=$t->t_id?>"><?=$t->task_name?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<?php } ?>
			<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('start_time')?></label>
				<div class="col-sm-8">
					<input type="text" class="combodate form-control" data-format="DD-MM-YYYY HH:mm" data-template="D  MMM  YYYY  -  HH : mm" name="start_time" value="<?=date('d-m-Y H:i')?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('stop_time')?></label>
				<div class="col-sm-8">
					<input type="text" class="combodate form-control" data-format="DD-MM-YYYY HH:mm" data-template="D  MMM  YYYY  -  HH : mm" name="end_time" value="<?=date('d-m-Y H:i')?>" required>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('description')?></label>
				<div class="col-lg-8">
				<textarea id="auto-description" name="description" class="form-control" placeholder="<?=lang('description')?>"></textarea>
				</div>
				</div>
			
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
		<button type="submit" class="btn btn-<?=config_item('theme_color');?>"><?=lang('time_entry')?></button>
	</form>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script src="<?=base_url()?>resource/js/libs/moment.min.js"></script>
<script src="<?=base_url()?>resource/js/combodate/combodate.js"></script>
<script type="text/javascript">
	$(function(){
		$('.combodate').combodate();
	});
</script>




<?php } ?>


<?php if($action == 'edit_time') { ?>


<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title"><?=lang('time_entry')?></h4>
		</div>
		
					<?php
			 $attributes = array('class' => 'bs-example form-horizontal');
          echo form_open(base_url().'projects/timesheet/edit',$attributes); ?>
          <input type="hidden" name="project" value="<?=$project?>">
          <input type="hidden" name="cat" value="<?=$cat?>">
          <input type="hidden" name="timer_id" value="<?=$timer_id?>">
		<div class="modal-body">
		<?php
		if ($cat == 'tasks') { ?>
			<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('task_name')?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
				<select name="task" class="form-control">
				<option value="<?=$i->task?>"><?=Project::view_task($i->task)->task_name; ?></option>
				<?php foreach (Project::has_tasks($project) as $key => $t) {  ?>
					<option value="<?=$t->t_id?>"><?=$t->task_name?></option>
				<?php } ?>
				</select>
				</div>
				</div>
		<?php } ?>

		<?php
		$start_time = date('d-m-Y H:i',$i->start_time);
		$end_time = date('d-m-Y H:i',$i->end_time);
		?>
				<div class="form-group">
                      <label class="col-lg-4 control-label"><?=lang('start_time')?></label>
                      <div class="col-sm-8">
                        <input type="text" class="combodate form-control" data-format="DD-MM-YYYY HH:mm" data-template="D  MMM  YYYY  -  HH : mm" name="start_time" value="<?=$start_time?>">
                      </div>

                    </div>


          		<div class="form-group">
                      <label class="col-lg-4 control-label"><?=lang('stop_time')?></label>
                      <div class="col-sm-8">
                        <input type="text" class="combodate form-control" data-format="DD-MM-YYYY HH:mm" data-template="D  MMM  YYYY  -  HH : mm" name="end_time" value="<?=$end_time?>">
                      </div>

                    </div>


                    <div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('description')?></label>
				<div class="col-lg-8">
				<textarea id="auto-description" name="description" class="form-control"><?=$i->description?></textarea>
				</div>
				</div>
			
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a> 
		<button type="submit" class="btn btn-<?=config_item('theme_color');?>"><?=lang('time_entry')?></button>
	
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

<!-- /.modal-dialog -->
<script src="<?=base_url()?>resource/js/libs/moment.min.js"></script>
<script src="<?=base_url()?>resource/js/combodate/combodate.js"></script>
<script type="text/javascript">
	$(function(){
		$('.combodate').combodate({
    minYear: 2000,
    maxYear: <?=date('Y')?>
	});
	});
</script>




<?php } ?>



<?php if($action == 'timer_description') { ?>


<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header "> 
		<button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('description')?></h4>
		</div>
		<div class="modal-body">
		<?php if($description == ''){ ?>
			<p><?=lang('nothing_to_display')?></p>
		<?php }else{ ?>
			<p><?=nl2br_except_pre($description)?></p>
		<?php } ?>
			

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->


<?php } ?>


<?php if($action == 'delete_time') { ?>


<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-danger"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('delete_time')?></h4>
		</div><?php
			echo form_open(base_url().'projects/timesheet/delete'); ?>
		<div class="modal-body">
			<p><?=lang('delete_time_warning')?></p>
			
			<input type="hidden" name="project" value="<?=$project?>">
			<input type="hidden" name="timer_id" value="<?=$timer_id?>">
			<input type="hidden" name="cat" value="<?=$cat?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-danger"><?=lang('delete_button')?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->


<?php } ?>