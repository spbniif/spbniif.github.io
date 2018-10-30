<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:39:29
         compiled from plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl', 17, false),array('function', 'csrf', 'plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl', 25, false),array('function', 'fbvElement', 'plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl', 31, false),array('function', 'translate', 'plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl', 36, false),array('modifier', 'json_encode', 'plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl', 17, false),array('modifier', 'escape', 'plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl', 27, false),array('modifier', 'replace', 'plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl', 35, false),array('modifier', 'concat', 'plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl', 44, false),array('modifier', 'uniqid', 'plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl', 44, false),array('block', 'fbvFormArea', 'plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl', 29, false),array('block', 'fbvFormSection', 'plugins/plugins/generic/staticPages/generic/staticPages:templates/editStaticPageForm.tpl', 30, false),)), $this); ?>
<script src="<?php echo $this->_tpl_vars['pluginJavaScriptURL']; ?>
/StaticPageFormHandler.js"></script>
<script>
	$(function() {
		// Attach the form handler.
		$('#staticPageForm').pkpHandler(
			'$.pkp.controllers.form.staticPages.StaticPageFormHandler',
			{
				previewUrl: <?php echo ((is_array($_tmp=$this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'page' => 'pages','op' => 'preview'), $this))) ? $this->_run_mod_handler('json_encode', true, $_tmp) : json_encode($_tmp));?>

			}
		);
	});
</script>

<?php ob_start(); ?><?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_COMPONENT,'component' => "plugins.generic.staticPages.controllers.grid.StaticPageGridHandler",'op' => 'updateStaticPage','existingPageName' => $this->_tpl_vars['blockName'],'escape' => false), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('actionUrl', ob_get_contents());ob_end_clean(); ?>
<form class="pkp_form" id="staticPageForm" method="post" action="<?php echo $this->_tpl_vars['actionUrl']; ?>
">
	<?php echo $this->_plugins['function']['csrf'][0][0]->smartyCSRF(array(), $this);?>

	<?php if ($this->_tpl_vars['staticPageId']): ?>
		<input type="hidden" name="staticPageId" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['staticPageId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
" />
	<?php endif; ?>
	<?php $this->_tag_stack[] = array('fbvFormArea', array('id' => 'staticPagesFormArea','class' => 'border')); $_block_repeat=true;$this->_plugins['block']['fbvFormArea'][0][0]->smartyFBVFormArea($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		<?php $this->_tag_stack[] = array('fbvFormSection', array()); $_block_repeat=true;$this->_plugins['block']['fbvFormSection'][0][0]->smartyFBVFormSection($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			<?php echo $this->_plugins['function']['fbvElement'][0][0]->smartyFBVElement(array('type' => 'text','label' => "plugins.generic.staticPages.path",'id' => 'path','value' => $this->_tpl_vars['path'],'maxlength' => '40','inline' => true,'size' => $this->_tpl_vars['fbvStyles']['size']['MEDIUM']), $this);?>

			<?php echo $this->_plugins['function']['fbvElement'][0][0]->smartyFBVElement(array('type' => 'text','label' => "plugins.generic.staticPages.pageTitle",'id' => 'title','value' => $this->_tpl_vars['title'],'maxlength' => '255','inline' => true,'multilingual' => true,'size' => $this->_tpl_vars['fbvStyles']['size']['MEDIUM']), $this);?>

		<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fbvFormSection'][0][0]->smartyFBVFormSection($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		<?php $this->_tag_stack[] = array('fbvFormSection', array()); $_block_repeat=true;$this->_plugins['block']['fbvFormSection'][0][0]->smartyFBVFormSection($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			<?php ob_start(); ?><?php echo ((is_array($_tmp=$this->_plugins['function']['url'][0][0]->smartyUrl(array('router' => @ROUTE_PAGE,'context' => $this->_tpl_vars['currentContext']->getPath(),'page' => 'REPLACEME'), $this))) ? $this->_run_mod_handler('replace', true, $_tmp, 'REPLACEME', "%PATH%") : smarty_modifier_replace($_tmp, 'REPLACEME', "%PATH%"));?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('exampleUrl', ob_get_contents());ob_end_clean(); ?>
			<?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.generic.staticPages.viewInstructions",'pagesPath' => $this->_tpl_vars['exampleUrl']), $this);?>

		<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fbvFormSection'][0][0]->smartyFBVFormSection($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		<?php $this->_tag_stack[] = array('fbvFormSection', array('label' => "plugins.generic.staticPages.content",'for' => 'content')); $_block_repeat=true;$this->_plugins['block']['fbvFormSection'][0][0]->smartyFBVFormSection($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			<?php echo $this->_plugins['function']['fbvElement'][0][0]->smartyFBVElement(array('type' => 'textarea','multilingual' => true,'name' => 'content','id' => 'content','value' => $this->_tpl_vars['content'],'rich' => true,'height' => $this->_tpl_vars['fbvStyles']['height']['TALL'],'variables' => $this->_tpl_vars['allowedVariables']), $this);?>

		<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fbvFormSection'][0][0]->smartyFBVFormSection($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fbvFormArea'][0][0]->smartyFBVFormArea($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
	<?php $this->_tag_stack[] = array('fbvFormSection', array('class' => 'formButtons')); $_block_repeat=true;$this->_plugins['block']['fbvFormSection'][0][0]->smartyFBVFormSection($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		<?php echo $this->_plugins['function']['fbvElement'][0][0]->smartyFBVElement(array('type' => 'button','class' => 'pkp_helpers_align_left','id' => 'previewButton','label' => "common.preview"), $this);?>

		<?php $this->assign('buttonId', ((is_array($_tmp=((is_array($_tmp='submitFormButton')) ? $this->_run_mod_handler('concat', true, $_tmp, "-") : $this->_plugins['modifier']['concat'][0][0]->smartyConcat($_tmp, "-")))) ? $this->_run_mod_handler('uniqid', true, $_tmp) : uniqid($_tmp))); ?>
		<?php echo $this->_plugins['function']['fbvElement'][0][0]->smartyFBVElement(array('type' => 'submit','class' => 'submitFormButton','id' => $this->_tpl_vars['buttonId'],'label' => "common.save"), $this);?>

	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fbvFormSection'][0][0]->smartyFBVFormSection($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</form>