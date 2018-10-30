<?php /* Smarty version 2.6.25-dev, created on 2018-10-29 11:15:02
         compiled from frontend/components/registrationForm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/components/registrationForm.tpl', 23, false),array('function', 'html_options', 'frontend/components/registrationForm.tpl', 71, false),array('function', 'url', 'frontend/components/registrationForm.tpl', 133, false),array('modifier', 'escape', 'frontend/components/registrationForm.tpl', 33, false),)), $this); ?>
<div class="row justify-content-md-center">
	<div class="col-lg-6">
		<fieldset class="identity">
			<legend>
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.profile"), $this);?>

			</legend>
			<div class="form-group">
				<label for="firstName">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.firstName"), $this);?>

					<span class="required" aria-hidden="true">*</span>
					<span class="sr-only">
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.required"), $this);?>

					</span>
				</label>
				<input class="form-control" type="text" name="firstName" id="firstName" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['firstName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" maxlength="40" required>
			</div>
			<div class="form-group">
				<label for="middleName">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.middleName"), $this);?>

				</label>
				<input class="form-control" type="text" name="middleName" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['middleName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" maxlength="40">
			</div>
			<div class="form-group">
				<label for="lastName">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.lastName"), $this);?>

					<span class="required" aria-hidden="true">*</span>
					<span class="sr-only">
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.required"), $this);?>

					</span>
				</label>
				<input class="form-control" type="text" name="lastName" id="lastName" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['lastName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" maxlength="40" required>
			</div>
			<div class="form-group">
				<label for="affiliation">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.affiliation"), $this);?>

					<span class="required" aria-hidden="true">*</span>
					<span class="sr-only">
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.required"), $this);?>

					</span>
				</label>
				<input class="form-control" type="text" name="affiliation[<?php echo ((is_array($_tmp=$this->_tpl_vars['primaryLocale'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
]" id="affiliation" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['affiliation'][$this->_tpl_vars['primaryLocale']])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" required>
			</div>
			<div class="form-group">
				<label for="country">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.country"), $this);?>

					<span class="required" aria-hidden="true">*</span>
					<span class="sr-only">
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.required"), $this);?>

					</span>
				</label>
				<select class="form-control" name="country" id="country" required>
					<option></option>
					<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['countries'],'selected' => $this->_tpl_vars['country']), $this);?>

				</select>
			</div>
		</fieldset>
	</div>
	<div class="col-lg-6">
		<fieldset class="login">
			<legend>
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.login"), $this);?>

			</legend>
			<div class="form-group">
				<label for="email">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.email"), $this);?>

					<span class="required" aria-hidden="true">*</span>
					<span class="sr-only">
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.required"), $this);?>

					</span>
				</label>
				<input class="form-control" type="text" name="email" id="email" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" maxlength="90" required>
			</div>
			<div class="form-group">
				<label for="username">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.username"), $this);?>

					<span class="required" aria-hidden="true">*</span>
					<span class="sr-only">
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.required"), $this);?>

					</span>
				</label>
				<input class="form-control" type="text" name="username" id="username" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['username'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" maxlength="32" required>
			</div>
			<div class="form-group">
				<label for="password">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.password"), $this);?>

					<span class="required" aria-hidden="true">*</span>
					<span class="sr-only">
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.required"), $this);?>

					</span>
				</label>
				<input class="form-control" type="password" name="password" id="password" password="true" maxlength="32" required>
			</div>
			<div class="form-group">
				<label for="password2">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.repeatPassword"), $this);?>

					<span class="required" aria-hidden="true">*</span>
					<span class="sr-only">
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.required"), $this);?>

					</span>
				</label>
				<input class="form-control" type="password" name="password2" id="password2" password="true" maxlength="32" required>
			</div>
		</fieldset>
	</div>
	<div class="col-lg-12">
				<?php if ($this->_tpl_vars['currentContext']): ?>

			<fieldset class="consent">
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
			<?php $_from = $this->_tpl_vars['readerUserGroups'][$this->_tpl_vars['contextId']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['userGroup']):
?>
				<?php if (in_array ( $this->_tpl_vars['userGroup']->getId() , $this->_tpl_vars['userGroupIds'] )): ?>
					<?php $this->assign('userGroupId', $this->_tpl_vars['userGroup']->getId()); ?>
					<input type="hidden" name="readerGroup[<?php echo $this->_tpl_vars['userGroupId']; ?>
]" value="1">
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
			<?php $_from = $this->_tpl_vars['authorUserGroups'][$this->_tpl_vars['contextId']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['userGroup']):
?>
				<?php if (in_array ( $this->_tpl_vars['userGroup']->getId() , $this->_tpl_vars['userGroupIds'] )): ?>
					<?php $this->assign('userGroupId', $this->_tpl_vars['userGroup']->getId()); ?>
					<input type="hidden" name="authorGroup[<?php echo $this->_tpl_vars['userGroupId']; ?>
]" value="1">
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>

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
					<legend>
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.reviewerPrompt"), $this);?>

					</legend>
					<div id="reviewerOptinGroup" class="form-group">
						<?php $_from = $this->_tpl_vars['reviewerUserGroups'][$this->_tpl_vars['contextId']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['userGroup']):
?>
							<?php if ($this->_tpl_vars['userGroup']->getPermitSelfRegistration()): ?>
								<div class="form-check">
									<input type="checkbox" class="form-check-input if-reviewer-checkbox" name="reviewerGroup[<?php echo $this->_tpl_vars['userGroup']->getId(); ?>
]" id="reviewerGroup-<?php echo $this->_tpl_vars['userGroup']->getId(); ?>
" value="1"<?php if (in_array ( $this->_tpl_vars['userGroup']->getId() , $this->_tpl_vars['userGroupIds'] )): ?> checked="checked"<?php endif; ?>>
									<label for="reviewerGroup-<?php echo $this->_tpl_vars['userGroup']->getId(); ?>
" class="form-check-label">
										<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.reviewerPrompt.userGroup",'userGroup' => $this->_tpl_vars['userGroup']->getLocalizedName()), $this);?>

									</label>
								</div>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</div>

										<div id="reviewerInterests" class="reviewer_interests hidden">
						<div class="label">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.interests"), $this);?>

						</div>
						<ul id="tagitInput" class="interests tag-it" data-field-name="interests[]" data-autocomplete-url="<?php echo ((is_array($_tmp=$this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'page' => 'user','op' => 'getInterests'), $this))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp));?>
">
							<?php $_from = $this->_tpl_vars['interests']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['interest']):
?>
								<li><?php echo ((is_array($_tmp=$this->_tpl_vars['interest'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
</li>
							<?php endforeach; endif; unset($_from); ?>
						</ul>
					</div>
				</fieldset>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>