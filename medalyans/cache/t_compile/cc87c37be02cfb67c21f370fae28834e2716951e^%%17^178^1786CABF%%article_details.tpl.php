<?php /* Smarty version 2.6.25-dev, created on 2018-10-27 20:01:41
         compiled from frontend/objects/article_details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'frontend/objects/article_details.tpl', 37, false),array('function', 'translate', 'frontend/objects/article_details.tpl', 69, false),array('function', 'call_hook', 'frontend/objects/article_details.tpl', 279, false),array('modifier', 'escape', 'frontend/objects/article_details.tpl', 37, false),array('modifier', 'date_format', 'frontend/objects/article_details.tpl', 69, false),array('modifier', 'count', 'frontend/objects/article_details.tpl', 92, false),array('modifier', 'strip_unsafe_html', 'frontend/objects/article_details.tpl', 289, false),array('modifier', 'nl2br', 'frontend/objects/article_details.tpl', 330, false),array('block', 'iterate', 'frontend/objects/article_details.tpl', 326, false),)), $this); ?>
<div class="article-details">
	<div class="page-header row">
		<div class="col-lg article-meta-mobile">
						<div class="article-details-issue-section small-screen">
				<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'issue','op' => 'view','path' => $this->_tpl_vars['issue']->getBestIssueId()), $this);?>
"><?php echo $this->_tpl_vars['issue']->getIssueSeries(); ?>
</a><?php if ($this->_tpl_vars['section']): ?>, <span><?php echo ((is_array($_tmp=$this->_tpl_vars['section']->getLocalizedTitle())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
</span><?php endif; ?>
			</div>

			<div class="article-details-issue-identifier large-screen">
				<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'issue','op' => 'view','path' => $this->_tpl_vars['issue']->getBestIssueId()), $this);?>
"><?php echo $this->_tpl_vars['issue']->getIssueSeries(); ?>
</a>
			</div>

			<h1 class="article-details-fulltitle">
				<?php echo ((is_array($_tmp=$this->_tpl_vars['article']->getLocalizedFullTitle())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

			</h1>

			<?php if ($this->_tpl_vars['section']): ?>
				<div class="article-details-issue-section large-screen"><?php echo ((is_array($_tmp=$this->_tpl_vars['section']->getLocalizedTitle())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
</div>
			<?php endif; ?>

						<?php $_from = $this->_tpl_vars['pubIdPlugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pubIdPlugin']):
?>
				<?php if ($this->_tpl_vars['pubIdPlugin']->getPubIdType() != 'doi'): ?>
					<?php continue; ?>
				<?php endif; ?>
				<?php $this->assign('pubId', $this->_tpl_vars['article']->getStoredPubId($this->_tpl_vars['pubIdPlugin']->getPubIdType())); ?>
				<?php if ($this->_tpl_vars['pubId']): ?>
					<?php $this->assign('doiUrl', ((is_array($_tmp=$this->_tpl_vars['pubIdPlugin']->getResolvingURL($this->_tpl_vars['currentJournal']->getId(),$this->_tpl_vars['pubId']))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp))); ?>
					<div class="article-details-doi large-screen">
						<a href="<?php echo $this->_tpl_vars['doiUrl']; ?>
"><?php echo $this->_tpl_vars['doiUrl']; ?>
</a>
					</div>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>

						<?php if ($this->_tpl_vars['article']->getDatePublished()): ?>
				<div class="article-details-published">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.currentIssuePublished",'date' => ((is_array($_tmp=$this->_tpl_vars['article']->getDatePublished())) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['dateFormatLong']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['dateFormatLong']))), $this);?>

				</div>
			<?php endif; ?>

			<?php if ($this->_tpl_vars['article']->getAuthors()): ?>
				<ul class="authors-string">
					<?php $_from = $this->_tpl_vars['article']->getAuthors(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['authorStringKey'] => $this->_tpl_vars['authorString']):
?>
						<?php echo '<li><a class="author-string-href" href="#author-'; ?><?php echo $this->_tpl_vars['authorStringKey']+1; ?><?php echo '"><span>'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['authorString']->getFullName())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?><?php echo '</span><sup class="author-symbol author-plus">&plus;</sup><sup class="author-symbol author-minus hide">&minus;</sup></a>'; ?><?php if ($this->_tpl_vars['authorString']->getOrcid()): ?><?php echo '<a class="orcidImage" href="'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['authorString']->getOrcid())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?><?php echo '"><img src="'; ?><?php echo $this->_tpl_vars['baseUrl']; ?><?php echo '/'; ?><?php echo $this->_tpl_vars['orcidImage']; ?><?php echo '"></a>'; ?><?php endif; ?><?php echo '</li>'; ?>

					<?php endforeach; endif; unset($_from); ?>
				</ul>

								<?php $this->assign('authorCount', count($this->_tpl_vars['article']->getAuthors())); ?>
				<?php $this->assign('authorBioIndex', 0); ?>
				<div class="article-details-authors">
					<?php $_from = $this->_tpl_vars['article']->getAuthors(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['authorKey'] => $this->_tpl_vars['author']):
?>
						<div class="article-details-author hideAuthor" id="author-<?php echo $this->_tpl_vars['authorKey']+1; ?>
">
							<div class="article-details-author-name small-screen">
								<?php echo ((is_array($_tmp=$this->_tpl_vars['author']->getFullName())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

							</div>
							<?php if ($this->_tpl_vars['author']->getLocalizedAffiliation()): ?>
								<div class="article-details-author-affiliation"><?php echo ((is_array($_tmp=$this->_tpl_vars['author']->getLocalizedAffiliation())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
</div>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['author']->getOrcid()): ?>
								<div class="article-details-author-orcid">
									<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['author']->getOrcid())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" target="_blank">
										<?php echo $this->_tpl_vars['orcidIcon']; ?>

										<?php echo ((is_array($_tmp=$this->_tpl_vars['author']->getOrcid())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

									</a>
								</div>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['author']->getLocalizedBiography()): ?>
								<button type="button" class="article-details-bio-toggle" data-toggle="modal" data-target="#authorBiographyModal<?php echo ($this->_foreach['authorLoop']['iteration']-1); ?>
">
									<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.article.authorBio"), $this);?>

								</button>
																<?php ob_start(); ?>
									<div
											class="modal fade"
											id="authorBiographyModal<?php echo ($this->_foreach['authorLoop']['iteration']-1); ?>
"
											tabindex="-1"
											role="dialog"
											aria-labelledby="authorBiographyModalTitle<?php echo ($this->_foreach['authorLoop']['iteration']-1); ?>
"
											aria-hidden="true"
									>
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<div class="modal-title" id="authorBiographyModalTitle<?php echo ($this->_foreach['authorLoop']['iteration']-1); ?>
">
														<?php echo ((is_array($_tmp=$this->_tpl_vars['author']->getFullName())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

													</div>
													<button type="button" class="close" data-dismiss="modal" aria-label="<?php echo ((is_array($_tmp=$this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.close"), $this))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp));?>
">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<?php echo $this->_tpl_vars['author']->getLocalizedBiography(); ?>

												</div>
											</div>
										</div>
									</div>
								<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->append('authorBiographyModalsTemp', ob_get_contents());ob_end_clean(); ?>
							<?php endif; ?>
						</div>
					<?php endforeach; endif; unset($_from); ?>
				</div>

			<?php endif; ?>
		</div>
	</div><!-- .page-header -->

	<div class="row justify-content-md-center" id="mainArticleContent">
		<div class="col-lg-3 order-lg-2" id="articleDetailsWrapper">
			<div class="article-details-sidebar" id="articleDetails">

								<?php if ($this->_tpl_vars['article']->getLocalizedCoverImage() || $this->_tpl_vars['issue']->getLocalizedCoverImage()): ?>
					<div class="article-details-block article-details-cover">
						<?php if ($this->_tpl_vars['article']->getLocalizedCoverImage()): ?>
							<img class="img-fluid" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['article']->getLocalizedCoverImageUrl())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"<?php if ($this->_tpl_vars['article']->getLocalizedCoverImageAltText()): ?> alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['article']->getLocalizedCoverImageAltText())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"<?php endif; ?>>
						<?php else: ?>
							<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'issue','op' => 'view','path' => $this->_tpl_vars['issue']->getBestIssueId()), $this);?>
">
								<img class="img-fluid" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedCoverImageUrl())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"<?php if ($this->_tpl_vars['issue']->getLocalizedCoverImageAltText()): ?> alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['issue']->getLocalizedCoverImageAltText())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
"<?php endif; ?>>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

								<?php ob_start(); ?>
					<?php $_from = $this->_tpl_vars['authorBiographyModalsTemp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['modal']):
?>
						<?php echo $this->_tpl_vars['modal']; ?>

					<?php endforeach; endif; unset($_from); ?>
				<?php $this->_smarty_vars['capture']['authorBiographyModals'] = ob_get_contents(); ob_end_clean(); ?>


								<?php if ($this->_tpl_vars['primaryGalleys']): ?>
					<div class="article-details-block article-details-galleys article-details-galleys-sidebar">
						<?php $_from = $this->_tpl_vars['primaryGalleys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['galley']):
?>
							<div class="article-details-galley">
								<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/objects/galley_link.tpl", 'smarty_include_vars' => array('parent' => $this->_tpl_vars['article'],'galley' => $this->_tpl_vars['galley'],'purchaseFee' => $this->_tpl_vars['currentJournal']->getSetting('purchaseArticleFee'),'purchaseCurrency' => $this->_tpl_vars['currentJournal']->getSetting('currency'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
							</div>
						<?php endforeach; endif; unset($_from); ?>
					</div>
				<?php endif; ?>

								<?php if ($this->_tpl_vars['supplementaryGalleys']): ?>
					<div class="article-details-block article-details-galleys-supplementary">
						<h2 class="article-details-heading"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.article.supplementaryFiles"), $this);?>
</h2>
						<?php $_from = $this->_tpl_vars['supplementaryGalleys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['galley']):
?>
							<div class="article-details-galley">
								<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/objects/galley_link.tpl", 'smarty_include_vars' => array('parent' => $this->_tpl_vars['article'],'galley' => $this->_tpl_vars['galley'],'isSupplementary' => '1')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
							</div>
						<?php endforeach; endif; unset($_from); ?>
					</div>
				<?php endif; ?>

								<?php if (! empty ( $this->_tpl_vars['keywords'][$this->_tpl_vars['currentLocale']] )): ?>
					<div class="article-details-block article-details-keywords">
						<h2 class="article-details-heading">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "article.subject"), $this);?>

						</h2>
						<div class="article-details-keywords-value">
							<?php $_from = $this->_tpl_vars['keywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['keyword']):
?>
								<?php $_from = $this->_tpl_vars['keyword']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['keywords'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['keywords']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['keywordItem']):
        $this->_foreach['keywords']['iteration']++;
?>
									<span><?php echo ((is_array($_tmp=$this->_tpl_vars['keywordItem'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
</span><?php if (! ($this->_foreach['keywords']['iteration'] == $this->_foreach['keywords']['total'])): ?><br><?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							<?php endforeach; endif; unset($_from); ?>
						</div>
					</div>
				<?php endif; ?>

								<?php if ($this->_tpl_vars['citation']): ?>
					<div class="article-details-block article-details-how-to-cite">
						<h2 class="article-details-heading">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "submission.howToCite"), $this);?>

						</h2>
						<div id="citationOutput" class="article-details-how-to-cite-citation" role="region" aria-live="polite">
							<?php echo $this->_tpl_vars['citation']; ?>

						</div>
						<div class="dropdown">
							<button class="btn dropdown-toggle" type="button" id="cslCitationFormatsButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-csl-dropdown="true">
								<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "submission.howToCite.citationFormats"), $this);?>

							</button>
							<div class="dropdown-menu" aria-labelledby="cslCitationFormatsButton">
								<?php $_from = $this->_tpl_vars['citationStyles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['citationStyle']):
?>
									<a
										class="dropdown-item"
										aria-controls="citationOutput"
										href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'citationstylelanguage','op' => 'get','path' => $this->_tpl_vars['citationStyle']['id'],'params' => $this->_tpl_vars['citationArgs']), $this);?>
"
										data-load-citation
										data-json-href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'citationstylelanguage','op' => 'get','path' => $this->_tpl_vars['citationStyle']['id'],'params' => $this->_tpl_vars['citationArgsJson']), $this);?>
"
									>
										<?php echo ((is_array($_tmp=$this->_tpl_vars['citationStyle']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

									</a>
								<?php endforeach; endif; unset($_from); ?>
								<?php if (count ( $this->_tpl_vars['citationDownloads'] )): ?>
									<h3 class="dropdown-header">
										<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "submission.howToCite.downloadCitation"), $this);?>

									</h3>
									<?php $_from = $this->_tpl_vars['citationDownloads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['citationDownload']):
?>
										<a class="dropdown-item" href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'citationstylelanguage','op' => 'download','path' => $this->_tpl_vars['citationDownload']['id'],'params' => $this->_tpl_vars['citationArgs']), $this);?>
">
											<?php echo ((is_array($_tmp=$this->_tpl_vars['citationDownload']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

										</a>
									<?php endforeach; endif; unset($_from); ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

								<?php $_from = $this->_tpl_vars['pubIdPlugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pubIdPlugin']):
?>
					<?php if ($this->_tpl_vars['pubIdPlugin']->getPubIdType() == 'doi'): ?>
						<?php continue; ?>
					<?php endif; ?>
					<?php $this->assign('pubId', $this->_tpl_vars['article']->getStoredPubId($this->_tpl_vars['pubIdPlugin']->getPubIdType())); ?>
					<?php if ($this->_tpl_vars['pubId']): ?>
						<div class="article-details-block article-details-pubid">
							<h2 class="article-details-heading">
								<?php echo ((is_array($_tmp=$this->_tpl_vars['pubIdPlugin']->getPubIdDisplayType())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

							</h2>
							<div class="article-details-pubid-value">
								<?php if (((is_array($_tmp=$this->_tpl_vars['pubIdPlugin']->getResolvingURL($this->_tpl_vars['currentJournal']->getId(),$this->_tpl_vars['pubId']))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp))): ?>
									<a id="pub-id::<?php echo ((is_array($_tmp=$this->_tpl_vars['pubIdPlugin']->getPubIdType())) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['pubIdPlugin']->getResolvingURL($this->_tpl_vars['currentJournal']->getId(),$this->_tpl_vars['pubId']))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
">
										<?php echo ((is_array($_tmp=$this->_tpl_vars['pubIdPlugin']->getResolvingURL($this->_tpl_vars['currentJournal']->getId(),$this->_tpl_vars['pubId']))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

									</a>
								<?php else: ?>
									<?php echo ((is_array($_tmp=$this->_tpl_vars['pubId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>

								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>

				<?php echo $this->_plugins['function']['call_hook'][0][0]->smartyCallHook(array('name' => "Templates::Article::Details"), $this);?>

			</div>
		</div>
		<div class="col-lg-9 order-lg-1" id="articleMainWrapper">
			<div class="article-details-main" id="articleMain">

								<?php if ($this->_tpl_vars['article']->getLocalizedAbstract()): ?>
					<div class="article-details-block article-details-abstract">
						<h2 class="article-details-heading"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "article.abstract"), $this);?>
</h2>
						<?php echo ((is_array($_tmp=$this->_tpl_vars['article']->getLocalizedAbstract())) ? $this->_run_mod_handler('strip_unsafe_html', true, $_tmp) : PKPString::stripUnsafeHtml($_tmp)); ?>

					</div>
				<?php endif; ?>

								<?php $_from = $this->_tpl_vars['pubIdPlugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pubIdPlugin']):
?>
					<?php if ($this->_tpl_vars['pubIdPlugin']->getPubIdType() != 'doi'): ?>
						<?php continue; ?>
					<?php endif; ?>
					<?php $this->assign('pubId', $this->_tpl_vars['article']->getStoredPubId($this->_tpl_vars['pubIdPlugin']->getPubIdType())); ?>
					<?php if ($this->_tpl_vars['pubId']): ?>
						<?php $this->assign('doiUrl', ((is_array($_tmp=$this->_tpl_vars['pubIdPlugin']->getResolvingURL($this->_tpl_vars['currentJournal']->getId(),$this->_tpl_vars['pubId']))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp))); ?>
						<div class="article-details-block article-details-doi small-screen">
							<a href="<?php echo $this->_tpl_vars['doiUrl']; ?>
"><?php echo $this->_tpl_vars['doiUrl']; ?>
</a>
						</div>
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>

								<?php if ($this->_tpl_vars['primaryGalleys']): ?>
					<div class="article-details-block article-details-galleys article-details-galleys-btm">
						<?php $_from = $this->_tpl_vars['primaryGalleys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['galley']):
?>
							<div class="article-details-galley">
								<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/objects/galley_link.tpl", 'smarty_include_vars' => array('parent' => $this->_tpl_vars['article'],'galley' => $this->_tpl_vars['galley'],'purchaseFee' => $this->_tpl_vars['currentJournal']->getSetting('purchaseArticleFee'),'purchaseCurrency' => $this->_tpl_vars['currentJournal']->getSetting('currency'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
							</div>
						<?php endforeach; endif; unset($_from); ?>
					</div>
				<?php endif; ?>

								<?php if ($this->_tpl_vars['parsedCitations']->getCount() || $this->_tpl_vars['article']->getCitations()): ?>
					<div class="article-details-block article-details-references">
						<h2 class="article-details-heading">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "submission.citations"), $this);?>

						</h2>
						<div class="article-details-references-value">
							<?php if ($this->_tpl_vars['parsedCitations']->getCount()): ?>
								<?php $this->_tag_stack[] = array('iterate', array('from' => 'parsedCitations','item' => 'parsedCitation')); $_block_repeat=true;$this->_plugins['block']['iterate'][0][0]->smartyIterate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
									<p><?php echo ((is_array($_tmp=$this->_tpl_vars['parsedCitation']->getCitationWithLinks())) ? $this->_run_mod_handler('strip_unsafe_html', true, $_tmp) : PKPString::stripUnsafeHtml($_tmp)); ?>
</p>
								<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['iterate'][0][0]->smartyIterate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
							<?php elseif ($this->_tpl_vars['article']->getCitations()): ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['article']->getCitations())) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

								<?php if ($this->_tpl_vars['copyright'] || $this->_tpl_vars['licenseUrl']): ?>
					<div class="article-details-block article-details-license">
						<?php if ($this->_tpl_vars['licenseUrl']): ?>
							<?php if ($this->_tpl_vars['ccLicenseBadge']): ?>
								<?php echo $this->_tpl_vars['ccLicenseBadge']; ?>

							<?php else: ?>
								<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['licenseUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" class="copyright">
									<?php if ($this->_tpl_vars['copyrightHolder']): ?>
										<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "submission.copyrightStatement",'copyrightHolder' => $this->_tpl_vars['copyrightHolder'],'copyrightYear' => $this->_tpl_vars['copyrightYear']), $this);?>

									<?php else: ?>
										<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "submission.license"), $this);?>

									<?php endif; ?>
								</a>
							<?php endif; ?>
						<?php endif; ?>
						<?php if (! $this->_tpl_vars['licenseUrl']): ?>
							<?php echo $this->_tpl_vars['copyright']; ?>

						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php echo $this->_plugins['function']['call_hook'][0][0]->smartyCallHook(array('name' => "Templates::Article::Main"), $this);?>


			</div>
		</div>

		<div class="col-lg-12 order-lg-3 article-footer-hook">
			<?php echo $this->_plugins['function']['call_hook'][0][0]->smartyCallHook(array('name' => "Templates::Article::Footer::PageFooter"), $this);?>

		</div>

	</div>
</div>