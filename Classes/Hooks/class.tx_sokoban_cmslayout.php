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
class tx_sokoban_cmslayout implements tx_cms_layout_tt_content_drawItemHook  {
	var $pObj;
	/**
	 * Preprocesses the preview rendering of a content element.
	 *
	 * @param	tx_cms_layout		$parentObject: Calling parent object
	 * @param	boolean				$drawItem: Whether to draw the item using the default functionalities
	 * @param	string				$headerContent: Header content
	 * @param	string				$itemContent: Item content
	 * @param	array				$row: Record row of tt_content
	 * @return	void
	 */
	public function preProcess(tx_cms_layout &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row){
		$this->pObj = $parentObject;
		$tsParser = new t3lib_TSparser();
		$tsParser->parse($parentObject->pageRecord['TSconfig']);
		$pageTSconfig = $tsParser->setup;
		if($pageTSconfig['SOKOBAN.']['isLevel']==1){			
			if($row['colPos']==1){
				$GLOBALS['SOBE']->doc->JScodeLibArray[] = '<script type="text/javascript" src="'.$GLOBALS['BACK_PATH'].'../typo3conf/ext/sokoban/Resources/Public/Javascript/sokoban.js"></script>';
				$GLOBALS['SOBE']->doc->styleSheetFile2 = $GLOBALS['BACK_PATH'].'../typo3conf/ext/sokoban/Resources/Public/Css/sokoban.css';	
				if(t3lib_div::_GP('sokobanSkipAnimation')==1){
					$GLOBALS['SOBE']->doc->JScodeLibArray[] = '<script type="text/javascript">sokobanSkipAnimation = 1;</script>';
				}
			}
			if($row['header'] == '@' || $row['header'] == '+'){//player
				$controls = $this->letTheDragonsFly($row);
				$GLOBALS['SOBE']->doc->JScodeLibArray[] = '<script type="text/javascript">sokobanControls = "'.str_replace(array("\n\r", "\n", "\r"), '', str_replace('"', '\"', $controls)).'";</script>';
			}
		}
	}
	
