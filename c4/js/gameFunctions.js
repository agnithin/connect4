var xhtmlns = "http://www.w3.org/1999/xhtml";
var svgns = "http://www.w3.org/2000/svg";
var BOARDX = 50;				//starting pos of board
var BOARDY = 50;				//look above
var boardArr = new Array();		//2d array [row][col]
var pieceArr = new Array();		//2d array [player][piece] (player is either 0 or 1)
var BOARDWIDTH = 7;				//how many squares across
var BOARDHEIGHT = 7;			//how many squares down
var CELLSIZE = 75;
//the problem of dragging....
var myX;						//hold my last pos.
var myY;						//hold my last pos.
var mover='';					//hold the id of the thing I'm moving

function gameInit(){
	//create a parent to stick board in...
	var gEle=document.createElementNS(svgns,'g');
	gEle.setAttributeNS(null,'transform','translate('+BOARDX+','+BOARDY+')');
	gEle.setAttributeNS(null,'id','game_'+gameId);
	//stick g on board
	document.getElementsByTagName('svg')[0].insertBefore(gEle, document.getElementsByTagName('svg')[0].childNodes[5]);
	//create the board...
	
	//drawBoard(BOARDWIDTH, BOARDHEIGHT, CELLSIZE); // draw a blank rectangle
	
	//var x = new Cell(document.getElementById('someIDsetByTheServer'),'cell_00',75,0,0);
	for(i=0; i<BOARDWIDTH; i++){
		boardArr[i]=new Array();
		for(j=0; j<BOARDHEIGHT; j++){
			// syntax Cell(myParent, id, size, col, row)
			boardArr[i][j] = new Cell(document.getElementById('game_'+gameId), 'cell_'+j+i, CELLSIZE, j, i);
		}
	}
	
	//new Piece(board,player,cellRow,cellCol,type,num)
	//create red
	pieceArr[0]=new Array();

	
	//put the drop code on the document...
	//document.getElementsByTagName('svg')[0].addEventListener('mouseup', releaseMove, false);
	//put the go() method on the svg doc.
	//document.getElementsByTagName('svg')[0].addEventListener('mousemove', go, false);
	//put the player in the text
	//document.getElementById('youPlayer').firstChild.data+=player;
	//document.getElementById('opponentPlayer').firstChild.data+=player2;
	
	//document.getElementsByTagName('body').addEventListener('beforeunload', endGame, false);
	
	
	checkTurnAjax('checkTurn', gameId);
}
			
////get Transform/////
//	look at the id of the piece sent in and work on it's transform
////////////////
function getTransform(which){
	var hold=document.getElementById(which).getAttributeNS(null,'transform');
	var retVal=new Array();
	retVal[0]=hold.substring((hold.search(/\(/) + 1),hold.search(/,/));			//x value
	retVal[1]=hold.substring((hold.search(/,/) + 1),hold.search(/\)/));;		//y value
	return retVal;
}
			
////set Transform/////
//	look at the id, x, y of the piece sent in and set it's translate
////////////////
function setTransform(which,x,y){
	document.getElementById(which).setAttributeNS(null,'transform','translate('+x+','+y+')');
}

////change turn////
//	change who's turn it is
//////////////////
function changeTurn(){
	//locally, for the name color
	if(turn == 0){
		turn=1;
	}else{
		turn=0;
	}
	//how about for the server (and other player)?
	//send JSON message to server, have both clients monitor server to know who's turn it is...
	//document.getElementById('output2').firstChild.data='playerId '+playerId+ ' turn '+turn;
	changeServerTurnAjax('changeTurn',gameId);
}

/////////////////////////////////Messages to user/////////////////////////////////
////nytwarning (not your turn)/////
//	tell player it isn't his turn!
////////////////
function nytwarning(){
	if(document.getElementById('nyt').getAttributeNS(null,'display') == 'none'){
		document.getElementById('nyt').setAttributeNS(null,'display','inline');
		setTimeout('nytwarning()',2000);
	}else{
		document.getElementById('nyt').setAttributeNS(null,'display','none');
	}
}

////nypwarning (not your piece)/////
//	tell player it isn't his piece!
////////////////
function nypwarning(){
	if(document.getElementById('nyp').getAttributeNS(null,'display') == 'none'){
		document.getElementById('nyp').setAttributeNS(null,'display','inline');
		setTimeout('nypwarning()',2000);
	}else{
		document.getElementById('nyp').setAttributeNS(null,'display','none');
	}
}

/**************************** my new functions *****************************/
function dropCheck(col){
	//alert("t:"+turn+ " pid:"+playerId);
	if(turn == playerId){
		var hit=dropPiece(col);
	}else{
		var hit=false;
		nytwarning();
	}
	if(hit==true){
		//I'm on the square...
		//send the move to the server!!!
	}else{
		//move back
		//setTransform(mover,myX,myY)
	}
}

////dropPiece/////
//	on clicking on a cell creating a new piece
////////////////
function dropPiece(col){
	//alert(col);
	//Piece(board,player,cellRow,cellCol,type,num){
	var height = BOARDHEIGHT - 1;
	while(height >= 0)
	{
		//alert(boardArr[height][col].occupied);
		if(boardArr[height][col].occupied != '')
		{
			height--;
		}else{
			break;
		}
	}
	if(height>=0){
		pieceArr[0][pieceArr[0].length] = new Piece('game_'+gameId, playerId, height, col, 'Checker', pieceArr[0].length);
		
		//change other's board
		//alert(pieceArr[0][pieceArr[0].length - 1].id);
		changeBoardAjax(pieceArr[0][pieceArr[0].length - 1].id, pieceArr[0][pieceArr[0].length - 1].current_cell.row, pieceArr[0][pieceArr[0].length - 1].current_cell.col, 'changeBoard', gameId);
		
		//change who's turn it is
		changeTurn();
		return true;
	}
	return false;	
}

////gameOver/////
//	display gameover message
////////////////
function gameOver(status){
	if(status == 5){
	
		$( "#dialog-message-opponentLeft" ).dialog({
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
					window.location = "lobby.php";
				}
			}
		});	
	}else{	
		if((status - playerId) == 3){
			$("#gameOverText").text("Congrats you won the game.");
		}else{
			$("#gameOverText").text("Sorry you lost the game");
		}
		
		$( "#dialog-message-gameover" ).dialog({
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
					window.location = "lobby.php";
				}
			}
		});
	}			
}