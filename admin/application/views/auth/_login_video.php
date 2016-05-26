 <style type="text/css">
  video#bgvid { 
    position: fixed;
    top: 50%;
    left: 50%;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    -webkit-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
    background: url(polina.jpg) no-repeat;
    background-size: cover; 
}
@media screen and (max-device-width: 800px) {
    html {
         background: url(polina.jpg) #000 no-repeat center center fixed;
    }
    #bgvid {
        display: none;
    }
}

</style>

<?php
$login = array(
	'name'	=> 'login',
	'class'	=> 'form-control input-lg',
	'placeholder' => lang('username'),
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or Username';
} else if ($login_by_username) {
	$login_label = 'Username';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'inputPassword',
	'placeholder' => lang('password'),
	'size'	=> 30,
	'class' => 'form-control input-lg'
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>


<div class="content">

<!-- Replace with your image and video -->
<video autoplay loop poster="polina.jpg" id="bgvid">
   <source src="<?=base_url()?>resource/images/fo.webm" type="video/webm"> 
    <source src="<?=base_url()?>resource/images/fo.mp4" type="video/mp4">
</video>

<section id="content" class="m-t-lg wrapper-md animated fadeInUp">




		<div class="container aside-xxl">


		<a class="navbar-brand block" href="<?=base_url()?>">
                    <?php $display = config_item('logo_or_icon'); ?>
			<?php if ($display == 'logo' || $display == 'logo_title') { ?>
			<img src="<?=base_url()?>resource/images/<?=config_item('company_logo')?>" class="img-responsive <?=($display == 'logo' ? "" : "thumb-sm m-r-sm")?>">
			<?php } elseif ($display == 'icon' || $display == 'icon_title') { ?>
			<i class="fa <?=config_item('site_icon')?>"></i>
			<?php } ?>
			<?php 
                if ($display == 'logo_title' || $display == 'icon_title') {
                    if (config_item('website_name') == '') { 
                    	echo config_item('company_name'); 
                    } else { 
                    	echo config_item('website_name'); }
                        }
            ?>
                </a> 
		 <section class="panel panel-default bg-white m-t-lg">
		<header class="panel-heading text-center"> <strong><?=config_item('login_title')?></strong>
			<?php  echo modules::run('sidebar/flash_msg');?>  
		</header>

		<?php 
		$attributes = array('class' => 'panel-body wrapper-lg');
		echo form_open($this->uri->uri_string(),$attributes); ?>
			<div class="form-group">
				<label class="control-label"><?=lang('email_user')?></label>
				<?php echo form_input($login); ?>
				<span style="color: red;">
				<?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></span>
			</div>
			<div class="form-group">
				<label class="control-label"><?=lang('password')?></label>
				<?php echo form_password($password); ?>
				<span style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></span>
			</div>


	<?php if ($show_captcha) {
		if ($use_recaptcha) { ?>
	<tr>
		<td colspan="2">
			<div id="recaptcha_image"></div>
		</td>
		<td>
			<a href="javascript:Recaptcha.reload()"><?=lang('get_another_captcha')?></a>
			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')"><?=lang('get_an_audio_captcha')?></a></div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')"><?=lang('get_an_image_captcha')?></a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="recaptcha_only_if_image"><?=lang('enter_the_words_above')?></div>
			<div class="recaptcha_only_if_audio"><?=lang('enter_the_numbers_you_hear')?></div>
		</td>
		<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
		<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
		<?php echo $recaptcha_html; ?>
	</tr>
	<?php } else { ?>
	<tr>
		<td colspan="3">
			<p><?=lang('enter_the_code_exactly')?></p>
			<?php echo $captcha_html; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
		<td><?php echo form_input($captcha); ?></td>
		<td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
	</tr>
	<?php }
	} ?>

	<div class="checkbox">
				<label>
					<?php echo form_checkbox($remember); ?> <?=lang('this_is_my_computer')?></a>
				</label>
			</div>
 <a href="<?=base_url()?>auth/forgot_password" class="pull-right m-t-xs"><small><?=lang('forgot_password')?></small></a> 
			<button type="submit" class="btn btn-<?=config_item('theme_color');?>"><?=lang('sign_in')?></button>
			<div class="line line-dashed">
			</div> 
			<?php if (config_item('allow_client_registration') == 'TRUE'){ ?>
			<p class="text-muted text-center"><small><?=lang('do_not_have_an_account')?></small></p> 
			<a href="<?=base_url()?>auth/register/" class="btn btn-success btn-block"><?=lang('get_your_account')?></a>
			<?php } ?>
			
<?php echo form_close(); ?>

 </section>
	<!-- footer --> 
        <?php if (config_item('hide_branding') == 'FALSE') : ?>
	<footer id="footer">
	<div class="text-center text-white padder">
		<p> <small><?=lang('powered_by')?>  <a href="http://codecanyon.net/item/freelancer-office/8870728">Freelancer Office</a> v<?=config_item('version')?> 
		<br>&copy; <?=date('Y')?> <a href="<?=config_item('company_domain')?>" target="_blank"><?=config_item('company_name')?></a> </small> </p>
	</div> 
	</footer>
        <?php endif; ?>
	<!-- / footer -->
	</div> 
	</section>
    </div>
