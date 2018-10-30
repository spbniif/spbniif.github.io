<?php /* Smarty version 2.6.25-dev, created on 2018-10-22 13:12:38
         compiled from frontend/objects/issue_toc.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'frontend/objects/issue_toc.tpl', 26, false),)), $this); ?>
<div class="issue-toc">

	<?php $_from = $this->_tpl_vars['publishedArticles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sections'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sections']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['section']):
        $this->_foreach['sections']['iteration']++;
?>
		<div class="issue-toc-section">
			<?php if ($this->_tpl_vars['section']['articles']): ?>
				<?php if ($this->_tpl_vars['section']['title']): ?>
					<<?php echo $this->_tpl_vars['sectionHeading']; ?>
 class="issue-toc-section-title"><?php echo ((is_array($_tmp=$this->_tpl_vars['section']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?>
</<?php echo $this->_tpl_vars['sectionHeading']; ?>
>
				<?php endif; ?>
				<?php $_from = $this->_tpl_vars['section']['articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['article']):
?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/objects/article_summary.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<?php endforeach; endif; unset($_from); ?>
			<?php endif; ?>
		</div>
	<?php endforeach; endif; unset($_from); ?>
</div>