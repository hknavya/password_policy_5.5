<?php  
/** 
	Module Name : password settings
	Description: single page for password settings ui.
	Author Name: Navya H.K  
**/     
defined('C5_EXECUTE') or die(_("Access Denied."));	
$dh = Loader::helper('concrete/dashboard');
$ih = Loader::helper('concrete/interface');
$val = Loader::helper('validation/form');
$form = Loader::helper('form');?>
<?php echo $dh->getDashboardPaneHeaderWrapper(t('Password Settings'), t('Admin password settings.'), 'span16', false); ?>
<form method="post" action="<?php echo $this->action('save')?>" id="ccm-password-save">
	<div class="ccm-pane-body">
		<h3>Password Settings</h3>
			<div class="clearfix">
				<label for="password_history">Reuse time</label>
				<div class="input">
					<?php echo $form->text('password_reset_interval',$passwordResetInterval); ?><span> days</span> <div>The number of days before password can be reused</div>
				</div>
			</div>
			<div class="clearfix">
				<label for="password_age">Repeat interval</label>
				<div class="input">
					<?php echo $form->text('password_repeat_interval',$passwordRepeatInterval); ?><div>Number of times before an old password can be reused</div>
				</div>
			</div>
			<div class="clearfix">
				<label for="password_expiry_time">Expiry time</label>
				<div class="input">
					<?php echo $form->text('password_expiry_time',$passwordExpiryTime); ?><span> days</span> <div>Maximum number of days for which password can be used</div>
				</div>
			</div>
			<div class="clearfix">
				<label for="password_login_attempt">Login attempts</label>
				<div class="input">
					<?php echo $form->text('password_login_attempt',$passwordLoginAttempt); ?><div>Number of times a user can attempt to use their password before their account is automatically locked</div>
				</div>
			</div>
			<div class="clearfix">
				<label for="password_length">Password length</label>
				<div class="input">
					<?php echo $form->text('password_length',$passwordLength); ?><div>Minimum number of characters allowed in a password</div>
				</div>
			</div>
			<h4>Password Complexity</h4>
			<div class="clearfix">
				<label for="min_uppercase">Min no of uppercase</label>
				<div class="input">
					<?php echo $form->text('min_uppercase',$minUppercase); ?>
				</div>
			</div>
			<div class="clearfix">
				<label for="min_lowercase">Min no of lowercase</label>
				<div class="input">
					<?php echo $form->text('min_lowercase',$minLowercase); ?>
				</div>
			</div>
			<div class="clearfix">
				<label for="min_numeric_character">Minimum number of Numeric Characters</label>
				<div class="input">
					<?php echo $form->text('min_numeric_character',$minNumericCharacter); ?>
				</div>
			</div>
			<div class="clearfix">
				<label for="min_non_alphanumeric">Min no of non-alphanumeric</label>
				<div class="input">
					<?php echo $form->text('min_non_alphanumeric',$minNonAlphanumeric); ?><div>Minimum number of non-alphanumeric characters except (> < " ' \ /)</div>
				</div>
			</div>
			<div class="clearfix">
				<label for="min_consecutive_characters">Consecutive username characters</label>
				<div class="input">
					<?php echo $form->text('min_consecutive_character',$minConsecutiveCharacter); ?><div>Maximum number of consecutive characters from username allowed</div>
				</div>
			</div>
	</div>

	<div class="ccm-pane-footer">
		<?php echo $ih->submit(t('Save'),'ccm-password-save','right','primary')?>
	</div>

</form>
<?php echo $dh->getDashboardPaneFooterWrapper(false);?>
