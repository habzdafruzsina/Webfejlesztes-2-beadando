
function $(id) {
    return document.getElementById(id);
}

function init(){
	levelName = window.location.search.split("=")[1];
	loadLevel(levelName);
}

var levelName;
var level;
var actOutInterval;
var timeOut;

var fields = {
	
	fieldElements: "▩◼✹",
	turningEquipments: "↺↻",
	assemblyLines: "←↑→↓",
	assemblyLinesRight: "⮠⮣⮤⮧",
	assemblyLinesLeft: "⮡⮢⮥⮦",
	
	getType: function(c){
		switch(c) {
			case this.fieldElements[0]: return "floor";
				break;
			case this.fieldElements[1]: return "pit";
				break;
			case this.fieldElements[2]: return "damage";
				break;
			}
		if(this.turningEquipments.indexOf(c) != -1){
			return "turningEquipment";
		}	
		if(this.assemblyLines.indexOf(c) != -1 || this.assemblyLinesRight.indexOf(c) != -1 || this.assemblyLinesLeft.indexOf(c) != -1){
			return "assemblyLine";
		}
		if(directions.indexOf(c) != -1){
			return "startPoint";
		}
		return "";
	},
	
	isStartPoint: function(c){
		if(directions.indexOf(c) != -1){
			return true;
		} return false;
	}
}

var commandCollection = "⭢⮆⇶⬏⬎⮌⭠";
var directions = "⮘⮙⮚⮛";

var cards = [];
var cardsLength = 9;

var memory = {
	memorySize: 5,
	cards: [],
	
	isFull: function(){
		return (this.cards.length == this.memorySize);
	},
	
	isEmpty: function(){
		return this.cards.length == 0;
	},
	
	putCard: function(c){
		if(!this.isFull()){
			this.cards.push(c);
		} return false;
	},
	
	removeCard: function(){
		if(!this.isEmpty()){
			return this.cards.shift();
		} return false;
	}
	
}

var characterPosition = {
	i : 0,
	j : 0,
	direction : 0
}

var previousPosition = {
	i : 0,
	j : 0,
	direction : 0
}

var actions = [];
var timer;
var remainedTime;

/////////FUNCTIONS///////////

function loadLevel(levelName) { 
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'get.php?level='+levelName, true);
  xhr.addEventListener('readystatechange', function () {
	if (xhr.readyState == 4 && xhr.status == 200) {
		level = convertToJSO(this.responseText);
		startGame(level);
	}
  }, false);
  xhr.send(null);
}

function convertToJSO(string){
	var data = string.split(";");
	var boardString = data[0];
	var wallsString = data[1];
	var timeString = data[2];
	
	var boardArray = boardString.split(',');
	var wallsArray = JSON.parse(wallsString);

	var jso = {
		board: boardArray,
		walls: wallsArray,
		time: timeString
	}
	
	console.log(jso);
	return jso;
}

function startGame(level) {
	setupBoard(level);
	initCharacterPosition(level);
	initCards();
	$('cards').addEventListener('click', chooseCard, false);
	paintMemory();
	remainedTime = level.time;
	$('timer').innerHTML = "0:0";
	timer = setInterval(setRemainedTime, 1000);
	timeOut = setTimeout(timeIsOut, level.time);	
}

function setRemainedTime(){
	remainedTime = remainedTime - 1000;
	var minutes = Math.floor((remainedTime/1000) / 60);
	var seconds = Math.round((remainedTime/1000) - (minutes * 60));
	$('timer').innerHTML = minutes + ":" + seconds;
}

function setupBoard(level){
	var s = "";
	for(var i = 0; i < level.board.length; i++){
		s += "<tr>";
		for(var j = 0; j < level.board[i].length; j++){
			if (level.board[i][j] == "▩"){
				s += "<td class=\"" + fields.getType(level.board[i][j]) + "\">" + "</td>"
			} else {
				s += "<td class=\"" + fields.getType(level.board[i][j]) + "\">" + level.board[i][j] + "</td>";
			}
		}
		s += "</tr>";
	}
	$('board').innerHTML = s;
	paintWalls(level);
}

function paintWalls(level){
	for(var i = 0; i < level.walls.length; i++){
		$('board').rows[level.walls[i].i].cells[level.walls[i].j].classList.add("wall");
		$('board').rows[level.walls[i].i].cells[level.walls[i].j].classList.add(level.walls[i].side);
	}
}

function initCards(){
	for(var i = 0; i < cardsLength; i++){
		cards[i] = commandCollection[Math.floor(Math.random() * commandCollection.length)];
	}
	paintCards();
}

