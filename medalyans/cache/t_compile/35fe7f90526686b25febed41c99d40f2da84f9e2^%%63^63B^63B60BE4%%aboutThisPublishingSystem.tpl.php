<?php /* Smarty version 2.6.25-dev, created on 2018-10-26 10:22:54
         compiled from frontend/pages/aboutThisPublishingSystem.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/pages/aboutThisPublishingSystem.tpl', 19, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/header.tpl", 'smarty_include_vars' => array('pageTitle' => "about.aboutThisPublishingSystem")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container page-about-publishing-system">
	<div class="row page-header justify-content-md-center">
		<div class="col-md-8">
			<h1><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "about.aboutThisPublishingSystem"), $this);?>
</h1>
		</div>
	</div>
	<div class="row justify-content-md-center">
		<div class="col-md-8">
			<div class="page-content">
				<p>
					<?php if ($this->_tpl_vars['currentJournal']): ?>
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "about.aboutOJSJournal",'ojsVersion' => $this->_tpl_vars['appVersion']), $this);?>

					<?php else: ?>
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "about.aboutOJSSite",'ojsVersion' => $this->_tpl_vars['appVersion']), $this);?>

					<?php endif; ?>
				</p>
				<img src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/<?php echo $this->_tpl_vars['pubProcessFile']; ?>
" alt="<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "about.aboutThisPublishingSystem.altText"), $this);?>
">
			</div>
		</div>
	</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>