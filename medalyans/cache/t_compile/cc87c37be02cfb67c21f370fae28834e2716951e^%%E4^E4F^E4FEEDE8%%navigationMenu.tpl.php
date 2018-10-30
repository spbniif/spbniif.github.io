<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:12:38
         compiled from frontend/components/navigationMenu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'frontend/components/navigationMenu.tpl', 17, false),array('modifier', 'lower', 'frontend/components/navigationMenu.tpl', 26, false),array('modifier', 'concat', 'frontend/components/navigationMenu.tpl', 30, false),)), $this); ?>

<?php if ($this->_tpl_vars['navigationMenu']): ?>
	<ul id="<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" class="<?php echo ((is_array($_tmp=$this->_tpl_vars['ulClass'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
">
		<?php $_from = $this->_tpl_vars['navigationMenu']->menuTree; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field'] => $this->_tpl_vars['navigationMenuItemAssignment']):
?>
			<?php if (! $this->_tpl_vars['navigationMenuItemAssignment']->navigationMenuItem->getIsDisplayed()): ?>
				<?php continue; ?>
			<?php endif; ?>
			<?php $this->assign('hasChildren', false); ?>
			<?php if (! empty ( $this->_tpl_vars['navigationMenuItemAssignment']->children )): ?>
				<?php $this->assign('hasChildren', true); ?>
			<?php endif; ?>
			<li class="<?php echo ((is_array($_tmp=$this->_tpl_vars['liClass'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['navigationMenuItemAssignment']->navigationMenuItem->getType())) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
<?php if ($this->_tpl_vars['hasChildren']): ?> dropdown<?php endif; ?>">
				<a href="<?php echo $this->_tpl_vars['navigationMenuItemAssignment']->navigationMenuItem->getUrl(); ?>
"
					class="nav-link<?php if ($this->_tpl_vars['hasChildren']): ?> dropdown-toggle<?php endif; ?>"
					<?php if ($this->_tpl_vars['hasChildren']): ?>
						id="<?php echo ((is_array($_tmp='navMenuDropdown')) ? $this->_run_mod_handler('concat', true, $_tmp, $this->_tpl_vars['field']) : $this->_plugins['modifier']['concat'][0][0]->smartyConcat($_tmp, $this->_tpl_vars['field'])); ?>
"
						data-toggle="dropdown"
						aria-haspopup="true"
						aria-expanded="false"
					<?php endif; ?>
				>
					<?php echo $this->_tpl_vars['navigationMenuItemAssignment']->navigationMenuItem->getLocalizedTitle(); ?>

				</a>
				<?php if ($this->_tpl_vars['hasChildren']): ?>
					<div class="dropdown-menu<?php if ($this->_tpl_vars['id'] === 'userNav'): ?> dropdown-menu-right<?php endif; ?>" aria-labelledby="<?php echo ((is_array($_tmp='navMenuDropdown')) ? $this->_run_mod_handler('concat', true, $_tmp, $this->_tpl_vars['field']) : $this->_plugins['modifier']['concat'][0][0]->smartyConcat($_tmp, $this->_tpl_vars['field'])); ?>
">
						<?php $_from = $this->_tpl_vars['navigationMenuItemAssignment']->children; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['childField'] => $this->_tpl_vars['childNavigationMenuItemAssignment']):
?>
							<?php if ($this->_tpl_vars['childNavigationMenuItemAssignment']->navigationMenuItem->getIsDisplayed()): ?>
								<a class="dropdown-item" href="<?php echo $this->_tpl_vars['childNavigationMenuItemAssignment']->navigationMenuItem->getUrl(); ?>
">
									<?php echo $this->_tpl_vars['childNavigationMenuItemAssignment']->navigationMenuItem->getLocalizedTitle(); ?>

								</a>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</div>
				<?php endif; ?>
			</li>
		<?php endforeach; endif; unset($_from); ?>
	</ul>
<?php endif; ?>