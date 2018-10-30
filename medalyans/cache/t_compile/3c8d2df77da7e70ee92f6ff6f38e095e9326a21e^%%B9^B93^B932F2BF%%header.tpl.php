<?php /* Smarty version 2.6.25-dev, created on 2018-10-27 18:18:48
         compiled from frontend/components/header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'frontend/components/header.tpl', 19, false),array('function', 'translate', 'frontend/components/header.tpl', 38, false),array('function', 'load_menu', 'frontend/components/header.tpl', 77, false),array('modifier', 'escape', 'frontend/components/header.tpl', 36, false),array('modifier', 'replace', 'frontend/components/header.tpl', 50, false),)), $this); ?>

<?php $this->assign('showingLogo', true); ?>
<?php if ($this->_tpl_vars['displayPageHeaderTitle'] && ! $this->_tpl_vars['displayPageHeaderLogo'] && is_string ( $this->_tpl_vars['displayPageHeaderTitle'] )): ?>
	<?php $this->assign('showingLogo', false); ?>
<?php endif; ?>

<?php ob_start(); ?>
	<?php if ($this->_tpl_vars['currentJournal'] && $this->_tpl_vars['multipleContexts']): ?>
		<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('page' => 'index','router' => @ROUTE_PAGE), $this);?>

	<?php else: ?>
		<?php echo $this->_plugins['function']['url'][0][0]->smartyUrl(array('context' => 'index','router' => @ROUTE_PAGE), $this);?>

	<?php endif; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('homeUrl', ob_get_contents());ob_end_clean(); ?>

<?php if ($this->_tpl_vars['requestedOp'] == 'index'): ?>
	<?php $this->assign('siteNameTag', 'h1'); ?>
<?php else: ?>
	<?php $this->assign('siteNameTag', 'div'); ?>
<?php endif; ?>

<?php ob_start(); ?><?php echo ''; ?><?php if ($this->_tpl_vars['displayPageHeaderLogo'] && is_array ( $this->_tpl_vars['displayPageHeaderLogo'] )): ?><?php echo '<img src="'; ?><?php echo $this->_tpl_vars['publicFilesDir']; ?><?php echo '/'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['displayPageHeaderLogo']['uploadName'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp, 'url')); ?><?php echo '"'; ?><?php if ($this->_tpl_vars['displayPageHeaderLogo']['altText'] != ''): ?><?php echo 'alt="'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['displayPageHeaderLogo']['altText'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?><?php echo '"'; ?><?php else: ?><?php echo 'alt="'; ?><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "common.pageHeaderLogo.altText"), $this);?><?php echo '"'; ?><?php endif; ?><?php echo '>'; ?><?php elseif ($this->_tpl_vars['displayPageHeaderTitle'] && ! $this->_tpl_vars['displayPageHeaderLogo'] && is_string ( $this->_tpl_vars['displayPageHeaderTitle'] )): ?><?php echo '<span class="navbar-logo-text">'; ?><?php echo $this->_tpl_vars['displayPageHeaderTitle']; ?><?php echo '</span>'; ?><?php elseif ($this->_tpl_vars['displayPageHeaderTitle'] && ! $this->_tpl_vars['displayPageHeaderLogo'] && is_array ( $this->_tpl_vars['displayPageHeaderTitle'] )): ?><?php echo '<img src="'; ?><?php echo $this->_tpl_vars['publicFilesDir']; ?><?php echo '/'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['displayPageHeaderTitle']['uploadName'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp, 'url')); ?><?php echo '"alt="'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['displayPageHeaderTitle']['altText'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?><?php echo '">'; ?><?php else: ?><?php echo '<img src="'; ?><?php echo $this->_tpl_vars['baseUrl']; ?><?php echo '/templates/images/structure/logo.png" alt="'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['applicationName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp)); ?><?php echo '">'; ?><?php endif; ?><?php echo ''; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('brand', ob_get_contents());ob_end_clean(); ?>

<!DOCTYPE html>
<html lang="<?php echo ((is_array($_tmp=$this->_tpl_vars['currentLocale'])) ? $this->_run_mod_handler('replace', true, $_tmp, '_', "-") : smarty_modifier_replace($_tmp, '_', "-")); ?>
" xml:lang="<?php echo ((is_array($_tmp=$this->_tpl_vars['currentLocale'])) ? $this->_run_mod_handler('replace', true, $_tmp, '_', "-") : smarty_modifier_replace($_tmp, '_', "-")); ?>
">
<?php if (! $this->_tpl_vars['pageTitleTranslated']): ?><?php ob_start(); ?><?php echo $this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => $this->_tpl_vars['pageTitle']), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('pageTitleTranslated', ob_get_contents());ob_end_clean(); ?><?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/headerHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>

<header class="main-header">
	<div class="container">

		<<?php echo $this->_tpl_vars['siteNameTag']; ?>
 class="sr-only"><?php echo $this->_tpl_vars['pageTitleTranslated']; ?>
</<?php echo $this->_tpl_vars['siteNameTag']; ?>
>

	<div class="navbar-logo">
		<a href="<?php echo $this->_tpl_vars['homeUrl']; ?>
"><?php echo $this->_tpl_vars['brand']; ?>
</a>
	</div>

		<nav class="navbar navbar-expand-lg navbar-light">
		<a class="navbar-brand" href="<?php echo $this->_tpl_vars['homeUrl']; ?>
"><?php echo $this->_tpl_vars['brand']; ?>
</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar"
		        aria-controls="main-navbar" aria-expanded="false"
		        aria-label="<?php echo ((is_array($_tmp=$this->_plugins['function']['translate'][0][0]->smartyTranslate(array('key' => "plugins.themes.healthSciences.nav.toggle"), $this))) ? $this->_run_mod_handler('escape', true, $_tmp) : $this->_plugins['modifier']['escape'][0][0]->smartyEscape($_tmp));?>
">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse justify-content-md-center" id="main-navbar">
						<?php ob_start(); ?>
				<?php echo $this->_plugins['function']['load_menu'][0][0]->smartyLoadNavigationMenuArea(array('name' => 'primary','id' => 'primaryNav','ulClass' => "navbar-nav",'liClass' => "nav-item"), $this);?>

			<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('primaryMenu', ob_get_contents());ob_end_clean(); ?>
			<?php if (! empty ( trim ( $this->_tpl_vars['primaryMenu'] ) ) || $this->_tpl_vars['currentContext']): ?>
				<?php echo $this->_tpl_vars['primaryMenu']; ?>

			<?php endif; ?>
						<?php echo $this->_plugins['function']['load_menu'][0][0]->smartyLoadNavigationMenuArea(array('name' => 'user','id' => "primaryNav-userNav",'ulClass' => "navbar-nav",'liClass' => "nav-item"), $this);?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/languageSwitcher.tpl", 'smarty_include_vars' => array('id' => 'languageSmallNav')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
	</nav>

		<?php echo $this->_plugins['function']['load_menu'][0][0]->smartyLoadNavigationMenuArea(array('name' => 'user','id' => 'userNav','ulClass' => "navbar-nav",'liClass' => "nav-item"), $this);?>


		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frontend/components/languageSwitcher.tpl", 'smarty_include_vars' => array('id' => 'languageLargeNav')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	</div>
</header>