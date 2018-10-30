<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:38:49
         compiled from controllers/grid/gridRowSelectInput.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'controllers/grid/gridRowSelectInput.tpl', 10, false),)), $this); ?>
<input type="checkbox" id="select-<?php echo ((is_array($_tmp=$this->_tpl_vars['elementId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['selectName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
[]" style="height: 15px; width: 15px;" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['elementId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" <?php if ($this->_tpl_vars['selected']): ?>checked="checked"<?php endif; ?> />