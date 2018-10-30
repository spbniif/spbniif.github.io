<?php /* Smarty version 2.6.25-dev, created on 2018-10-29 11:15:02
         compiled from frontend/pages/userRegister.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/pages/userRegister.tpl', 17, false),array('function', 'url', 'frontend/pages/userRegister.tpl', 24, false),array('function', 'csrf', 'frontend/pages/userRegister.tpl', 25, false),array('modifier', 'escape', 'frontend/pages/userRegister.tpl', 26, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/header.tpl", 'smarty_include_vars' => array('pageTitle' => "user.register")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container page-login">
	<div class="row page-header justify-content-md-center">
		<div class="col-md-8">
			<h1><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register"), $this);?>
</h1>
		</div>
	</div>
	<div class="row justify-content-md-center">
		<div class="col-md-8">
			<div class="page-content">

				<form class="form-register" id="register" method="post" action="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('op' => 'register'), $this);?>
">
					<?php echo $this->_plugins['function']['csrf'][0][0]->smartyCSRF(array(), $this);?>

					<input type="hidden" name="source" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['source'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" />

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/formErrors.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/registrationForm.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/registrationFormContexts.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

										<?php if ($this->_tpl_vars['reCaptchaHtml']): ?>
						<div class="form-group">
							<?php echo $this->_tpl_vars['reCaptchaHtml']; ?>

						</div>
					<?php endif; ?>

					<div class="form-group form-group-buttons">
						<button class="btn btn-primary" type="submit">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register"), $this);?>

						</button>
					</div>
					<div class="form-group form-group-login">
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.register.haveAccount"), $this);?>

						<?php ob_start(); ?><?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'user','op' => 'profile','path' => 'roles'), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('rolesProfileUrl', ob_get_contents());ob_end_clean(); ?>
						<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'login','source' => $this->_tpl_vars['rolesProfileUrl']), $this);?>
" class="login">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.register.loginHere"), $this);?>

						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div><!-- .page -->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>