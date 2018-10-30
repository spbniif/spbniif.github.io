<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:12:38
         compiled from frontend/objects/article_summary.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'frontend/objects/article_summary.tpl', 32, false),array('modifier', 'date_format', 'frontend/objects/article_summary.tpl', 52, false),array('modifier', 'substr_replace', 'frontend/objects/article_summary.tpl', 72, false),array('function', 'url', 'frontend/objects/article_summary.tpl', 45, false),array('function', 'call_hook', 'frontend/objects/article_summary.tpl', 98, false),)), $this); ?>
<?php $this->assign('articlePath', $this->_tpl_vars['article']->getBestArticleId()); ?>

<?php if (( ! $this->_tpl_vars['section']['hideAuthor'] && $this->_tpl_vars['article']->getHideAuthor() == @AUTHOR_TOC_DEFAULT ) || $this->_tpl_vars['article']->getHideAuthor() == @AUTHOR_TOC_SHOW): ?>
	<?php $this->assign('showAuthor', true); ?>
<?php endif; ?>

<div class="article-summary">

	<?php if ($this->_tpl_vars['showAuthor'] && $this->_tpl_vars['article']->getPages()): ?>
		<div class="row">
			<div class="col">
				<div class="article-summary-authors"><?php echo $this->_tpl_vars['article']->getAuthorString(); ?>
</div>
			</div>
			<div class="col-3 col-md-2 col-lg-1">
				<div class="article-summary-pages text-right">
					<?php echo ((is_array($_tmp=$this->_tpl_vars['article']->getPages())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

				</div>
			</div>
		</div>
	<?php elseif ($this->_tpl_vars['showAuthor']): ?>
		<div class="article-summary-authors"><?php echo $this->_tpl_vars['article']->getAuthorString(); ?>
</div>
	<?php elseif ($this->_tpl_vars['article']->getPages()): ?>
		<div class="article-summary-pages">
			<?php echo ((is_array($_tmp=$this->_tpl_vars['article']->getPages())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

		</div>
	<?php endif; ?>

	<div class="article-summary-title">
		<a <?php if ($this->_tpl_vars['journal']): ?>href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('journal' => $this->_tpl_vars['journal']->getPath(),'page' => 'article','op' => 'view','path' => $this->_tpl_vars['articlePath']), $this);?>
"<?php else: ?>href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'article','op' => 'view','path' => $this->_tpl_vars['articlePath']), $this);?>
"<?php endif; ?>>
			<?php echo ((is_array($_tmp=$this->_tpl_vars['article']->getLocalizedFullTitle())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

		</a>
	</div>

	<?php if ($this->_tpl_vars['showDatePublished'] && $this->_tpl_vars['article']->getDatePublished()): ?>
		<div class="article-summary-date">
			<?php echo ((is_array($_tmp=$this->_tpl_vars['article']->getDatePublished())) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['dateFormatLong']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['dateFormatLong'])); ?>

		</div>
	<?php endif; ?>

		<?php if ($this->_tpl_vars['requestedPage'] === 'issue'): ?>
		<?php $_from = $this->_tpl_vars['pubIdPlugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pubIdPlugin']):
?>
			<?php if ($this->_tpl_vars['pubIdPlugin']->getPubIdType() != 'doi'): ?>
				<?php continue; ?>
			<?php endif; ?>
			<?php $this->assign('pubId', $this->_tpl_vars['article']->getStoredPubId($this->_tpl_vars['pubIdPlugin']->getPubIdType())); ?>
			<?php if ($this->_tpl_vars['pubId']): ?>
				<?php $this->assign('doiUrl', ((is_array($_tmp=$this->_tpl_vars['pubIdPlugin']->getResolvingURL($this->_tpl_vars['currentJournal']->getId(),$this->_tpl_vars['pubId']))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp))); ?>
				<div class="article-summary-doi">
					<a href="<?php echo $this->_tpl_vars['doiUrl']; ?>
"><?php echo $this->_tpl_vars['doiUr']; ?>
</a>
				</div>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		<?php elseif ($this->_tpl_vars['requestedOp'] === 'index' && $this->_tpl_vars['article']->getStoredPubId('doi')): ?>
		<?php $this->assign('doiUrl', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['article']->getStoredPubId('doi'))) ? $this->_run_mod_handler('substr_replace', true, $_tmp, 'https://doi.org/', 0, 0) : substr_replace($_tmp, 'https://doi.org/', 0, 0)))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp))); ?>
		<?php if ($this->_tpl_vars['doiUrl']): ?>
			<div class="article-summary-doi">
				<a href="<?php echo $this->_tpl_vars['doiUrl']; ?>
"><?php echo $this->_tpl_vars['doiUrl']; ?>
</a>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if (! $this->_tpl_vars['hideGalleys'] && $this->_tpl_vars['article']->getGalleys()): ?>
		<div class="article-summary-galleys">
			<?php $_from = $this->_tpl_vars['article']->getGalleys(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['galley']):
?>
				<?php if ($this->_tpl_vars['primaryGenreIds']): ?>
					<?php $this->assign('file', $this->_tpl_vars['galley']->getFile()); ?>
					<?php if (! $this->_tpl_vars['galley']->getRemoteUrl() && ! ( $this->_tpl_vars['file'] && in_array ( $this->_tpl_vars['file']->getGenreId() , $this->_tpl_vars['primaryGenreIds'] ) )): ?>
						<?php continue; ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php $this->assign('hasArticleAccess', $this->_tpl_vars['hasAccess']); ?>
				<?php if (( $this->_tpl_vars['article']->getAccessStatus() == @ARTICLE_ACCESS_OPEN )): ?>
					<?php $this->assign('hasArticleAccess', 1); ?>
				<?php endif; ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/objects/galley_link.tpl", 'smarty_include_vars' => array('parent' => $this->_tpl_vars['article'],'hasAccess' => $this->_tpl_vars['hasArticleAccess'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</div>
	<?php endif; ?>

	<?php echo $this->_plugins['function']['call_hook'][0][0]->smartyCallHook(array('name' => "Templates::Issue::Issue::Article"), $this);?>

</div>