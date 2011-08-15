<?php

########################################################################
# Extension Manager/Repository config file for ext "sokoban".
#
# Auto generated 15-08-2011 17:22
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Sokoban',
	'description' => 'Play Sokoban in TYPO3',
	'category' => 'module',
	'author' => 'Marco Huber',
	'author_email' => 'mail@marco-huber.de',
	'author_company' => '',
	'shy' => '',
	'dependencies' => 'cms,extbase,fluid',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.0.1',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'extbase' => '',
			'fluid' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:35:{s:21:"ExtensionBuilder.json";s:4:"31a2";s:12:"ext_icon.gif";s:4:"e922";s:14:"ext_tables.php";s:4:"5bf4";s:14:"ext_tables.sql";s:4:"d41d";s:37:"Classes/Controller/PageController.php";s:4:"77ba";s:38:"Classes/Domain/Model/BackendLayout.php";s:4:"3b36";s:39:"Classes/Domain/Model/ContentElement.php";s:4:"c812";s:29:"Classes/Domain/Model/Page.php";s:4:"cd33";s:53:"Classes/Domain/Repository/BackendLayoutRepository.php";s:4:"976e";s:54:"Classes/Domain/Repository/ContentElementRepository.php";s:4:"ec09";s:44:"Classes/Domain/Repository/PageRepository.php";s:4:"b096";s:44:"Classes/Hooks/class.tx_sokoban_cmslayout.php";s:4:"b37c";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"5f5f";s:38:"Configuration/TypoScript/constants.txt";s:4:"9375";s:34:"Configuration/TypoScript/setup.txt";s:4:"e006";s:46:"Resources/Private/Backend/Layouts/Default.html";s:4:"c979";s:50:"Resources/Private/Backend/Partials/FormErrors.html";s:4:"993c";s:55:"Resources/Private/Backend/Partials/Page/FormFields.html";s:4:"3e07";s:49:"Resources/Private/Backend/Templates/Page/New.html";s:4:"88d2";s:40:"Resources/Private/Language/locallang.xml";s:4:"fb43";s:60:"Resources/Private/Language/locallang_createsokobanlevels.xml";s:4:"a473";s:82:"Resources/Private/Language/locallang_csh_tx_sokoban_domain_model_backendlayout.xml";s:4:"fac4";s:83:"Resources/Private/Language/locallang_csh_tx_sokoban_domain_model_contentelement.xml";s:4:"81c9";s:73:"Resources/Private/Language/locallang_csh_tx_sokoban_domain_model_page.xml";s:4:"5788";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"a04f";s:32:"Resources/Public/Css/sokoban.css";s:4:"5b5a";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:64:"Resources/Public/Icons/tx_sokoban_domain_model_backendlayout.gif";s:4:"1103";s:65:"Resources/Public/Icons/tx_sokoban_domain_model_contentelement.gif";s:4:"1103";s:55:"Resources/Public/Icons/tx_sokoban_domain_model_page.gif";s:4:"905a";s:38:"Resources/Public/Javascript/sokoban.js";s:4:"1eba";s:45:"Tests/Unit/Domain/Model/BackendLayoutTest.php";s:4:"f025";s:46:"Tests/Unit/Domain/Model/ContentElementTest.php";s:4:"b647";s:36:"Tests/Unit/Domain/Model/PageTest.php";s:4:"b4f1";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

?>