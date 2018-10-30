<?php /* Smarty version 2.6.25-dev, created on 2018-10-29 11:15:02
         compiled from frontend/components/registrationFormContexts.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/components/registrationFormContexts.tpl', 27, false),)), $this); ?>

<?php if (! $this->_tpl_vars['currentContext']): ?>

		<fieldset class="contexts">
		<legend>
			<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register.contextsPrompt"), $this);?>

		</legend>
		<div class="list-group">
			<?php $_from = $this->_tpl_vars['contexts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['context']):
?>
				<?php $this->assign('contextId', $this->_tpl_vars['context']->getId()); ?>
				<div class="list-group-item">
					<div class="list-group-item-heading">
						<?php echo $this->_tpl_vars['context']->getLocalizedName(); ?>

					</div>
					<p>
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "user.register.otherContextRoles"), $this);?>

					</p>
					<div class="form-group">
						<?php $_from = $this->_tpl_vars['readerUserGroups'][$this->_tpl_vars['contextId']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['userGroup']):
?>
							<?php if ($this->_tpl_vars['userGroup']->getPermitSelfRegistration()): ?>
								<div class="form-check">
									<input type="checkbox" class="form-check-input" name="readerGroup[<?php echo $this->_tpl_vars['userGroup']->getId(); ?>
]"<?php if (in_array ( $this->_tpl_vars['userGroup']->getId() , $this->_tpl_vars['userGroupIds'] )): ?> checked="checked"<?php endif; ?>>
									<label class="form-check-label">
										<?php echo $this->_tpl_vars['userGroup']->getLocalizedName(); ?>

									</label>
								</div>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
						<?php $_from = $this->_tpl_vars['authorUserGroups'][$this->_tpl_vars['contextId']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['userGroup']):
?>
							<?php if ($this->_tpl_vars['userGroup']->getPermitSelfRegistration()): ?>
								<div class="form-check">
									<input type="checkbox" class="form-check-input" name="authorGroup[<?php echo $this->_tpl_vars['userGroup']->getId(); ?>
]"<?php if (in_array ( $this->_tpl_vars['userGroup']->getId() , $this->_tpl_vars['userGroupIds'] )): ?> checked="checked"<?php endif; ?>>
									<label class="form-check-label">
										<?php echo $this->_tpl_vars['userGroup']->getLocalizedName(); ?>

									</label>
								</div>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
						<?php $_from = $this->_tpl_vars['reviewerUserGroups'][$this->_tpl_vars['contextId']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['userGroup']):
?>
							<?php if ($this->_tpl_vars['userGroup']->getPermitSelfRegistration()): ?>
								<div class="form-check">
									<input type="checkbox" class="form-check-input" name="reviewerGroup[<?php echo $this->_tpl_vars['userGroup']->getId(); ?>
]"<?php if (in_array ( $this->_tpl_vars['userGroup']->getId() , $this->_tpl_vars['userGroupIds'] )): ?> checked="checked"<?php endif; ?>>
									<label class="form-check-label">
										<?php echo $this->_tpl_vars['userGroup']->getLocalizedName(); ?>

									</label>
								</div>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</div>
				</div>
			<?php endforeach; endif; unset($_from); ?>
		</div>
	</fieldset>
<?php endif; ?>