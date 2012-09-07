//////////////////////////////////////////////////////
// Class: Cell										//
// Description:  This will create a cell object		// 
// (board square) that you can reference from the 	//
// game. 											//
// Arguments:										//
//		size - tell the object it's width & height	//
//		??
//		??
//		??
//		??
//////////////////////////////////////////////////////
	
	
// Cell constructor
function Cell(myParent, id, size, col, row) {
	this.parent = myParent;
	this.id = id;
	this.size = size;
	this.col = col;
	this.row = row;
	//initialize the other instance vars
	this.occupied = '';
	this.state = 'alive';
	this.x = this.col * this.size;
	this.y = this.row * this.size;
	//this.color = (((this.row+this.col)%2) == 0) ? 'black' : 'white'
	this.color = 'white';
	this.droppable = (((this.row+this.col)%2) == 0) ? true : false
	
	//create it...
	this.object = this.createIt();
	
	this.object.addEventListener('click',function(){ dropCheck(col);},false)
	
	this.parent.appendChild(this.object);
	this.myBBox = this.getMyBBox();
	
}

//////////////////////////////////////////////////////
// Cell : Methods									//
// Description:  All of the methods for the			// 
// Cell Class (remember WHY we want these to be		//
// seperate from the object constructor!)			//
//////////////////////////////////////////////////////
//create it...
Cell.prototype.createIt = function(){
	
	var col = this.col;
	var gEle=document.createElementNS(svgns,'g');
	gEle.setAttributeNS(null,'transform','translate('+this.x+','+this.y+')');
	gEle.setAttributeNS(null,'id',this.id);
	gEle.setAttributeNS(null,'class','cell');
	
	var rect = document.createElementNS(svgns,'rect');
	//rect.setAttributeNS(null,'id',this.id);
	rect.setAttributeNS(null,'width',this.size+'px');
	rect.setAttributeNS(null,'height',this.size+'px');
	rect.setAttributeNS(null,'x',0+'px');
	rect.setAttributeNS(null,'y',0+'px');
	rect.setAttributeNS(null,'class','cell_'+'black');
	
	var circ = document.createElementNS(svgns,'circle');
	//circ.setAttributeNS(null,'id',this.id);
	circ.setAttributeNS(null,'r',((this.size/2) - 10)+'px');
	circ.setAttributeNS(null,'cx',(this.size/2)+'px');
	circ.setAttributeNS(null,'cy',(this.size/2)+'px');
	circ.setAttributeNS(null,'class','cell_'+'white');
	
	gEle.appendChild(rect);
	gEle.appendChild(circ);
	/*gEle.onclick = function(){
		//alert(this.id);
		dropPiece(col);
		};*/
	return gEle;
}

//get my BBox
Cell.prototype.getMyBBox = function(){
	return this.object.getBBox();
}

//get my center x
Cell.prototype.getCenterX = function(){
	return (BOARDX + this.x + (this.size/2));
}

//get my center y
Cell.prototype.getCenterY = function(){
	return (BOARDY + this.y + (this.size/2));
}

//set me to occupied...
Cell.prototype.isOccupied = function(pieceId){
	this.occupied = pieceId;
	//for testing purposes only!
	this.changeFill('alert');
}

//set me to unoccupied...
Cell.prototype.notOccupied = function(){
	this.occupied = '';
	//for testing purposes only!
	this.changeFill(this.color);
}

//for testing purposes only!
//to 'see' if the current cell is being 'filled' correctly with the new piece!
Cell.prototype.changeFill=function(toWhat){
	document.getElementById(this.id).setAttributeNS(null,'class','cell_'+toWhat);
}