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
*  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_Sokoban_Domain_Model_Page.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Sokoban
 *
 * @author Marco Huber <mail@marco-huber.de>
 */
class Tx_Sokoban_Domain_Model_PageTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Sokoban_Domain_Model_Page
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Sokoban_Domain_Model_Page();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	
	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getTsConfigReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTsConfigForStringSetsTsConfig() { 
		$this->fixture->setTsConfig('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTsConfig()
		);
	}
	
	/**
	 * @test
	 */
	public function getParentPageReturnsInitialValueForTx_Sokoban_Domain_Model_Page() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getParentPage()
		);
	}

	/**
	 * @test
	 */
	public function setParentPageForTx_Sokoban_Domain_Model_PageSetsParentPage() { 
		$dummyObject = new Tx_Sokoban_Domain_Model_Page();
		$this->fixture->setParentPage($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getParentPage()
		);
	}
	
	/**
	 * @test
	 */
	public function getBackendLayoutReturnsInitialValueForTx_Sokoban_Domain_Model_BackendLayout() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getBackendLayout()
		);
	}

	/**
	 * @test
	 */
	public function setBackendLayoutForTx_Sokoban_Domain_Model_BackendLayoutSetsBackendLayout() { 
		$dummyObject = new Tx_Sokoban_Domain_Model_BackendLayout();
		$this->fixture->setBackendLayout($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getBackendLayout()
		);
	}
	
}
?>