	public function letTheDragonsFly($row){
		$tsParser = new t3lib_TSparser();
		$backendLayoutRecord = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'backend_layout', 'pid='.$row['pid']);		
		$tsParser->parse($backendLayoutRecord[0]['config']);
		$backendLayout = $tsParser->setup;
		$player['x'] = $row['colPos'] % $backendLayout['backend_layout.']['colCount'];
		$player['y'] = ceil($row['colPos'] / $backendLayout['backend_layout.']['colCount']);
		$player['row'] = array(
			'uid' => $row['uid'],
			'pid' => $row['pid'],
			'colPos' => $row['colPos'],
			'header' => $row['header'],
		);
		$move['up'] = array();
		$this->createMove($player, 'up', $backendLayout, $move['up']);
		$move['right'] = array();
		$this->createMove($player, 'right', $backendLayout, $move['right']);
		$move['down'] = array();
		$this->createMove($player, 'down', $backendLayout, $move['down']);
		$move['left'] = array();
		$this->createMove($player, 'left', $backendLayout, $move['left']);
		//t3lib_div::debug($move);
		return $this->createControls($move);
	}
	public function createControls($moves){
		$controls = '';
		
		if(t3lib_div::_GP('sokobanSkipAnimation')!=1){
			$controls .= '<h4 onclick="sokobanSkipAnimation=true; this.style.display=\'none\';" style="color: red; cursor: pointer">Skip animation!</h4>';
		}
		
		$controls .= '<div id="sokoban-controller"><h4>Sokoban Controller</h4>';
		foreach($moves as $direction => $move){
			$data = '';
			if(count($move)>0 && count($move)<4){
				foreach($move as $uid => $record){
					foreach($record['row'] as $field => $value){
						$data .= '&data[tt_content]['.$uid.']['.$field.']='.urlencode($value);
					}
				}				
				$controls .= '
					<a href="'.$GLOBALS['BACK_PATH'].'tce_db.php?
						redirect='.urlencode(t3lib_div::getIndpEnv('SCRIPT_NAME').'?id='.$this->pObj->id.'&sokobanSkipAnimation=1').'
						&vC=' . $GLOBALS['BE_USER']->veriCode() . t3lib_BEfunc::getUrlToken('tceAction') . '
						&prErr=1
						&uPT=1'.
						$data
						.'" class="sokoban-controls-'.$direction.'">'.$direction.'</a>
';
			}
		}
		$controls .= '</div>';
		
		$controls .= '
			<div id="sokoban-legend"><h4>Sokoban Legend</h4>
			<div class="sokoban-wall" style="width: 50px; height: 50px;">Wall #</div><br class="sokoban-clearfix" />
			<div class="sokoban-left sokoban-player" style="width: 50px; height: 50px;">Player @</div>
			<div class="sokoban-left sokoban-playergoal" style="width: 50px; height: 50px;">Player on goal +</div>
			<div class="sokoban-left sokoban-box" style="width: 50px; height: 50px;">Box $</div>
			<div class="sokoban-left sokoban-boxgoal" style="width: 50px; height: 50px;">Box on goal *</div>
			<div class="sokoban-left sokoban-goal" style="width: 50px; height: 50px;">Goal .</div></div>';
		return $controls;
	}
	public function createMove($field, $direction, $backendLayout, &$updatedFields){
		$neighbourCoords = $this->getNeighbourCoords($field, $direction);
		if($neighbourCoords['x']>0 
				&& $neighbourCoords['x']<=$backendLayout['backend_layout.']['colCount']
				&& $neighbourCoords['y']>0
				&& $neighbourCoords['y']<=$backendLayout['backend_layout.']['rowCount']){//nachbarfeld ist im spielfeld					
			$neighbourField = $this->getField($neighbourCoords, $backendLayout);			
			if($neighbourField['row']['header']!='#'){//nachbarfeld ist keine wand
				$fieldHeader = $field['row']['header'];
				$neighbourFieldHeader = $neighbourField['row']['header'];
				$field['row']['header'] = $this->createFieldType($fieldHeader, ' ');
				$neighbourField['row']['header'] = $this->createFieldType($neighbourFieldHeader, $fieldHeader);
				$updatedFields[$field['row']['uid']] = $field;
				$updatedFields[$neighbourField['row']['uid']] = $neighbourField;				
							
				if($neighbourFieldHeader=='$'
						|| $neighbourFieldHeader=='*'){//nachbarfeld ist eine box
					$nextNeighbourCoords = $this->getNeighbourCoords($neighbourField, $direction);
					$nextNeighbourField = $this->getField($nextNeighbourCoords, $backendLayout);
					if($nextNeighbourField['row']['header']!='#'//next nachbarfeld ist keine wand
						&& ($nextNeighbourField['row']['header']!='$'
								&& $nextNeighbourField['row']['header']!='*')){//next nachbarfeld ist keine box
						$nextNeighbourFieldHeader = $nextNeighbourField['row']['header'];
						$nextNeighbourField['row']['header'] = $this->createFieldType($nextNeighbourFieldHeader, $neighbourFieldHeader);
						$updatedFields[$nextNeighbourField['row']['uid']] = $nextNeighbourField;	
					} else {
						$updatedFields = array();
					}
				}
			} else {
				$updatedFields = array();
			}
		} else {
			$updatedFields = array();
		}
	} 
	public function createFieldType($field, $overlay){
		if($overlay == '@' || $overlay == '+'){
			if($field == '.' || $field == '*'){
				$fieldType = '+';
			} elseif($field == ' ' || $field == '$'){
				$fieldType = '@';
			}
		} elseif($overlay == '$' || $overlay == '*'){
			if($field == '.'){
				$fieldType = '*';
			} elseif($field == ' '){
				$fieldType = '$';
			}
		} elseif($overlay == ' '){
			if($field == '@'){
				$fieldType = ' ';
			} elseif($field == '+'){
				$fieldType = '.';
			}
		}
		return $fieldType;
	}
	public function getNeighbourCoords($field, $direction){
		switch($direction){
			case 'up':
				$neighbourCoords['x'] = $field['x'];
				$neighbourCoords['y'] = $field['y']-1;
				break;
			case 'right':
				$neighbourCoords['x'] = $field['x']+1;
				$neighbourCoords['y'] = $field['y'];
				break;
			case 'down':
				$neighbourCoords['x'] = $field['x'];
				$neighbourCoords['y'] = $field['y']+1;
				break;
			case 'left':
				$neighbourCoords['x'] = $field['x']-1;
				$neighbourCoords['y'] = $field['y'];
				break;
		}
		return $neighbourCoords;
	}
	public function getField($coords, $backendLayout){
		$colPos = (($coords['y']-1) * $backendLayout['backend_layout.']['colCount'])+$coords['x'];
		$fieldRow = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid,pid,colPos,header', 'tt_content', 'colPos='.$colPos.' AND pid='.$this->pObj->id);	
		//t3lib_div::debug($fieldRow);	
		return array('x'=>$coords['x'], 'y'=>$coords['y'], 'row'=>$fieldRow[0]);
	}
}
?>