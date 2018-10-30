<?php /* Smarty version 2.6.25-dev, created on 2018-10-29 12:57:23
         compiled from frontend/components/registrationFormContexts.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/components/registrationFormContexts.tpl', 27, false),array('function', 'url', 'frontend/components/registrationFormContexts.tpl', 73, false),)), $this); ?>

<?php if (! $this->_tpl_vars['currentContext']): ?>

		<fieldset name="contexts">
		<legend>
			<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register.contextsPrompt"), $this);?>

		</legend>
		<div class="fields">
			<div id="contextOptinGroup" class="context_optin">
				<ul class="contexts">
					<?php $_from = $this->_tpl_vars['contexts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['context']):
?>
						<?php $this->assign('contextId', $this->_tpl_vars['context']->getId()); ?>
						<?php $this->assign('isSelected', false); ?>
						<li class="context">
							<div class="name">
								<?php echo $this->_tpl_vars['context']->getLocalizedName(); ?>

							</div class="name">
							<fieldset class="roles">
								<legend>
									<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register.otherContextRoles"), $this);?>

								</legend>
								<?php $_from = $this->_tpl_vars['readerUserGroups'][$this->_tpl_vars['contextId']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['userGroup']):
?>
									<?php if ($this->_tpl_vars['userGroup']->getPermitSelfRegistration()): ?>
										<?php $this->assign('userGroupId', $this->_tpl_vars['userGroup']->getId()); ?>
										<label>
											<input type="checkbox" name="readerGroup[<?php echo $this->_tpl_vars['userGroupId']; ?>
]"<?php if (in_array ( $this->_tpl_vars['userGroupId'] , $this->_tpl_vars['userGroupIds'] )): ?> checked="checked"<?php endif; ?>>
											<?php echo $this->_tpl_vars['userGroup']->getLocalizedName(); ?>

										</label>
										<?php if (in_array ( $this->_tpl_vars['userGroupId'] , $this->_tpl_vars['userGroupIds'] )): ?>
											<?php $this->assign('isSelected', true); ?>
										<?php endif; ?>
									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
								<?php $_from = $this->_tpl_vars['reviewerUserGroups'][$this->_tpl_vars['contextId']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['userGroup']):
?>
									<?php if ($this->_tpl_vars['userGroup']->getPermitSelfRegistration()): ?>
										<?php $this->assign('userGroupId', $this->_tpl_vars['userGroup']->getId()); ?>
										<label>
											<input type="checkbox" name="reviewerGroup[<?php echo $this->_tpl_vars['userGroupId']; ?>
]"<?php if (in_array ( $this->_tpl_vars['userGroupId'] , $this->_tpl_vars['userGroupIds'] )): ?> checked="checked"<?php endif; ?>>
											<?php echo $this->_tpl_vars['userGroup']->getLocalizedName(); ?>

										</label>
										<?php if (in_array ( $this->_tpl_vars['userGroupId'] , $this->_tpl_vars['userGroupIds'] )): ?>
											<?php $this->assign('isSelected', true); ?>
										<?php endif; ?>
									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</fieldset>
														<?php if (! $this->_tpl_vars['enableSiteWidePrivacyStatement'] && $this->_tpl_vars['context']->getSetting('privacyStatement')): ?>
								<div class="context_privacy <?php if ($this->_tpl_vars['isSelected']): ?>context_privacy_visible<?php endif; ?>">
									<label>
										<input type="checkbox" name="privacyConsent[<?php echo $this->_tpl_vars['contextId']; ?>
]" id="privacyConsent[<?php echo $this->_tpl_vars['contextId']; ?>
]" value="1"<?php if ($this->_tpl_vars['privacyConsent'][$this->_tpl_vars['contextId']]): ?> checked="checked"<?php endif; ?>>
										<?php ob_start(); ?><?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'context' => $this->_tpl_vars['context']->getPath(),'page' => 'about','op' => 'privacy'), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('privacyUrl', ob_get_contents());ob_end_clean(); ?>
										<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register.form.privacyConsentThisContext",'privacyUrl' => $this->_tpl_vars['privacyUrl']), $this);?>

									</label>
								</div>
							<?php endif; ?>
						</li>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
			</div>
		</div>
	</fieldset>
<?php endif; ?>