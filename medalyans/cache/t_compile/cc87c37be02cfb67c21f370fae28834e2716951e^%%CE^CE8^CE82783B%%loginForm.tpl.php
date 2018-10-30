<?php /* Smarty version 2.6.25-dev, created on 2018-10-23 15:35:13
         compiled from frontend/components/loginForm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'csrf', 'frontend/components/loginForm.tpl', 27, false),array('function', 'translate', 'frontend/components/loginForm.tpl', 33, false),array('function', 'url', 'frontend/components/loginForm.tpl', 57, false),array('modifier', 'strip_unsafe_html', 'frontend/components/loginForm.tpl', 28, false),array('modifier', 'escape', 'frontend/components/loginForm.tpl', 28, false),array('modifier', 'assign', 'frontend/components/loginForm.tpl', 83, false),)), $this); ?>
<?php if ($this->_tpl_vars['formType'] && $this->_tpl_vars['formType'] === 'loginPage'): ?>
	<?php $this->assign('usernameId', 'username'); ?>
	<?php $this->assign('passwordId', 'password'); ?>
	<?php $this->assign('rememberId', 'remember'); ?>
<?php elseif ($this->_tpl_vars['formType'] && $this->_tpl_vars['formType'] === 'loginModal'): ?>
	<?php $this->assign('usernameId', 'usernameModal'); ?>
	<?php $this->assign('passwordId', 'passwordModal'); ?>
	<?php $this->assign('rememberId', 'rememberModal'); ?>
<?php endif; ?>
<form class="form-login" method="post" action="<?php echo $this->_tpl_vars['loginUrl']; ?>
">
	<?php echo $this->_plugins['function']['csrf'][0][0]->smartyCSRF(array(), $this);?>

	<input type="hidden" name="source" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['source'])) ? $this->_run_mod_handler('strip_unsafe_html', true, $_tmp) : PKPString::stripUnsafeHtml($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"/>

	<fieldset>
		<div class="form-group form-group-username">
			<label for="<?php echo $this->_tpl_vars['usernameId']; ?>
">
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.username"), $this);?>

				<span class="required" aria-hidden="true">*</span>
				<span class="sr-only">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.required"), $this);?>

				</span>
			</label>
			<input type="text" class="form-control" name="username" id="<?php echo $this->_tpl_vars['usernameId']; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['username'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"
			       maxlength="32" required>
		</div>
		<div class="form-group form-group-password">
			<label for="<?php echo $this->_tpl_vars['passwordId']; ?>
">
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.password"), $this);?>

				<span class="required" aria-hidden="true">*</span>
				<span class="sr-only">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.required"), $this);?>

				</span>
			</label>
			<input type="password" class="form-control" name="password" id="<?php echo $this->_tpl_vars['passwordId']; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['password'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"
			       maxlength="32" required>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group form-group-forgot">
					<small class="form-text">
						<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'login','op' => 'lostPassword'), $this);?>
">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.login.forgotPassword"), $this);?>

						</a>
					</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group form-check form-group-remember">
					<input type="checkbox" class="form-check-input" name="remember" id="<?php echo $this->_tpl_vars['rememberId']; ?>
" value="1"
					       checked="$remember">
					<label for="<?php echo $this->_tpl_vars['rememberId']; ?>
" class="form-check-label">
						<small class="form-text">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.login.rememberUsernameAndPassword"), $this);?>

						</small>
					</label>
				</div>
			</div>
		</div>
		<div class="form-group form-group-buttons">
			<button class="btn btn-primary" type="submit">
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.login"), $this);?>

			</button>
		</div>
		<?php if (! $this->_tpl_vars['disableUserReg']): ?>
			<div class="form-group form-group-register">
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.register.noAccount"), $this);?>

				<?php echo ((is_array($_tmp=$this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'user','op' => 'register','source' => $this->_tpl_vars['source']), $this))) ? $this->_run_mod_handler('assign', true, $_tmp, 'registerUrl') : $this->_plugins['modifier']['assign'][0][0]->smartyAssign($_tmp, 'registerUrl'));?>

				<a href="<?php echo $this->_tpl_vars['registerUrl']; ?>
">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.register.registerHere"), $this);?>

				</a>
			</div>
		<?php endif; ?>
	</fieldset>
</form>