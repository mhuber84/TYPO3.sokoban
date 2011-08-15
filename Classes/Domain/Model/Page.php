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
class Tx_Sokoban_Domain_Model_Page extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * tsConfig
	 *
	 * @var string
	 */
	protected $tsConfig;

	/**
	 * parentPage
	 *
	 * @var Tx_Sokoban_Domain_Model_Page
	 */
	protected $parentPage;

	/**
	 * backendLayout
	 *
	 * @var Tx_Sokoban_Domain_Model_BackendLayout
	 */
	protected $backendLayout;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * Returns the tsConfig
	 *
	 * @return string $tsConfig
	 */
	public function getTsConfig() {
		return $this->tsConfig;
	}

	/**
	 * Sets the tsConfig
	 *
	 * @param string $tsConfig
	 * @return void
	 */
	public function setTsConfig($tsConfig) {
		$this->tsConfig = $tsConfig;
		return $this;
	}

	/**
	 * Returns the parentPage
	 *
	 * @return Tx_Sokoban_Domain_Model_Page $parentPage
	 */
	public function getParentPage() {
		return $this->parentPage;
	}

	/**
	 * Sets the parentPage
	 *
	 * @param Tx_Sokoban_Domain_Model_Page $parentPage
	 * @return void
	 */
	public function setParentPage(Tx_Sokoban_Domain_Model_Page $parentPage) {
		$this->parentPage = $parentPage;
		return $this;
	}

	/**
	 * Returns the backendLayout
	 *
	 * @return Tx_Sokoban_Domain_Model_BackendLayout $backendLayout
	 */
	public function getBackendLayout() {
		return $this->backendLayout;
	}

	/**
	 * Sets the backendLayout
	 *
	 * @param Tx_Sokoban_Domain_Model_BackendLayout $backendLayout
	 * @return void
	 */
	public function setBackendLayout(Tx_Sokoban_Domain_Model_BackendLayout $backendLayout) {
		$this->backendLayout = $backendLayout;
		return $this;
	}

}
?>