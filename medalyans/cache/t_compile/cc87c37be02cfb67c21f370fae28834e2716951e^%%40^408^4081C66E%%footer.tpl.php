<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:12:38
         compiled from frontend/components/footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'frontend/components/footer.tpl', 12, false),array('function', 'call_hook', 'frontend/components/footer.tpl', 14, false),array('function', 'url', 'frontend/components/footer.tpl', 26, false),array('function', 'load_script', 'frontend/components/footer.tpl', 56, false),array('modifier', 'escape', 'frontend/components/footer.tpl', 12, false),array('modifier', 'count', 'frontend/components/footer.tpl', 36, false),)), $this); ?>
<footer class="site-footer">
	<div class="container site-footer-sidebar" role="complementary"
	     aria-label="<?php echo ((is_array($_tmp=$this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.navigation.sidebar"), $this))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp));?>
">
		<div class="row">
			<?php echo $this->_plugins['function']['call_hook'][0][0]->smartyCallHook(array('name' => "Templates::Common::Sidebar"), $this);?>

		</div>
	</div>
	<div class="container site-footer-content">
		<div class="row">
			<?php if ($this->_tpl_vars['pageFooter']): ?>
				<div class="col-md site-footer-content align-self-center">
					<?php echo $this->_tpl_vars['pageFooter']; ?>

				</div>
			<?php endif; ?>

			<div class="col-md col-md-2 align-self-center text-right">
				<a href="<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'about','op' => 'aboutThisPublishingSystem'), $this);?>
">
					<img class="footer-brand-image" alt="<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "about.aboutThisPublishingSystem"), $this);?>
"
					     src="<?php echo $this->_tpl_vars['baseUrl']; ?>
/<?php echo $this->_tpl_vars['brandImage']; ?>
">
				</a>
			</div>
		</div>
	</div>
</footer><!-- pkp_structure_footer_wrapper -->

<?php if (count($this->_smarty_vars['capture']['authorBiographyModals'])): ?>
	<?php $_from = $this->_smarty_vars['capture']['authorBiographyModals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['modal']):
?>
		<?php echo $this->_tpl_vars['modal']; ?>

	<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>

<div id="loginModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/loginForm.tpl", 'smarty_include_vars' => array('formType' => 'loginModal')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
		</div>
	</div>
</div>

<?php echo $this->_plugins['function']['load_script'][0][0]->smartyLoadScript(array('context' => 'frontend','scripts' => $this->_tpl_vars['scripts']), $this);?>


<?php echo $this->_plugins['function']['call_hook'][0][0]->smartyCallHook(array('name' => "Templates::Common::Footer::PageFooter"), $this);?>

</body>
</html>