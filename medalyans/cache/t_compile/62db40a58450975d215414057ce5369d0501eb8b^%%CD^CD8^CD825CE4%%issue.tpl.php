<?php /* Smarty version 2.6.25-dev, created on 2018-10-23 14:44:53
         compiled from frontend/pages/issue.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/pages/issue.tpl', 37, false),array('function', 'url', 'frontend/pages/issue.tpl', 94, false),array('modifier', 'date_format', 'frontend/pages/issue.tpl', 37, false),array('modifier', 'escape', 'frontend/pages/issue.tpl', 44, false),array('modifier', 'strip_unsafe_html', 'frontend/pages/issue.tpl', 76, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/header.tpl", 'smarty_include_vars' => array('pageTitleTranslated' => $this->_tpl_vars['issueIdentification'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container page-issue">

		<?php if (! $this->_tpl_vars['issue']): ?>
		<div class="page-header page-issue-header">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/notification.tpl", 'smarty_include_vars' => array('messageKey' => "current.noCurrentIssueDesc")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>

		<?php else: ?>
		<div class="page-header page-issue-header">

				<?php if (! $this->_tpl_vars['issue']->getPublished()): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/notification.tpl", 'smarty_include_vars' => array('messageKey' => "editor.issues.preview")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>

			<h1><?php echo $this->_tpl_vars['issue']->getIssueSeries(); ?>
</h1>
			<div class="page-issue-date">
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.currentIssuePublished",'date' => ((is_array($_tmp=$this->_tpl_vars['issue']->getDatePublished())) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['dateFormatLong']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['dateFormatLong']))), $this);?>

			</div>

						<?php $_from = $this->_tpl_vars['pubIdPlugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pubIdPlugin']):
?>
				<?php $this->assign('pubId', $this->_tpl_vars['issue']->getStoredPubId($this->_tpl_vars['pubIdPlugin']->getPubIdType())); ?>
				<?php if ($this->_tpl_vars['pubId']): ?>
					<?php $this->assign('doiUrl', ((is_array($_tmp=$this->_tpl_vars['pubIdPlugin']->getResolvingURL($this->_tpl_vars['currentJournal']->getId(),$this->_tpl_vars['pubId']))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp))); ?>
					<?php if ($this->_tpl_vars['doiUrl']): ?>
						<?php ob_start(); ?>
							<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['doiUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
">
								<?php echo $this->_tpl_vars['doiUrl']; ?>

							</a>
						<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('pubId', ob_get_contents());ob_end_clean(); ?>
					<?php endif; ?>
					<div class="page-issue-doi">
						<?php if ($this->_tpl_vars['pubIdPlugin']->getPubIdType() == 'doi'): ?>
							<?php echo $this->_tpl_vars['pubId']; ?>

						<?php else: ?>
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.issuePubId",'pubIdType' => ((is_array($_tmp=$this->_tpl_vars['pubIdPlugin']->getPubIdDisplayType())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)),'pubId' => $this->_tpl_vars['pubId']), $this);?>

						<?php endif; ?>
					</div>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</div>

		<div class="row justify-content-center page-issue-details">
			<?php if ($this->_tpl_vars['issueGalleys'] || $this->_tpl_vars['issue']->hasDescription() || $this->_tpl_vars['issue']->getLocalizedTitle()): ?>
				<div class="col-lg-9">
					<div class="page-issue-description-wrapper">
						<?php if ($this->_tpl_vars['issue']->hasDescription() || $this->_tpl_vars['issue']->getLocalizedTitle()): ?>
							<div class="page-issue-description">
								<div class="h2">
									<?php if ($this->_tpl_vars['issue']->getLocalizedTitle()): ?>
										<?php echo $this->_tpl_vars['issue']->getLocalizedTitle(); ?>

									<?php else: ?>
										<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.issueDescription"), $this);?>

									<?php endif; ?>
								</div>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedDescription())) ? $this->_run_mod_handler('strip_unsafe_html', true, $_tmp) : PKPString::stripUnsafeHtml($_tmp)); ?>

							</div>
						<?php endif; ?>
						<?php if ($this->_tpl_vars['issueGalleys']): ?>
							<div class="page-issue-galleys">
								<div class="h3">
									<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "issue.fullIssue"), $this);?>

								</div>
								<?php $_from = $this->_tpl_vars['issueGalleys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['galley']):
?>
									<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/objects/galley_link.tpl", 'smarty_include_vars' => array('parent' => $this->_tpl_vars['issue'],'purchaseFee' => $this->_tpl_vars['currentJournal']->getSetting('purchaseIssueFee'),'purchaseCurrency' => $this->_tpl_vars['currentJournal']->getSetting('currency'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
								<?php endforeach; endif; unset($_from); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['issue']->getLocalizedCoverImageUrl()): ?>
				<div class="col-lg-3">
					<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('op' => 'view','page' => 'issue','path' => $this->_tpl_vars['issue']->getBestIssueId()), $this);?>
">
						<img class="img-fluid page-issue-cover" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedCoverImageUrl())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"<?php if ($this->_tpl_vars['issue']->getLocalizedCoverImageAltText() != ''): ?> alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedCoverImageAltText())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"<?php endif; ?>>
					</a>
				</div>
			<?php endif; ?>
		</div><!-- .row -->

		<div class="row">
			<div class="col-12 col-lg-9">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/objects/issue_toc.tpl", 'smarty_include_vars' => array('sectionHeading' => 'h2')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
		</div>
	<?php endif; ?>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>