function initCharacterPosition(level){
	for(var i = 0; i < level.board.length; i++){
		for(var j = 0; j < level.board[i].length; j++){
			if(fields.isStartPoint(level.board[i][j])){
				characterPosition.i = i;
				characterPosition.j = j;
				characterPosition.direction = directions.indexOf(level.board[i][j]);
			}
		}
	} drawCharacter(level);
}

function paintCards(){
	var s = "";
	for(var i = 0; i < cardsLength; i++){
		s += "<td>" + cards[i] + "</td>";
	}
	$('cards').innerHTML = s;
}

function paintMemory(){
	var s = "<tr>";
	for(var i = 0; i < memory.memorySize; i++){
		s += (memory.cards[i] == undefined) ? "<td>" + "&nbsp;" + "</td>" : "<td>" + memory.cards[i] + "</td>";
	}
	$('memory').innerHTML = s + "</tr>";
}

function paintNextInMemory(){
	$('memory').rows[0].cells[Math.abs(memory.memorySize-memory.cards.length)-1].classList.add("applied");
}

function chooseCard(e){
	if (e.target.tagName === 'TD') {
		var index = e.target.cellIndex;
		if(!memory.isFull()){
			memory.putCard(cards[index]);
			newCard(index);
		}
		paintMemory();
	}
	if(memory.isFull()){
		clearTimeout(timeOut);
		clearInterval(timer);
		timeIsOut();
	}
}

function newCard(index){
	for(var i = index; i < cardsLength-1; i++){
		cards[i] = cards[i+1];
	}
	cards[cardsLength-1] = commandCollection[Math.floor(Math.random() * commandCollection.length)];
	paintCards();
}

function timeIsOut(){
	$('timer').innerHTML = "0:0";
	clearInterval(timer);
	completeMemory();
	paintMemory();
	$('cards').removeEventListener('click', chooseCard, false);
	actOut(level);
}

function completeMemory(){
	while(!memory.isFull()){
		memory.putCard(commandCollection[Math.floor(Math.random() * commandCollection.length)]);
	}
}

////FUNCTIONS FOR MOVING////

function actOut(level){
	actOutInterval = setInterval(function(){
		move(level);
	}, 500);
}

var steps = 0;
var canRotate = true;

function getNextCommand(){
	 var command = memory.removeCard();
		switch(command) {
		case "⭢": steps = 1;
			break;
		case "⮆": steps = 2;
			break;
		case "⇶": steps = 3;
			break;
		case "⭠": steps = 1;
			break;
		default: steps = (commandCollection.indexOf(command) + 1);
	}
	return command;
}

function move(level){
	var field;
	if(!isOutOfIndex(level)){
		field = level.board[characterPosition.i][characterPosition.j];
	}
	
	if(steps == 0 && !memory.isEmpty() && !isOutOfIndex(level)){
		var command = getNextCommand();
	} else if(steps == 0 && memory.isEmpty() && (fields.getType(field) == "floor" || fields.getType(field) == "startPoint" || fields.getType(field) == "turningEquipment")){
		continueTheGame(level);
		return;
	}

	if(fields.getType(field) != "floor" && fields.getType(field) != "startPoint" && canRotate){
		setDirection(field, level);
		if(fields.getType(field) == "assemblyLine"){
			push(field, level);
		} else if(fields.getType(field) == "turningEquipment"){
			canRotate = false;
		}
	} else if(steps >= 4){
		paintNextInMemory();
		setDirection(commandCollection[steps-1], level);
		steps = 0;
	} else if(isThereWall(command)){
		paintNextInMemory();
		steps--;
	} else if(steps != 0){
		paintNextInMemory();
		setDirection(command, level);
		step(command, level);
		steps--;
		canRotate = true;
	}

	if(isGameOver(level) || isWin(level)){
		clearInterval(actOutInterval);
		return;
	}
}

function continueTheGame(level){
	clearInterval(actOutInterval);
	paintMemory();
	$('cards').addEventListener('click', chooseCard, false);
	timeOut = setTimeout(timeIsOut, level.time);
	remainedTime = level.time;
	timer = setInterval(setRemainedTime, 1000);
}

