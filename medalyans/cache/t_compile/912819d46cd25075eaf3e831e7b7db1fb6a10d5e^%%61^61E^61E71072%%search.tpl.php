<?php /* Smarty version 2.6.25-dev, created on 2018-10-29 11:14:13
         compiled from frontend/pages/search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/pages/search.tpl', 25, false),array('function', 'page_info', 'frontend/pages/search.tpl', 51, false),array('function', 'page_links', 'frontend/pages/search.tpl', 52, false),array('function', 'url', 'frontend/pages/search.tpl', 60, false),array('function', 'csrf', 'frontend/pages/search.tpl', 61, false),array('function', 'html_select_date', 'frontend/pages/search.tpl', 79, false),array('modifier', 'escape', 'frontend/pages/search.tpl', 40, false),array('block', 'iterate', 'frontend/pages/search.tpl', 47, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/header.tpl", 'smarty_include_vars' => array('pageTitle' => "common.search")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container page-search">
	<div class="page-header">
		<h1>
			<?php if ($this->_tpl_vars['query']): ?>
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.search.resultsFor",'query' => $this->_tpl_vars['query']), $this);?>

			<?php elseif ($this->_tpl_vars['authors']): ?>
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.search.resultsFor",'query' => $this->_tpl_vars['authors']), $this);?>

			<?php else: ?>
				<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.search"), $this);?>

			<?php endif; ?>
		</h1>
	</div>
	<div class="row justify-content-lg-center">
		<div class="col-lg-8 search-col-results">
			<div class="search-results">

								<?php if ($this->_tpl_vars['results']->wasEmpty()): ?>
					<?php if ($this->_tpl_vars['error']): ?>
						<div class="alert alert-danger" role="alert"><?php echo ((is_array($_tmp=$this->_tpl_vars['error'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
</div>
					<?php else: ?>
						<div class="alert alert-info" role="alert"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "search.noResults"), $this);?>
</div>
					<?php endif; ?>

								<?php else: ?>
					<?php $this->_tag_stack[] = array('iterate', array('from' => 'results','item' => 'result')); $_block_repeat=true;$this->_plugins['block']['iterate'][0][0]->smartyIterate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/objects/article_summary.tpl", 'smarty_include_vars' => array('article' => $this->_tpl_vars['result']['publishedArticle'],'journal' => $this->_tpl_vars['result']['journal'],'showDatePublished' => true,'hideGalleys' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['iterate'][0][0]->smartyIterate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
					<div class="pagination">
						<?php echo $this->_plugins['function']['page_info'][0][0]->smartyPageInfo(array('iterator' => $this->_tpl_vars['results']), $this);?>

						<?php echo $this->_plugins['function']['page_links'][0][0]->smartyPageLinks(array('anchor' => 'results','iterator' => $this->_tpl_vars['results'],'name' => 'search','query' => $this->_tpl_vars['query'],'searchJournal' => $this->_tpl_vars['searchJournal'],'authors' => $this->_tpl_vars['authors'],'title' => $this->_tpl_vars['title'],'abstract' => $this->_tpl_vars['abstract'],'galleyFullText' => $this->_tpl_vars['galleyFullText'],'discipline' => $this->_tpl_vars['discipline'],'subject' => $this->_tpl_vars['subject'],'type' => $this->_tpl_vars['type'],'coverage' => $this->_tpl_vars['coverage'],'indexTerms' => $this->_tpl_vars['indexTerms'],'dateFromMonth' => $this->_tpl_vars['dateFromMonth'],'dateFromDay' => $this->_tpl_vars['dateFromDay'],'dateFromYear' => $this->_tpl_vars['dateFromYear'],'dateToMonth' => $this->_tpl_vars['dateToMonth'],'dateToDay' => $this->_tpl_vars['dateToDay'],'dateToYear' => $this->_tpl_vars['dateToYear'],'orderBy' => $this->_tpl_vars['orderBy'],'orderDir' => $this->_tpl_vars['orderDir']), $this);?>

					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-lg-4 search-col-filters">
			<div class="search-filters">
				<h2><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.search.params"), $this);?>
</h2>
				<form class="form-search" method="post" action="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('op' => 'search'), $this);?>
">
					<?php echo $this->_plugins['function']['csrf'][0][0]->smartyCSRF(array(), $this);?>

					<div class="form-group form-group-query">
						<label for="query">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.searchQuery"), $this);?>

						</label>
						<input type="text" class="form-control" id="query" name="query" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['query'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
">
					</div>
					<div class="form-group form-group-authors">
						<label for="authors">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "search.author"), $this);?>

						</label>
						<input type="text" class="form-control" id"authors" name="authors" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['authors'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
">
					</div>
					<div class="form-group form-group-date-from">
						<label for="dateFromYear">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "search.dateFrom"), $this);?>

						</label>
						<div class="form-control-date">
							<?php echo smarty_function_html_select_date(array('class' => "form-control",'prefix' => 'dateFrom','time' => $this->_tpl_vars['dateFrom'],'start_year' => $this->_tpl_vars['yearStart'],'end_year' => $this->_tpl_vars['yearEnd'],'year_empty' => "",'month_empty' => "",'day_empty' => "",'field_order' => 'YMD'), $this);?>

						</div>
					</div>
					<div class="form-group form-group-date-to">
						<label for="dateToYear">
							<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "search.dateTo"), $this);?>

						</label>
						<div class="form-control-date">
							<?php echo smarty_function_html_select_date(array('class' => "form-control",'prefix' => 'dateTo','time' => $this->_tpl_vars['dateTo'],'start_year' => $this->_tpl_vars['yearStart'],'end_year' => $this->_tpl_vars['yearEnd'],'year_empty' => "",'month_empty' => "",'day_empty' => "",'field_order' => 'YMD'), $this);?>

						</div>
					</div>
					<div class="form-group form-group-buttons">
						<button class="btn btn-primary" type="submit"><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.search"), $this);?>
</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>