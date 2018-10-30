<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:12:38
         compiled from frontend/components/languageSwitcher.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'frontend/components/languageSwitcher.tpl', 14, false),array('modifier', 'escape', 'frontend/components/languageSwitcher.tpl', 15, false),array('function', 'translate', 'frontend/components/languageSwitcher.tpl', 17, false),array('function', 'url', 'frontend/components/languageSwitcher.tpl', 23, false),)), $this); ?>
<?php if ($this->_tpl_vars['languageToggleLocales'] && count($this->_tpl_vars['languageToggleLocales']) > 1): ?>
	<div id="<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" class="dropdown language-toggle">
		<button class="btn dropdown-toggle" type="button" id="languageToggleMenu<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span class="sr-only"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.language.toggle"), $this);?>
</span>
			<?php echo $this->_tpl_vars['languageToggleLocales'][$this->_tpl_vars['currentLocale']]; ?>

		</button>
		<div class="dropdown-menu" aria-labelledby="languageToggleMenu<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
">
			<?php $_from = $this->_tpl_vars['languageToggleLocales']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['localeKey'] => $this->_tpl_vars['localeName']):
?>
				<?php if ($this->_tpl_vars['localeKey'] !== $this->_tpl_vars['currentLocale']): ?>
					<a class="dropdown-item" href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'page' => 'user','op' => 'setLocale','path' => $this->_tpl_vars['localeKey'],'source' => $_SERVER['REQUEST_URI']), $this);?>
">
						<?php echo $this->_tpl_vars['localeName']; ?>

					</a>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</div>
	</div>
<?php endif; ?>