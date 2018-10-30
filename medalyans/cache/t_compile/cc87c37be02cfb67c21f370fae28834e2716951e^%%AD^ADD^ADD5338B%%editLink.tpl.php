<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:12:56
         compiled from frontend/components/editLink.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/components/editLink.tpl', 22, false),array('function', 'url', 'frontend/components/editLink.tpl', 25, false),)), $this); ?>
<?php if (in_array ( ROLE_ID_MANAGER , ( array ) $this->_tpl_vars['userRoles'] )): ?>

		<?php if ($this->_tpl_vars['sectionTitleKey']): ?>
		<?php ob_start(); ?><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => $this->_tpl_vars['sectionTitleKey']), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('sectionTitle', ob_get_contents());ob_end_clean(); ?>
	<?php endif; ?>

	<a class="btn btn-edit-link" href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => $this->_tpl_vars['page'],'op' => $this->_tpl_vars['op'],'path' => $this->_tpl_vars['path'],'anchor' => $this->_tpl_vars['anchor']), $this);?>
">
		<span aria-hidden="true"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.edit"), $this);?>
</span>

				<span class="sr-only">
			<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "help.goToEditPage",'sectionTitle' => $this->_tpl_vars['sectionTitle']), $this);?>

		</span>
	</a>
<?php endif; ?>