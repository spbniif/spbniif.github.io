<?php /* Smarty version 2.6.25-dev, created on 2018-10-29 12:57:23
         compiled from frontend/pages/userRegister.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'frontend/pages/userRegister.tpl', 17, false),array('function', 'csrf', 'frontend/pages/userRegister.tpl', 18, false),array('function', 'translate', 'frontend/pages/userRegister.tpl', 39, false),array('modifier', 'escape', 'frontend/pages/userRegister.tpl', 21, false),array('modifier', 'assign', 'frontend/pages/userRegister.tpl', 182, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/header.tpl", 'smarty_include_vars' => array('pageTitle' => "user.register")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="page page_register">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/breadcrumbs.tpl", 'smarty_include_vars' => array('currentTitleKey' => "user.register")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<form class="cmp_form register" id="register" method="post" action="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('op' => 'register'), $this);?>
">
		<?php echo $this->_plugins['function']['csrf'][0][0]->smartyCSRF(array(), $this);?>


		<?php if ($this->_tpl_vars['source']): ?>
			<input type="hidden" name="source" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['source'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" />
		<?php endif; ?>

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

				<?php if ($this->_tpl_vars['currentContext']): ?>

			<fieldset class="consent">
				<?php if ($this->_tpl_vars['currentContext']->getSetting('privacyStatement')): ?>
										<div class="fields">
						<div class="optin optin-privacy">
							<label>
								<input type="checkbox" name="privacyConsent" value="1"<?php if ($this->_tpl_vars['privacyConsent']): ?> checked="checked"<?php endif; ?>>
								<?php ob_start(); ?><?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'page' => 'about','op' => 'privacy'), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('privacyUrl', ob_get_contents());ob_end_clean(); ?>
								<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register.form.privacyConsent",'privacyUrl' => $this->_tpl_vars['privacyUrl']), $this);?>

							</label>
						</div>
					</div>
				<?php endif; ?>
								<div class="fields">
					<div class="optin optin-email">
						<label>
							<input type="checkbox" name="emailConsent" value="1"<?php if ($this->_tpl_vars['emailConsent']): ?> checked="checked"<?php endif; ?>>
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register.form.emailConsent"), $this);?>

						</label>
					</div>
				</div>
			</fieldset>

						<?php $this->assign('contextId', $this->_tpl_vars['currentContext']->getId()); ?>
			<?php $this->assign('userCanRegisterReviewer', 0); ?>
			<?php $_from = $this->_tpl_vars['reviewerUserGroups'][$this->_tpl_vars['contextId']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['userGroup']):
?>
				<?php if ($this->_tpl_vars['userGroup']->getPermitSelfRegistration()): ?>
					<?php $this->assign('userCanRegisterReviewer', $this->_tpl_vars['userCanRegisterReviewer']+1); ?>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
			<?php if ($this->_tpl_vars['userCanRegisterReviewer']): ?>
				<fieldset class="reviewer">
					<?php if ($this->_tpl_vars['userCanRegisterReviewer'] > 1): ?>
						<legend>
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.reviewerPrompt"), $this);?>

						</legend>
						<?php ob_start(); ?>user.reviewerPrompt.userGroup<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('checkboxLocaleKey', ob_get_contents());ob_end_clean(); ?>
					<?php else: ?>
						<?php ob_start(); ?>user.reviewerPrompt.optin<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('checkboxLocaleKey', ob_get_contents());ob_end_clean(); ?>
					<?php endif; ?>
					<div class="fields">
						<div id="reviewerOptinGroup" class="optin">
							<?php $_from = $this->_tpl_vars['reviewerUserGroups'][$this->_tpl_vars['contextId']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['userGroup']):
?>
								<?php if ($this->_tpl_vars['userGroup']->getPermitSelfRegistration()): ?>
									<label>
										<?php $this->assign('userGroupId', $this->_tpl_vars['userGroup']->getId()); ?>
										<input type="checkbox" name="reviewerGroup[<?php echo $this->_tpl_vars['userGroupId']; ?>
]" value="1"<?php if (in_array ( $this->_tpl_vars['userGroupId'] , $this->_tpl_vars['userGroupIds'] )): ?> checked="checked"<?php endif; ?>>
										<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => $this->_tpl_vars['checkboxLocaleKey'],'userGroup' => $this->_tpl_vars['userGroup']->getLocalizedName()), $this);?>

									</label>
								<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?>
						</div>

						<div id="reviewerInterests" class="reviewer_interests">
														<div class="label">
								<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.interests"), $this);?>

							</div>
							<ul class="interests tag-it" data-field-name="interests[]" data-autocomplete-url="<?php echo ((is_array($_tmp=$this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'page' => 'user','op' => 'getInterests'), $this))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp));?>
">
								<?php $_from = $this->_tpl_vars['interests']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['interest']):
?>
									<li><?php echo ((is_array($_tmp=$this->_tpl_vars['interest'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
</li>
								<?php endforeach; endif; unset($_from); ?>
							</ul>
						</div>
					</div>
				</fieldset>
			<?php endif; ?>
		<?php endif; ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/registrationFormContexts.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

				<?php if (! $this->_tpl_vars['currentContext']): ?>
			<fieldset class="reviewer_nocontext_interests">
				<legend>
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register.noContextReviewerInterests"), $this);?>

				</legend>
				<div class="fields">
					<div class="reviewer_nocontext_interests">
												<ul class="interests tag-it" data-field-name="interests[]" data-autocomplete-url="<?php echo ((is_array($_tmp=$this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'page' => 'user','op' => 'getInterests'), $this))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp));?>
">
							<?php $_from = $this->_tpl_vars['interests']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['interest']):
?>
								<li><?php echo ((is_array($_tmp=$this->_tpl_vars['interest'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
</li>
							<?php endforeach; endif; unset($_from); ?>
						</ul>
					</div>
				</div>
			</fieldset>

						<?php if ($this->_tpl_vars['siteWidePrivacyStatement']): ?>
				<div class="fields">
					<div class="optin optin-privacy">
						<label>
							<input type="checkbox" name="privacyConsent[<?php echo @CONTEXT_ID_NONE; ?>
]" id="privacyConsent[<?php echo @CONTEXT_ID_NONE; ?>
]" value="1"<?php if ($this->_tpl_vars['privacyConsent'][@CONTEXT_ID_NONE]): ?> checked="checked"<?php endif; ?>>
							<?php ob_start(); ?><?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'page' => 'about','op' => 'privacy'), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('privacyUrl', ob_get_contents());ob_end_clean(); ?>
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register.form.privacyConsent",'privacyUrl' => $this->_tpl_vars['privacyUrl']), $this);?>

						</label>
					</div>
				</div>
			<?php endif; ?>

						<div class="fields">
				<div class="optin optin-email">
					<label>
						<input type="checkbox" name="emailConsent" value="1"<?php if ($this->_tpl_vars['emailConsent']): ?> checked="checked"<?php endif; ?>>
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register.form.emailConsent"), $this);?>

					</label>
				</div>
			</div>
		<?php endif; ?>

				<?php if ($this->_tpl_vars['reCaptchaHtml']): ?>
			<fieldset class="recaptcha_wrapper">
				<div class="fields">
					<div class="recaptcha">
						<?php echo $this->_tpl_vars['reCaptchaHtml']; ?>

					</div>
				</div>
			</fieldset>
		<?php endif; ?>

		<div class="buttons">
			<button class="submit" type="submit">
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register"), $this);?>

			</button>

			<?php echo ((is_array($_tmp=$this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'user','op' => 'profile','path' => 'roles'), $this))) ? $this->_run_mod_handler('assign', true, $_tmp, 'rolesProfileUrl') : $this->_plugins['modifier']['assign'][0][0]->smartyAssign($_tmp, 'rolesProfileUrl'));?>

			<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'login','source' => $this->_tpl_vars['rolesProfileUrl']), $this);?>
" class="login"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.login"), $this);?>
</a>
		</div>
	</form>

</div><!-- .page -->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>