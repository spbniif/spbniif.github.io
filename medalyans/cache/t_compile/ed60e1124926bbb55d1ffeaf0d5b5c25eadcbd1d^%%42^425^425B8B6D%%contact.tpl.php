<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:38:26
         compiled from frontend/pages/contact.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/pages/contact.tpl', 25, false),array('modifier', 'nl2br', 'frontend/pages/contact.tpl', 36, false),array('modifier', 'strip_unsafe_html', 'frontend/pages/contact.tpl', 36, false),array('modifier', 'escape', 'frontend/pages/contact.tpl', 49, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/header.tpl", 'smarty_include_vars' => array('pageTitle' => "about.contact")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container page-contact">
	<div class="page-header">
		<h1><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "about.contact"), $this);?>
</h1>
	</div>
	<div class="row justify-content-md-center">
		<div class="col-md-6">
			<div class="page-content">

								<div class="contact-section">

					<?php if ($this->_tpl_vars['mailingAddress']): ?>
						<div class="address">
							<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['mailingAddress'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('strip_unsafe_html', true, $_tmp) : PKPString::stripUnsafeHtml($_tmp)); ?>

						</div>
					<?php endif; ?>

										<?php if ($this->_tpl_vars['contactTitle'] || $this->_tpl_vars['contactName'] || $this->_tpl_vars['contactAffiliation'] || $this->_tpl_vars['contactPhone'] || $this->_tpl_vars['contactEmail']): ?>
						<div class="contact-primary">
							<h2>
								<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "about.contact.principalContact"), $this);?>

							</h2>

							<?php if ($this->_tpl_vars['contactName']): ?>
							<div class="contact-name">
								<?php echo ((is_array($_tmp=$this->_tpl_vars['contactName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

							</div>
							<?php endif; ?>

							<?php if ($this->_tpl_vars['contactTitle']): ?>
							<div class="contact-title">
								<?php echo ((is_array($_tmp=$this->_tpl_vars['contactTitle'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

							</div>
							<?php endif; ?>

							<?php if ($this->_tpl_vars['contactAffiliation']): ?>
							<div class="contact-affiliation">
								<?php echo ((is_array($_tmp=$this->_tpl_vars['contactAffiliation'])) ? $this->_run_mod_handler('strip_unsafe_html', true, $_tmp) : PKPString::stripUnsafeHtml($_tmp)); ?>

							</div>
							<?php endif; ?>

							<?php if ($this->_tpl_vars['contactPhone']): ?>
							<div class="contact-phone">
								<span class="label">
									<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "about.contact.phone"), $this);?>

								</span>
								<span class="value">
									<?php echo ((is_array($_tmp=$this->_tpl_vars['contactPhone'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

								</span>
							</div>
							<?php endif; ?>

							<?php if ($this->_tpl_vars['contactEmail']): ?>
							<div class="contact-email">
								<a href="mailto:<?php echo ((is_array($_tmp=$this->_tpl_vars['contactEmail'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
">
									<?php echo ((is_array($_tmp=$this->_tpl_vars['contactEmail'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

								</a>
							</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

										<?php if ($this->_tpl_vars['supportName'] || $this->_tpl_vars['supportPhone'] || $this->_tpl_vars['supportEmail']): ?>
						<div class="contact-support">
							<h2>
								<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "about.contact.supportContact"), $this);?>

							</h2>

							<?php if ($this->_tpl_vars['supportName']): ?>
							<div class="contact-name">
								<?php echo ((is_array($_tmp=$this->_tpl_vars['supportName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

							</div>
							<?php endif; ?>

							<?php if ($this->_tpl_vars['supportPhone']): ?>
							<div class="contact-phone">
								<span class="label">
									<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "about.contact.phone"), $this);?>

								</span>
								<span class="value">
									<?php echo ((is_array($_tmp=$this->_tpl_vars['supportPhone'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

								</span>
							</div>
							<?php endif; ?>

							<?php if ($this->_tpl_vars['supportEmail']): ?>
							<div class="contact-email">
								<a href="mailto:<?php echo ((is_array($_tmp=$this->_tpl_vars['supportEmail'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
">
									<?php echo ((is_array($_tmp=$this->_tpl_vars['supportEmail'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

								</a>
							</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<p>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/editLink.tpl", 'smarty_include_vars' => array('page' => 'management','op' => 'settings','path' => 'context','anchor' => 'contact','sectionTitleKey' => "about.contact")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</p>
			</div>
		</div>
	</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>