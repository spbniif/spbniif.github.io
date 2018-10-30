<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:12:38
         compiled from frontend/pages/indexJournal.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'frontend/pages/indexJournal.tpl', 23, false),array('modifier', 'date_format', 'frontend/pages/indexJournal.tpl', 37, false),array('modifier', 'strip_unsafe_html', 'frontend/pages/indexJournal.tpl', 62, false),array('function', 'translate', 'frontend/pages/indexJournal.tpl', 31, false),array('function', 'url', 'frontend/pages/indexJournal.tpl', 45, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/header.tpl", 'smarty_include_vars' => array('pageTitleTranslated' => $this->_tpl_vars['currentJournal']->getLocalizedName())));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['homepageImage']): ?>
	<div class="homepage-image<?php if ($this->_tpl_vars['issue']): ?> homepage-image-behind-issue<?php endif; ?>">
		<img src="<?php echo $this->_tpl_vars['publicFilesDir']; ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['homepageImage']['uploadName'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp, 'url')); ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['homepageImageAltText'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
">
	</div>
<?php endif; ?>

<div class="container container-homepage-issue">

	<?php if ($this->_tpl_vars['issue']): ?>
		<h2 class="h5 homepage-issue-current">
			<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "journal.currentIssue"), $this);?>

		</h2>
		<div class="h1 homepage-issue-identifier">
			<?php echo $this->_tpl_vars['issue']->getIssueSeries(); ?>

		</div>
		<div class="h6 homepage-issue-published">
			<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.currentIssuePublished",'date' => ((is_array($_tmp=$this->_tpl_vars['issue']->getDatePublished())) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['dateFormatLong']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['dateFormatLong']))), $this);?>

		</div>

				<?php if ($this->_tpl_vars['issue']->getLocalizedCoverImageUrl() || $this->_tpl_vars['issue']->hasDescription() || $this->_tpl_vars['issueGalleys']): ?>
			<div class="row justify-content-center homepage-issue-header">
				<?php if ($this->_tpl_vars['issue']->getLocalizedCoverImageUrl()): ?>
					<div class="col-lg-3">
						<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('op' => 'view','page' => 'issue','path' => $this->_tpl_vars['issue']->getBestIssueId()), $this);?>
">
							<img class="img-fluid homepage-issue-cover" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedCoverImageUrl())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"<?php if ($this->_tpl_vars['issue']->getLocalizedCoverImageAltText() != ''): ?> alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedCoverImageAltText())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"<?php endif; ?>>
						</a>
					</div>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['issue']->hasDescription() || $this->_tpl_vars['journalDescription'] || $this->_tpl_vars['issueGalleys']): ?>
					<div class="col-lg-9">
						<div class="homepage-issue-description-wrapper">
							<?php if ($this->_tpl_vars['issue']->hasDescription()): ?>
								<div class="homepage-issue-description">
									<div class="h2">
										<?php if ($this->_tpl_vars['issue']->getLocalizedTitle()): ?>
											<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedTitle())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

										<?php else: ?>
											<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.issueDescription"), $this);?>

										<?php endif; ?>
									</div>
									<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedDescription())) ? $this->_run_mod_handler('strip_unsafe_html', true, $_tmp) : PKPString::stripUnsafeHtml($_tmp)); ?>

									<div class="homepage-issue-description-more">
										<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('op' => 'view','page' => 'issue','path' => $this->_tpl_vars['issue']->getBestIssueId()), $this);?>
"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.more"), $this);?>
</a>
									</div>
								</div>
							<?php elseif ($this->_tpl_vars['journalDescription']): ?>
								<div class="homepage-journal-description long-text" id="homepageDescription">
									<?php echo ((is_array($_tmp=$this->_tpl_vars['journalDescription'])) ? $this->_run_mod_handler('strip_unsafe_html', true, $_tmp) : PKPString::stripUnsafeHtml($_tmp)); ?>

								</div>
								<div class="homepage-description-buttons hidden" id="homepageDescriptionButtons">
									<a class="homepage-journal-description-more hidden" id="homepageDescriptionMore"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.more"), $this);?>
</a>
									<a class="homepage-journal-description-less hidden" id="homepageDescriptionLess"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.less"), $this);?>
</a>
								</div>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['issueGalleys']): ?>
								<div class="homepage-issue-galleys">
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
			</div>
		<?php endif; ?>

		<div class="row justify-content-center<?php if ($this->_tpl_vars['homepageImage'] && $this->_tpl_vars['issue']->hasDescription()): ?> issue-full-data<?php elseif ($this->_tpl_vars['homepageImage'] && $this->_tpl_vars['issue']->getLocalizedCoverImageUrl()): ?> issue-image-cover<?php elseif ($this->_tpl_vars['homepageImage']): ?> issue-only-image<?php endif; ?>">
			<div class="col-12 col-lg-9">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/objects/issue_toc.tpl", 'smarty_include_vars' => array('sectionHeading' => 'h3')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
		</div>

		<div class="text-center">
			<a class="btn" href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'page' => 'issue','op' => 'archive'), $this);?>
">
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "journal.viewAllIssues"), $this);?>

			</a>
		</div>
	<?php endif; ?>

		<?php if ($this->_tpl_vars['additionalHomeContent']): ?>
		<div class="row justify-content-center homepage-additional-content">
			<div class="col-lg-9"><?php echo $this->_tpl_vars['additionalHomeContent']; ?>
</div>
		</div>
	<?php endif; ?>
</div><!-- .container -->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>