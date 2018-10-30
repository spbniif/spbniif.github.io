<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:12:38
         compiled from frontend/components/navigationMenus/dashboardMenuItem.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'frontend/components/navigationMenus/dashboardMenuItem.tpl', 11, false),)), $this); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['navigationMenuItem']->getLocalizedTitle())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

<span class="badge badge-light">
	<?php echo $this->_tpl_vars['unreadNotificationCount']; ?>

</span>