<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Marco Huber <mail@marco-huber.de>
*  
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


/**
 *
 *
 * @package sokoban
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_Sokoban_Controller_PageController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * pageRepository
	 *
	 * @var Tx_Sokoban_Domain_Repository_PageRepository
	 */
	protected $pageRepository;
	/**
	 * contentElementRepository
	 *
	 * @var Tx_Sokoban_Domain_Repository_ContentElementRepository
	 */
	protected $contentElementRepository;
	/**
	 * backendLayoutRepository
	 *
	 * @var Tx_Sokoban_Domain_Repository_BackendLayoutRepository
	 */
	protected $backendLayoutRepository;
	/**
	 * persistenceManager
	 *
	 * @var Tx_Extbase_Persistence_Manager
	 */
	protected $persistenceManager;

	/**
	 * injectPageRepository
	 *
	 * @param Tx_Sokoban_Domain_Repository_PageRepository $pageRepository
	 * @return void
	 */
	public function injectPageRepository(Tx_Sokoban_Domain_Repository_PageRepository $pageRepository) {
		$this->pageRepository = $pageRepository;
	}
	/**
	 * injectContentElementRepository
	 *
	 * @param Tx_Sokoban_Domain_Repository_ContentElementRepository $contentElementRepository
	 * @return void
	 */
	public function injectContentElementRepository(Tx_Sokoban_Domain_Repository_ContentElementRepository $contentElementRepository) {
		$this->contentElementRepository = $contentElementRepository;
	}
	/**
	 * injectBackendLayoutRepository
	 *
	 * @param Tx_Sokoban_Domain_Repository_BackendLayoutRepository $backendLayoutRepository
	 * @return void
	 */
	public function injectBackendLayoutRepository(Tx_Sokoban_Domain_Repository_BackendLayoutRepository $backendLayoutRepository) {
		$this->backendLayoutRepository = $backendLayoutRepository;
	}
	/**
	 * injectPersistenceManager
	 *
	 * @param Tx_Extbase_Persistence_ManagerInterface $persistenceManager
	 * @return void
	 */
	public function injectPersistenceManager(Tx_Extbase_Persistence_ManagerInterface $persistenceManager) {
		$this->persistenceManager = $persistenceManager;
	}

	/**
	 * action new
	 *
	 * @return string The rendered new action
	 */
	public function newAction() {
		
	}

	/**
	 * action create
	 *
	 * @param integer $parentPageId
	 * @validate $parentPageId NotEmpty
	 * @validate $parentPageId Integer
	 * @param integer $limit
	 * @validate $limit Integer
	 * @return string The rendered create action
	 */
	public function createAction($parentPageId, $limit=999) {
		$levels = new SimpleXMLElement($this->processLevelFile());
		
		$levelTitel = (String) $levels->Title;
		$email = (String) $levels->Email;
		$attributes = $levels->LevelCollection->attributes();
		$copyright = (String) $attributes['Copyright'];
		
		$parentPage = $this->pageRepository->findByUid($parentPageId);
		
		$levelRootPage = new Tx_Sokoban_Domain_Model_Page();
		$levelRootPage->setTitle($levelTitel);
		$levelRootPage->setParentPage($parentPage);
		$levelRootPage->setPid($parentPageId);
		$this->pageRepository->add($levelRootPage);
		$this->persistenceManager->persistAll();
		
		$levelRootPageContent = new Tx_Sokoban_Domain_Model_ContentElement();
		$levelRootPageContent->setTitle('Copyright: '.$copyright.' E-Mail: '.$email);
		$levelRootPageContent->setCType('header');
		$levelRootPageContent->setParentPage($levelRootPage);
		$levelRootPageContent->setPid($levelRootPage->getUid());
		$this->contentElementRepository->add($levelRootPageContent);
		$this->persistenceManager->persistAll();
		
		$i = 0;
		foreach($levels->LevelCollection->Level as $level){
			$colPos = 1;
			if($i<$limit){
				$levelPage = new Tx_Sokoban_Domain_Model_Page();
				$levelPage->setTitle($levelTitel.' '.($i+1));
				$levelPage->setParentPage($levelRootPage);
				$levelPage->setPid($levelRootPage->getUid());		
				$this->pageRepository->add($levelPage);		
				$this->persistenceManager->persistAll();

				$attributes = $level->attributes();
				$height = (String) $attributes['Height'];
				$width = (String) $attributes['Width'];
				$backendLayoutConfig = '
				backend_layout {
					rowCount = '.$height.'
					colCount = '.$width.'
					rows {
				'; 
				$colPosList = array();
				for($r=1; $r<=$height; $r++){
					$backendLayoutConfig .= '
						'.$r.' {
							columns {
					';
					$rows = $level->children();
					$rowString = (String) $rows->L[($r-1)];
					$cols = str_split($rowString);
					for($c=1; $c<=$width; $c++){
						$backendLayoutConfig .= '
								'.$c.' {
									name = '.$r.' '.$c.'
									colPos = '.$colPos.'
								}
						';
						$colPosList[] = $colPos;
						$content = new Tx_Sokoban_Domain_Model_ContentElement();
						$content->setTitle(($cols[($c-1)]?$cols[($c-1)]:' '));
						$content->setCType('header');
						$content->setColPos($colPos);
						$content->setParentPage($levelPage);
						$content->setPid($levelPage->getUid());
						$this->contentElementRepository->add($content);	
						$this->persistenceManager->persistAll();

						$colPos++;
					}
					$backendLayoutConfig .= '
							}
						}
					';
				}
				$backendLayoutConfig .= '
					}
				}
				';			
				$backendLayout = new Tx_Sokoban_Domain_Model_BackendLayout();
				$backendLayout->setTitle($levelTitel.' '.($i+1));
				$backendLayout->setConfig($backendLayoutConfig);
				$backendLayout->setParentPage($levelPage);
				$backendLayout->setPid($levelPage->getUid());
				$this->backendLayoutRepository->add($backendLayout);
				$this->persistenceManager->persistAll();		

				$levelPage->setTsConfig('
					SOKOBAN.isLevel = 1
					mod.SHARED.colPos_list = '.implode(',', $colPosList).'
				');
				$levelPage->setBackendLayout($backendLayout);			
				$this->pageRepository->update($levelPage);	
				$this->persistenceManager->persistAll();		
			}
			$i++;
		}
		
		$this->flashMessageContainer->add('Your new Page was created.');
		
		$this->redirect('new');
	}
	
	public function processLevelFile(){
		$levelFile = t3lib_div::upload_to_tempfile($_FILES['tx_sokoban_tools_sokobancreatesokobanlevels']['tmp_name']['levelFile']);
		
		$levelFileContent = file_get_contents($levelFile);	
		
		t3lib_div::unlink_tempfile($levelFile);
		return $levelFileContent;
	}

}
?>