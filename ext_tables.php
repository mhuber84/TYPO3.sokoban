<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}



if (TYPO3_MODE === 'BE') {

	/**
	* Registers a Backend Module
	*/
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'tools',	 // Make module a submodule of 'tools'
		'createsokobanlevels',	// Submodule key
		'',						// Position
		array(
			'Page' => 'new, create',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_createsokobanlevels.xml',
		)
	);
	
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][] = 'EXT:sokoban/Classes/Hooks/class.tx_sokoban_cmslayout.php:tx_sokoban_cmslayout';

}


t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Sokoban');

?>