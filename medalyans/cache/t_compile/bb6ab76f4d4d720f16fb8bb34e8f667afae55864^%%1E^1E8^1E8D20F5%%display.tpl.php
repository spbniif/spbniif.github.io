<?php /* Smarty version 2.6.25-dev, created on 2018-10-23 14:28:02
         compiled from plugins/plugins/generic/pdfJsViewer/generic/pdfJsViewer:templates//display.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'plugins/plugins/generic/pdfJsViewer/generic/pdfJsViewer:templates//display.tpl', 11, false),array('modifier', 'escape', 'plugins/plugins/generic/pdfJsViewer/generic/pdfJsViewer:templates//display.tpl', 43, false),array('function', 'translate', 'plugins/plugins/generic/pdfJsViewer/generic/pdfJsViewer:templates//display.tpl', 12, false),array('function', 'call_hook', 'plugins/plugins/generic/pdfJsViewer/generic/pdfJsViewer:templates//display.tpl', 67, false),)), $this); ?>
<!DOCTYPE html>
<html lang="<?php echo ((is_array($_tmp=$this->_tpl_vars['currentLocale'])) ? $this->_run_mod_handler('replace', true, $_tmp, '_', "-") : smarty_modifier_replace($_tmp, '_', "-")); ?>
" xml:lang="<?php echo ((is_array($_tmp=$this->_tpl_vars['currentLocale'])) ? $this->_run_mod_handler('replace', true, $_tmp, '_', "-") : smarty_modifier_replace($_tmp, '_', "-")); ?>
">
<?php ob_start(); ?><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "article.pageTitle",'title' => $this->_tpl_vars['title']), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('pageTitleTranslated', ob_get_contents());ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/headerHead.tpl", 'smarty_include_vars' => array('pageTitleTranslated' => $this->_tpl_vars['pageTitleTranslated'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body class="page-view-pdf">
	<div class="pdf-header">
		<div class="pdf-return-article">
			<a href="<?php echo $this->_tpl_vars['parentUrl']; ?>
" class="btn btn-text">
				←
				<span class="sr-only">
					<?php if ($this->_tpl_vars['parent'] instanceOf Issue): ?>
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "issue.return"), $this);?>

					<?php else: ?>
						<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "article.return"), $this);?>

					<?php endif; ?>
				</span>
				<?php echo $this->_tpl_vars['title']; ?>

			</a>
		</div>
		<div class="pdf-download-button">
			<a href="<?php echo $this->_tpl_vars['pdfUrl']; ?>
" class="btn" download>
				<span class="label">
					<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.download"), $this);?>

				</span>
			</a>
		</div>
	</div>

	<script type="text/javascript" src="<?php echo $this->_tpl_vars['pluginUrl']; ?>
/pdf.js/build/pdf.js"></script>
	<script type="text/javascript">
		<?php echo '
			$(document).ready(function() {
				PDFJS.workerSrc=\''; ?>
<?php echo $this->_tpl_vars['pluginUrl']; ?>
/pdf.js/build/pdf.worker.js<?php echo '\';
				PDFJS.getDocument('; ?>
'<?php echo ((is_array($_tmp=$this->_tpl_vars['pdfUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp, 'javascript')); ?>
'<?php echo ').then(function(pdf) {
					// Using promise to fetch the page
					pdf.getPage(1).then(function(page) {
						var pdfCanvasContainer = $(\'#pdfCanvasContainer\');
						var canvas = document.getElementById(\'pdfCanvas\');
						canvas.height = pdfCanvasContainer.height();
						canvas.width = pdfCanvasContainer.width()-2; // 1px border each side
						var viewport = page.getViewport(canvas.width / page.getViewport(1.0).width);
						var context = canvas.getContext(\'2d\');
						var renderContext = {
							canvasContext: context,
							viewport: viewport
						};
						page.render(renderContext);
					});
				});
			});
		'; ?>

	</script>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['pluginUrl']; ?>
/pdf.js/web/viewer.js"></script>

	<div id="pdfCanvasContainer" class="pdf-frame">
		<iframe src="<?php echo $this->_tpl_vars['pluginUrl']; ?>
/pdf.js/web/viewer.html?file=<?php echo ((is_array($_tmp=$this->_tpl_vars['pdfUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp, 'url')); ?>
" width="100%" height="100%" style="min-height: 500px;" allowfullscreen webkitallowfullscreen></iframe>
	</div>
	<?php echo $this->_plugins['function']['call_hook'][0][0]->smartyCallHook(array('name' => "Templates::Common::Footer::PageFooter"), $this);?>

</body>
</html>