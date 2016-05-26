<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
			<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
				<li>
					<small><?= lang('welcome_back') ?> , <?php echo User::displayName(User::get_id()); ?> </small>
				</li>
			</ul>

			<?php if ((config_item('valid_license') != 'TRUE' && User::is_admin()) && config_item('demo_mode') != 'TRUE') {
			?>
			<div class="alert alert-danger" role="alert">
				<strong><?= lang('fo_not_validated'); ?></strong><br/>
				<?php
				$link = '<a href="' . base_url() . 'settings/?settings=system">' . lang('system_settings') . '</a>';
				echo sprintf(lang('not_licenced_message'), $link);
				echo ' <a href="http://codecanyon.net/item/freelancer-office/8870728">Envato Market</a>';
				?>
			</div>
			<?php } ?>

			<div class="panel panel-default">
				<div class="row m-l-none m-r-none bg-dark lter">
					<div class="col-sm-6 col-md-3 padder-v b-r b-light">
						<a class="clear" href="<?= base_url() ?>projects">
							<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-warning"></i> <i class="fa fa-coffee fa-stack-1x text-white"></i>
							</span>
							<span class="h3 block m-t-xs"><strong>
								<?php echo App::counter('projects',array('archived'=>0));?> </strong>

							</span> <small class="text-muted text-uc"><?= lang('projects') ?> </small> 
							</a>
						</div>
						<div class="col-sm-6 col-md-3 padder-v b-r b-light">
							<a class="clear" href="<?= base_url() ?>messages">
								<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-info"></i> <i class="fa fa-envelope fa-stack-1x text-white"></i>
								</span>
								<span class="h3 block m-t-xs">
								<strong>
									<?php echo App::counter('messages',
										array('user_to' => User::get_id(),'deleted' => 'No')); 
									?>

								</strong>
								</span> <small class="text-muted text-uc"><?= lang('messages') ?>  </small> </a>
							</div>
							<div class="col-sm-6 col-md-3 padder-v b-r b-light">
								<a class="clear" href="<?= base_url() ?>invoices">
									<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-danger"></i> <i class="fa fa-suitcase fa-stack-1x text-white"></i>
									</span>
									<span class="h3 block m-t-xs">
									<strong>
									<?php echo App::counter('invoices', array('status'=>'Unpaid')) ?> 
									</strong>
									</span>
								<small class="text-muted text-uc"><?= lang('invoices') ?>  </small> </a>
							</div>
							<div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
								<a class="clear" href="<?= base_url() ?>tickets">
									<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-success"></i> <i class="fa fa-ticket fa-stack-1x text-white"></i>
									</span>
									<span class="h3 block m-t-xs">
									<strong>
										<?php echo App::counter('tickets',
												array('archived_t'=>'0','status !='=>'closed'));
										?>
									</strong>
									</span> <small class="text-muted text-uc"><?= lang('tickets') ?>  </small> </a>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								

								<!-- TABS -->

									<?=$this->load->view('tabs');?>

								<!-- END TABS -->

								
									<section class="panel panel-default">

									<footer class="panel-footer bg-white no-padder">
										<div class="row text-center no-gutter">
											<div class="col-xs-3 b-r b-light">
												<span class="h4 font-bold m-t block">
										<?php echo App::counter('bugs',array())?>
												</span> 
												<small class="text-muted m-b block">
												<?=lang('bugs');?>
												</small>
											</div>
											<div class="col-xs-3 b-r b-light">
												<span class="h4 font-bold m-t block">
										<?php echo App::counter('projects',array('progress >=' => '100'));?>
												</span> 
												<small class="text-muted m-b block">
												<?=lang('complete_projects');?></small>
											</div>
											<div class="col-xs-3 b-r b-light">
												<span class="h4 font-bold m-t block">
										<?php echo App::counter('tasks',array());?>
												</span> 
												<small class="text-muted m-b block">
												<?=lang('tasks');?>  
												</small>
											</div>
											<div class="col-xs-3">
												<span class="h4 font-bold m-t block">
										<?php echo App::counter('comments',array('posted_by' => User::get_id()));?>
												</span> <small class="text-muted m-b block">
												<?=lang('project_comments');?></small>
											</div>
										</div>
									</footer>
								</section>
							</div>
							<div class="col-lg-4">
								<section class="panel panel-default b-top">
								<header class="panel-heading"><?= lang('recently_paid_invoices') ?></header>
								<div class="panel-body">
									<div class="list-group bg-white small" style="height:200px">
										<?php foreach (Payment::recent_paid() as $key => $i) {
												$currency = Invoice::view_by_id($i->invoice)->currency;
												$badge = 'dark';
												if($i->payment_method == '1') $badge = 'success';
												elseif($i->payment_method == '2') $badge = 'danger';

												$converted = "";
												if ($currency != config_item('default_currency')) {
													$converted = " (".Applib::format_currency(config_item('default_currency'),Applib::convert_currency($currency, $i->amount)).")";
												}
										?>
										<a href="<?=base_url()?>invoices/view/<?php echo $i->invoice; ?>" class="list-group-item" style="border-left: 2px solid #16a085">
											<?php echo Invoice::view_by_id($i->invoice)->reference_no;?> 
												- <small class="text-muted">
												<?php echo Applib::format_currency($currency, $i->amount)?> <?=$converted?>
											<span class="badge bg-<?php echo $badge; ?> pull-right">
											<?php echo Payment::method_name_by_id($i->payment_method); ?></span></small>
										</a>
										<?php } ?>
									</div>
								</div>
								<div class="panel-footer">
									<small><?= lang('total_receipts') ?>: <strong>
									<?php if (!isset($no_invoices)) {
										echo Applib::format_currency(config_item('default_currency'), $sums['paid']);
									} else {
										echo Applib::format_currency(config_item('default_currency'), 0);
									} ?>
									</strong></small>
								</div>
							</section>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8 ">
							<section class="panel panel-default b-top">
							<header class="panel-heading font-bold"><?= lang('yearly_overview') ?></header>
							<div class="panel-body">
								<div id="line-chart"></div>
							</div>
						</section>
					</div>
					<!-- Revenue Collection -->
					<?php
					$total_receipts = $sums['paid'];
					$invoices_cost = Invoice::all_invoice_amount();
					$outstanding = $sums['due'];
					if ($outstanding < 0) $outstanding = 0;
					$perc_paid = $perc_outstanding = 0;

					if ($invoices_cost > 0) {
						$perc_paid = ($total_receipts / $invoices_cost) * 100;
						$perc_paid = ($perc_paid > 100) ? '100': round($perc_paid, 1);
						$perc_outstanding = round(100 - $perc_paid, 1);
					}
					?>
					<div class="col-md-4">
						<section class="panel panel-default revenue b-top">

						<header class="panel-heading"><?=lang('revenue_collection') ?></header>

						<div class="panel-body text-center">
							<h4><?= lang('received_amount') ?></h4>
							<small class="text-muted block"><?=lang('percentage_collection') ?></small>

							<div class="sparkline inline" data-type="pie" data-height="150" data-slice-colors="['#65BD77','#FFC333']">
							<?= $perc_paid ?>,<?= $perc_outstanding ?></div>
							<div class="line pull-in"></div>
							<div>
								<i class="fa fa-circle text-warning"></i>
								<?=lang('outstanding') ?> - <?= $perc_outstanding?>%
								<i class="fa fa-circle text-success"></i> 
								<?= lang('paid') ?> - <?= $perc_paid ?>%
							</div>
						</div>
						<div class="panel-footer"><small><?= lang('total_outstanding') ?> : <strong>
							<?php echo (!isset($no_invoices)) 
							? Applib::format_currency(config_item('default_currency'), $sums['due']) 
							: Applib::format_currency(config_item('default_currency'), 0);
							?>
							</strong></small>
						</div>
					</section>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4" style="border-radius:2px;">
					<div class="row">
						<!-- Percentage Received -->
						<div class="col-lg-12">
							<section class="panel panel-default b-top">
							<header class="panel-heading"><?= lang('recent_tickets') ?></header>
							<div class="panel-body">
								<section class="comment-list block">
									<section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
										<?php
										foreach (Ticket::get_tickets() as $key => $ticket) {
											$badge = 'dark';
											if($ticket->status == 'open') $badge = 'danger';
											elseif($ticket->status == 'closed') $badge = 'success';
										?>
										<article id="comment-id-1" class="comment-item small">
											<?php if($ticket->reporter != NULL){ ?>
											<div class="pull-left thumb-sm avatar">
								<img src="<?php echo User::avatar_url($ticket->reporter);?>" class="img-circle">
											</div>
											<?php }else{ echo "NULL"; } ?>
											<section class="comment-body m-b-lg">
												<header class="b-b">
													<strong>
													<?php 
													echo ($ticket->reporter != NULL) 
														? User::displayName($ticket->reporter)
														: 'NULL'; 
													?>
													</strong>
													<span class="text-muted text-xs"> 
										<?php echo Applib::time_elapsed_string(strtotime($ticket->created));?>
													</span>
												</header>
												<div>
													<a href="<?= base_url() ?>tickets/view/<?=$ticket->id;?>">
														<?=$ticket->subject;?>
														<small class="text-muted">
														<?= lang('priority') ?>: <?=$ticket->priority;?>
														<span class="badge bg-<?=$badge?>"><?=$ticket->status;?>
														</span>
														</small>
													</a>
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
			</div>
			<div class="col-md-4">
				<div class="row">
					<!-- Percentage Received -->
					<div class="col-lg-12">
						<section class="panel panel-default b-top" >
						<header class="panel-heading"><?= lang('recent_tasks') ?></header>
						<div class="panel-body">
							<section class="comment-list block">
								<section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
									<?php
									// $tasks = array_reverse($tasks = );
										foreach (Project::get_tasks() as $key => $task) {
											$badge = 'danger';
											if($task->task_progress == '100') $badge = 'success';
											elseif($task->task_progress >= '50') $badge = 'warning';
											$user = $task->added_by;
									?>
									<article class="comment-item small">
										<div class="pull-left thumb-sm avatar">
											<img src="<?php echo User::avatar_url($user);?>" class="img-circle">
										</div>
										<section class="comment-body m-b-lg">
											<header class="b-b">
												<strong>
												<?php echo User::displayName($user);?></strong>
												<span class="text-muted text-xs"> 
										<?php echo Applib::time_elapsed_string(strtotime($task->date_added));?>
												</span>
											</header>
											<div>
												<a href="<?= base_url() ?>projects/view/<?=$task->project;?>?group=tasks&view=task&id=<?=$task->t_id?>">
													<?=$task->task_name;?> <span class="badge bg-<?=$badge?>">
													<?=$task->task_progress;?>%</span>
												</a>
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
		</div>
		<div class="col-md-4">
			<section class="panel panel-default b-light b-top">
			<header class="panel-heading"><?= lang('recent_activities') ?></header>
			<div class="panel-body">
				<section class="comment-list block">
					<section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
						<?php foreach ($activities as $key => $activity) { ?>
						<article id="comment-id-1" class="comment-item small">
							<div class="pull-left thumb-sm">
							<img src="<?php echo User::avatar_url($activity->user);?>" class="img-circle">
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
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<?php 
$year = date('Y'); 
$this->lang->load('calendar',config_item('language')); 
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script type="text/javascript">
	Morris.Line({
		element: 'line-chart',
		data: [
<?php

for ($i = 1; $i <= 12; $i++) {
	print_r('{
		"Received Amount": ' . Applib::cal_amount('received', $year, sprintf('%02d', $i)) . ',
		"period": "' . $year . '-' . sprintf('%02d', $i) . '"
	},');
};
?>
<?php
$cur = App::currencies(config_item('default_currency'));
?>
],
xkey: 'period',
ykeys: ['Received Amount'],
labels: ['Paid Amount'],
hoverCallback: function (index, options, content) {
return(content);
},
hideHover: 'auto',
behaveLikeLine: true,
pointFillColors: ['#fff'],
pointStrokeColors: ['black'],
xLabelMargin: 10,
xLabelAngle: 70,
preUnits: ['<?=$cur->symbol?>'],
lineColors: ['#18a689'],
xLabelFormat: function (x) {
var IndexToMonth = ["<?=lang('cal_jan')?>", "<?=lang('cal_feb')?>", "<?=lang('cal_mar')?>", "<?=lang('cal_apr')?>", "<?=lang('cal_may')?>", "<?=lang('cal_jun')?>", "<?=lang('cal_jul')?>", "<?=lang('cal_aug')?>", "<?=lang('cal_sep')?>", "<?=lang('cal_oct')?>", "<?=lang('cal_nov')?>", "<?=lang('cal_dec')?>"];
var month = IndexToMonth[ x.getMonth() ];
var year = x.getFullYear();
return year + ' ' + month;
},
dateFormat: function (x) {
var IndexToMonth = ["<?=lang('cal_jan')?>", "<?=lang('cal_feb')?>", "<?=lang('cal_mar')?>", "<?=lang('cal_apr')?>", "<?=lang('cal_may')?>", "<?=lang('cal_jun')?>", "<?=lang('cal_jul')?>", "<?=lang('cal_aug')?>", "<?=lang('cal_sep')?>", "<?=lang('cal_oct')?>", "<?=lang('cal_nov')?>", "<?=lang('cal_dec')?>"];
var month = IndexToMonth[ new Date(x).getMonth() ];
var year = new Date(x).getFullYear();
return year + ' ' + month;
},
resize: true
});
</script>