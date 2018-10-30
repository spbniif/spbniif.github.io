<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:13:17
         compiled from frontend/pages/issueArchive.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/pages/issueArchive.tpl', 19, false),array('function', 'url', 'frontend/pages/issueArchive.tpl', 62, false),array('modifier', 'trim', 'frontend/pages/issueArchive.tpl', 72, false),)), $this); ?>
<?php ob_start(); ?>
	<?php if ($this->_tpl_vars['prevPage']): ?>
		<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "archive.archivesPageNumber",'pageNumber' => $this->_tpl_vars['prevPage']+1), $this);?>

	<?php else: ?>
		<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "archive.archives"), $this);?>

	<?php endif; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('pageTitle', ob_get_contents());ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/header.tpl", 'smarty_include_vars' => array('pageTitleTranslated' => $this->_tpl_vars['pageTitle'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container page-archives">

	<div class="page-header page-archives-header">
		<h1><?php echo $this->_tpl_vars['pageTitle']; ?>
</h1>
	</div>

		<?php if (empty ( $this->_tpl_vars['issues'] )): ?>
		<div class="row">
			<div class="col-md-8">
				<p><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "current.noCurrentIssueDesc"), $this);?>
</p>
			</div>
		</div>

		<?php else: ?>
		<?php $_from = $this->_tpl_vars['issues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['issue']):
?>
			<?php if ($this->_tpl_vars['i'] % 4 == 0 && $this->_tpl_vars['i'] > 0): ?>
				</div>
				<?php $this->assign('open', false); ?>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['i'] % 4 == 0): ?>
				<div class="row justify-content-around">
				<?php $this->assign('open', true); ?>
			<?php endif; ?>
			<div class="col-md-3 col-lg-2">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/objects/issue_summary.tpl", 'smarty_include_vars' => array('heading' => 'h2')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
		<?php endforeach; endif; unset($_from); ?>
		<?php if ($this->_tpl_vars['open']): ?>
			</div>		<?php endif; ?>

				<?php ob_start(); ?>
			<?php if ($this->_tpl_vars['prevPage'] > 1): ?>
				<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'page' => 'issue','op' => 'archive','path' => $this->_tpl_vars['prevPage']), $this);?>

			<?php elseif ($this->_tpl_vars['prevPage'] === 1): ?>
				<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'page' => 'issue','op' => 'archive'), $this);?>

			<?php endif; ?>
		<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('prevUrl', ob_get_contents());ob_end_clean(); ?>
		<?php ob_start(); ?>
			<?php if ($this->_tpl_vars['nextPage']): ?>
				<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'page' => 'issue','op' => 'archive','path' => $this->_tpl_vars['nextPage']), $this);?>

			<?php endif; ?>
		<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('nextUrl', ob_get_contents());ob_end_clean(); ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/pagination.tpl", 'smarty_include_vars' => array('prevUrl' => ((is_array($_tmp=$this->_tpl_vars['prevUrl'])) ? $this->_run_mod_handler('trim', true, $_tmp) : trim($_tmp)),'nextUrl' => ((is_array($_tmp=$this->_tpl_vars['nextUrl'])) ? $this->_run_mod_handler('trim', true, $_tmp) : trim($_tmp)),'showingStart' => $this->_tpl_vars['showingStart'],'showingEnd' => $this->_tpl_vars['showingEnd'],'total' => $this->_tpl_vars['total'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
</div>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>