var sokobanSkipAnimation,
	sokobanControls,
	gridTable,
	gridCell,
	ceBody,
	rowHeader,
	colHeader,
	colHeaderIcons,
	colHeaderLabel,
	contentElement,
	contentElementHeader,
	contentElementType;
function getBackgroundColor(){
	ceBody.select('div strong a').each(function(element){
		ceBodyContent = element;
		ceBodyContent.setStyle('display', 'none');
		ceBodyContentText = Ext.getDom(ceBodyContent).innerHTML;
		switch(ceBodyContentText){
			case '#': //Wall
				cssclass =  'sokoban-wall';
				break;
			case '@': //Player
			case '+': //Player on goal
				if(ceBodyContentText == '@'){
					cssclass = 'sokoban-player';
				} else {
					cssclass = 'sokoban-playergoal';
				}
				break;
			case '$': //Box
				cssclass = 'sokoban-box';
				break;
			case '*': //Box on goal
				cssclass = 'sokoban-boxgoal';
				break;
			case '.': //Goal
				cssclass = 'sokoban-goal';
				break;
			default: //Free
				cssclass = 'sokoban-free';
				break;
		}
	});
	return cssclass;
}
function cleanLayoutRecursive(gridCell){
	if(sokobanSkipAnimation == 1){
		cleanLayout();
	} else {	
		gridCell.select('.t3-page-colHeader-label').each(function(element){
			colHeaderLabel = element;
			colHeaderLabel.hide({
				duration: 0,
				callback: function(){
					colHeaderLabel.setStyle('display', 'none');
				}
			});
		});
		gridCell.select('.t3-page-colHeader-icons').each(function(element){
			colHeaderIcons = element;
			colHeaderIcons.hide({
				duration: 0,
				callback: function(){
					colHeaderIcons.setStyle('display', 'none');	
					gridCell.select('.t3-page-rowHeader').each(function(element){
						rowHeader = element;
						rowHeader.setStyle('margin', 0);
						rowHeader.setStyle('padding', 0);
						rowHeader.setStyle('width', 0);
						rowHeader.setStyle('height', 0);					
					});
					gridCell.select('.t3-page-colHeader').each(function(element){
						colHeader = element;
						colHeader.setStyle('margin', 0);
						colHeader.setStyle('padding', 0);
						colHeader.animate(
							{
								width: {to: 0, from: colHeader.getWidth()},
								height: {to: 0, from: colHeader.getHeight()}
							},
							0,
							function(){
								colHeader.setStyle('width', 0);
								colHeader.setStyle('height', 0);
							},
							'easeOut',
							'run'					
						);
					});

				}
			});
		});
		gridCell.select('.t3-page-ce').each(function(element){
			contentElement = element;
			contentElement.setStyle('margin', 0);
			contentElement.setStyle('padding', 0);													
		});
		gridCell.select('.t3-page-ce-header').each(function(element){
			contentElementHeader = element;
			contentElementHeader.hide({
				duration: 0,
				callback: function(){
					contentElementHeader.setStyle('display', 'none');				
				}
			});														
		});	
		gridCell.select('.t3-page-ce-type').each(function(element){
			contentElementType = element;
			contentElementType.hide({
				duration: 0,
				callback: function(){
					contentElementType.setStyle('display', 'none');	
					gridCell.select('.t3-page-ce-body').each(function(element){
						ceBody = element;
						ceBody.setStyle('margin', 0);
						ceBody.setStyle('padding', 0);
						ceBody.animate(
							{
								width: {to: 50, from: ceBody.getHeight()}, 
								height: {to: 50, from: ceBody.getHeight()}
							},
							0,
							function(){
								ceBody.addClass(getBackgroundColor());				
								gridCell.setStyle('maxWidth', '50px');
								gridCell.setStyle('minWidth', '50px');
								gridCell.setStyle('width', 50);
								gridCell.setStyle('height', 50);
								gridCell.setStyle('overflow', 'hidden');
								if(Ext.get(gridCell).next('.t3-gridCell')){
									cleanLayoutRecursive(Ext.get(gridCell).next('.t3-gridCell'));
								} else {
									if(Ext.get(gridCell).parent('tr').next('tr')){
										Ext.get(gridCell).parent('tr').next('tr').select('.t3-gridCell:first').each(function(element){
											cleanLayoutRecursive(element);
										});
									}
								}
							},
							'easeOut',
							'run'					
						);
					});
				}
			});														
		});	
	}
}
function cleanLayout(){	
	Ext.select('.t3-gridTable').each(function(element){
		gridTable = element;
		gridTable.setStyle('width', 'auto');
		gridTable.setStyle('height', 'auto');
		if(sokobanSkipAnimation == 1){
			gridTable.addClass('sokoban-skip-animation');
			Ext.select('.t3-page-ce-body').each(function(element){
				ceBody = element;
				ceBody.addClass(getBackgroundColor());	
			});
		} else {
			element.select('.t3-gridCell:first').each(function(element){
				gridCell = element;
				cleanLayoutRecursive(gridCell);
			});			
		}
		
	});
}
function addControls(){	
	Ext.select('.t3-gridTable').each(function(element){
		element.addClass('sokoban-left');
		element.parent('.t3-gridContainer').addClass('sokoban-clearfix');
		
		Ext.DomHelper.insertBefore(element, {tag: 'div', id: 'sokoban-controls', class: 't3-page-ce'});
		Ext.getDom('sokoban-controls').innerHTML = sokobanControls;
		Ext.get('sokoban-controls').addClass('sokoban-left');
	});
}

Ext.onReady(function() {	
	addControls();
	cleanLayout();
});