function isThereWall(command){
	var direction;
	if(command == "⭠"){
		direction = directions[(characterPosition.direction+2)%(directions.length)];
	} else {
		direction = directions[characterPosition.direction];
	}
	
	var classTypeActual;
	var classTypeNext;
	var nextPosition = {
		i : 0,
		j : 0
	}
	
	switch(direction) {
		case "⮘": 
			classTypeActual = "left";
			classTypeNext = "right";
			nextPosition.i = characterPosition.i;
			nextPosition.j = characterPosition.j - 1;
			break;
		case "⮙": 
			classTypeActual = "top";
			classTypeNext = "bottom";
			nextPosition.i = characterPosition.i - 1;
			nextPosition.j = characterPosition.j;
			break;
		case "⮚":
			classTypeActual = "right";
			classTypeNext = "left";
			nextPosition.i = characterPosition.i;
			nextPosition.j = characterPosition.j + 1;
			break;
		case "⮛": 
			classTypeActual = "bottom";
			classTypeNext = "top";
			nextPosition.i = characterPosition.i + 1;
			nextPosition.j = characterPosition.j;
			break;
	}
	
	if($('board').rows[nextPosition.i] != undefined && $('board').rows[nextPosition.i].cells[nextPosition.j] != undefined){
		if($('board').rows[characterPosition.i].cells[characterPosition.j].classList.contains(classTypeActual) ||
		$('board').rows[nextPosition.i].cells[nextPosition.j].classList.contains(classTypeNext)){
			return true;
		}
		return false;
	}
	return false;
}

function isGameOver(level){
	if(isOutOfIndex(level) || fields.getType(level.board[characterPosition.i][characterPosition.j]) == "pit" ){
		$('text').innerHTML = "Vége a játéknak";
		$('text').classList.add('lose');
		return true;
	} return false;
}

function isWin(level){
	if(fields.getType(level.board[characterPosition.i][characterPosition.j]) == "damage"){
		$('text').innerHTML = "Gratulálok, nyertél!";
		$('text').classList.add('win');
		saveWin();
		return true;
	} return false;
}

function saveWin(){
	const xhr = new XMLHttpRequest();
	xhr.open('GET', 'saveWin.php?level='+levelName, true);
	xhr.addEventListener('readystatechange', function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			confirm("\nGratulálunk!\n\nMegoldók:\n"+this.responseText);
		}
	}, false);
	xhr.send(null);
}

function setDirection(action, level){
	if(fields.assemblyLinesLeft.indexOf(action) != -1 || "⬏" == action || "↺" == action){
		characterPosition.direction = (characterPosition.direction - 1 + directions.length) % (directions.length);
	} else if(fields.assemblyLinesRight.indexOf(action) != -1 || "⬎" == action || "↻" == action){
		characterPosition.direction = (characterPosition.direction + 1) % (directions.length);
	} else if("⮌" == action){
		characterPosition.direction = (characterPosition.direction + 2) % (directions.length);
	}
	drawCharacter(level);
}

function push(assemblyLine, level){
	if(assemblyLine == "←" || assemblyLine == "⮠" || assemblyLine == "⮢"){
		characterPosition.j = characterPosition.j - 1;
	}else if(assemblyLine == "↑" || assemblyLine == "⮤" || assemblyLine == "⮥"){
		characterPosition.i = characterPosition.i - 1;
	}else if(assemblyLine == "→" || assemblyLine == "⮣" || assemblyLine == "⮡"){
		characterPosition.j = characterPosition.j + 1;
	}else if(assemblyLine == "↓" || assemblyLine == "⮧" || assemblyLine == "⮦"){
		characterPosition.i = characterPosition.i + 1;
	} drawCharacter(level);
}

function step(action, level){
	var direction;
	if(action == "⭠"){
		direction = directions[(characterPosition.direction+2)%(directions.length)];
	} else {
		direction = directions[characterPosition.direction];
	}
	switch(direction) {
		case "⮘": characterPosition.j = characterPosition.j - 1;
			break;
		case "⮙": characterPosition.i = characterPosition.i - 1;
			break;
		case "⮚": characterPosition.j = characterPosition.j + 1;
			break;
		case "⮛": characterPosition.i = characterPosition.i + 1;
			break;
	}
	drawCharacter(level);
}

function drawCharacter(level){
	var classType = "character_" + directions[previousPosition.direction];
	$('board').rows[previousPosition.i].cells[previousPosition.j].classList.remove(classType);
	previousPosition.i = characterPosition.i;
	previousPosition.j = characterPosition.j;
	previousPosition.direction = characterPosition.direction;
	classType = "character_" + directions[characterPosition.direction];
	if(!isOutOfIndex(level)){
		$('board').rows[characterPosition.i].cells[characterPosition.j].classList.add(classType);
	}
}

function isOutOfIndex(level){
	return (characterPosition.i < 0 || characterPosition.j < 0 ||
	characterPosition.j >= level.board[0].length || characterPosition.i >= level.board.length)
}

window.addEventListener('load', init, false);