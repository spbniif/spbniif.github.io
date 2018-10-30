<?php /* Smarty version 2.6.25-dev, created on 2018-10-27 18:18:48
         compiled from frontend/pages/userLostPassword.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/pages/userLostPassword.tpl', 16, false),array('function', 'url', 'frontend/pages/userLostPassword.tpl', 30, false),array('function', 'csrf', 'frontend/pages/userLostPassword.tpl', 31, false),array('modifier', 'escape', 'frontend/pages/userLostPassword.tpl', 38, false),array('modifier', 'assign', 'frontend/pages/userLostPassword.tpl', 46, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/header.tpl", 'smarty_include_vars' => array('pageTitle' => "user.login.resetPassword")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container page-lost-password">
	<div class="row page-header justify-content-md-center">
		<div class="col-md-8">
			<h1 class="text-md-center"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.login.resetPassword"), $this);?>
</h1>
		</div>
	</div>
	<div class="row justify-content-md-center">
		<div class="col-md-8">
			<div class="page-content">
				<p><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.login.resetPasswordInstructions"), $this);?>
</p>
				<?php if ($this->_tpl_vars['error']): ?>
					<div class="alert alert-danger">
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => $this->_tpl_vars['error']), $this);?>

					</div>
				<?php endif; ?>
				<div class="row justify-content-md-center mt-5">
					<div class="col-md-6">
						<form class="form-lost-password" action="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'login','op' => 'requestResetPassword'), $this);?>
" method="post">
							<?php echo $this->_plugins['function']['csrf'][0][0]->smartyCSRF(array(), $this);?>

							<div class="form-group">
								<label for="email">
									<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.login.registeredEmail"), $this);?>

									<span class="required" aria-hidden="true">*</span>
									<span class="sr-only"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.required"), $this);?>
</span>
								</label>
								<input type="text" class="form-control" name="email" id="email" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" required>
							</div>
							<div class="form-group form-group-buttons">
								<button class="btn btn-primary" type="submit">
									<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.login.resetPassword"), $this);?>

								</button>

								<?php if (! $this->_tpl_vars['disableUserReg']): ?>
									<?php echo ((is_array($_tmp=$this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'user','op' => 'register','source' => $this->_tpl_vars['source']), $this))) ? $this->_run_mod_handler('assign', true, $_tmp, 'registerUrl') : $this->_plugins['modifier']['assign'][0][0]->smartyAssign($_tmp, 'registerUrl'));?>

									<a href="<?php echo $this->_tpl_vars['registerUrl']; ?>
" class="btn btn-link">
										<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.login.registerNewAccount"), $this);?>

									</a>
								<?php endif; ?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>