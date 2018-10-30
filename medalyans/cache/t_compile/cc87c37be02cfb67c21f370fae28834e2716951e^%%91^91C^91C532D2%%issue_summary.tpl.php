<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:13:17
         compiled from frontend/objects/issue_summary.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'frontend/objects/issue_summary.tpl', 16, false),array('modifier', 'escape', 'frontend/objects/issue_summary.tpl', 17, false),array('modifier', 'date_format', 'frontend/objects/issue_summary.tpl', 28, false),)), $this); ?>

<div class="card issue-summary">
	<?php if ($this->_tpl_vars['issue']->getLocalizedCoverImageUrl()): ?>
		<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('op' => 'view','path' => $this->_tpl_vars['issue']->getBestIssueId()), $this);?>
">
			<img class="card-img-top issue-summary-cover" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedCoverImageUrl())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"<?php if ($this->_tpl_vars['issue']->getLocalizedCoverImageAltText() != ''): ?> alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedCoverImageAltText())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"<?php endif; ?>>
		</a>
	<?php endif; ?>
	<div class="card-body">
		<<?php echo $this->_tpl_vars['heading']; ?>
 class="card-title issue-summary-series">
			<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('op' => 'view','path' => $this->_tpl_vars['issue']->getBestIssueId()), $this);?>
">
				<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getIssueSeries())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

			</a>
		</<?php echo $this->_tpl_vars['heading']; ?>
>
		<?php if ($this->_tpl_vars['issue']->getShowTitle() && $this->_tpl_vars['issue']->getLocalizedTitle()): ?>
			<div class="card-text">
				<p class="issue-summary-date"><?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getDatePublished())) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['dateFormatLong']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['dateFormatLong'])); ?>
</p>
				<p class="issue-summary-title"><?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedTitle())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
</p>
			</div>
		<?php endif; ?>
	</div>
</div>