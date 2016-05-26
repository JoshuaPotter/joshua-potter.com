<header class="bg-<?=config_item('top_bar_color')?> header navbar navbar-fixed-top-xs">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav">
				<i class="fa fa-bars"></i>
			</a>
			<a href="<?=base_url()?>" class="navbar-brand">
				<?php $display = config_item('logo_or_icon'); ?>

				<?php if ($display == 'logo' || $display == 'logo_title') { ?>
					<img src="<?=base_url()?>resource/images/<?=config_item('company_logo')?>" class="m-r-sm">
				<?php } elseif ($display == 'icon' || $display == 'icon_title') { ?>
					<i class="fa <?=config_item('site_icon')?>"></i>
				<?php } ?>

				<?php 
				if ($display == 'logo_title' || $display == 'icon_title') {
					if (config_item('website_name') == '') { echo config_item('company_name'); } else { echo config_item('website_name'); }
				} ?>
			</a>
			<a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
				<i class="fa fa-cog"></i>
			</a>
		</div>
		<ul class="nav navbar-nav navbar-right hidden-xs nav-user">
			<?php $role = User::login_role_name(); ?>
			<?php foreach ($timers as $timer) : if ($role == 'admin' || ($role == 'staff' && User::get_id() == $timer['user_id'])) : ?>
				<li class="timer" start="<?php echo $timer['start']; ?>">
					<a title="<?php echo lang($timer['type']).": ".$timer['title']." (".$timer['username'].")"; ?>" data-placement="top" data-toggle="tooltip" class="dker" href="<?php echo site_url('projects/view/'.$timer['id']).($timer['type'] == '' ? '':'?group=tasks');  ?>">

						<?php if(config_item('use_gravatar') == 'TRUE' && $timer['use_gravatar'] == 'Y'){ ?>
						<img src="<?=Applib::get_gravatar($timer['email'])?>" class="img-circle">
						<?php }else{ ?>
						<img src="<?=base_url()?>resource/avatar/<?=$timer['avatar']?>" class="img-circle">
						<?php } ?>
						<span></span>
					</a>
				</li>
			<?php endif; endforeach; ?>
			<?php $up = count($updates); ?>
			<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="<?=($up > 0 && $role == 'admin' ? 'color: #FF4000;':'')?>">
					<span class="thumb-sm avatar pull-left">
						<?php
						$user = User::get_id();
						$user_email = User::login_info($user)->email;
						?>
						<img src="<?php echo User::avatar_url($user);?>" class="img-circle">
					</span>
					<?php echo User::displayName($user);?> <b class="caret"></b>
				</a>
				<ul class="dropdown-menu animated fadeInRight">
					<li class="arrow top"></li>
					<li><a href="<?=base_url()?>profile/settings"><?=lang('settings')?></a></li>
					<li>

                    <a id="user-activities" href="<?=base_url()?>profile/activities">
                    <?php if ($role == 'admin') {
                        $lastseen = config_item('last_seen_activities');
                        $activities = $this->db->where('activity_date >',date("Y-m-d H:i:s",$lastseen))->get('activities')->result();
                        $act = count($activities);
                        $badge = 'bg-danger';
                        if ($act == 0) $badge = 'bg-success';
                    ?>
                     <span class="badge <?=$badge;?> pull-right"><?=$act;?></span>
                    <?php } ?><?=lang('activities')?>
                    </a>

					</li>
					<?php if ($role == 'admin') { ?>
                        <li>
                            <a id="user-updates" href="<?=base_url()?>updates">
                                <?php if ($up > 0) : ?>
                                    <span class="badge bg-warning pull-right"><?=$up?></span>
                                <?php endif; ?>
                                <?=lang('updates')?>
                            </a>
                        </li>
                                                
                    <?php
                        $menus = $this->db->where('access',1)->where('visible',1)->where('hook','user_menu_admin')->order_by('order','ASC')->get('hooks')->result();
                        foreach ($menus as $menu) { ?>
                        <li>
                            <a href="<?=base_url()?><?=$menu->route?>"><?=lang($menu->name)?></a>
                        </li>
                    <?php } ?>
                                                
					<?php } ?>
					<li class="divider"></li>
					<li> <a href="<?=base_url()?>logout" ><?=lang('logout')?></a> </li>
				</ul>
			</li>
		</ul>
	</div>
</header>