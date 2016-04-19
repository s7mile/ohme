//arc = Math.PI/(식당수/2) 
var total = menus.length; //갯수
var startAngle = 0;
var arc = Math.PI / (total/2);
var spinTimeout = null;

var spinArcStart = 10;
var spinTime = 0;
var spinTimeTotal = 0;

var a=0;

var ctx;

function draw() {
	drawRouletteWheel();
}
function drawRouletteWheel() {
	var canvas = document.getElementById("wheelcanvas");
	if (canvas.getContext) {
		var outsideRadius = 230;
		var textRadius = 160;
		var insideRadius = 125;

		outsideRadius = canvas.width / 2.1;
		textRadius = canvas.width /4.2;
		insideRadius = canvas.width /10;

		ctx = canvas.getContext("2d");
		ctx.clearRect(0,0,700,700);
		ctx.strokeStyle = "white";
		ctx.lineWidth = 2;
		ctx.font = 'bold 16px Comic Sans MS';

		for(var i = 0; i < total; i++) {
			var angle = startAngle + i * arc;
			if(i%2 == 0) ctx.fillStyle = "#fff";
			else ctx.fillStyle = "#ffc71e";

			ctx.beginPath();
			ctx.arc(325, 325, outsideRadius, angle, angle + arc, false);
			ctx.arc(325, 325, insideRadius, angle + arc, angle, true);
			ctx.stroke();
			ctx.fill();

			ctx.save();
			ctx.shadowOffsetX = -1;
			ctx.shadowOffsetY = -1;
			ctx.shadowBlur    = 0;
			ctx.shadowColor   = "rgb(220,220,220)";
			ctx.fillStyle = "black";
			ctx.translate(325 + Math.cos(angle + arc / 2) * textRadius, 325 + Math.sin(angle + arc / 2) * textRadius);
			ctx.rotate(angle + arc / 2 + Math.PI / 2);
			var text = menus[i];
			ctx.fillText(text, -ctx.measureText(text).width / 2, -100);
			ctx.restore();
		} 

		//Arrow
		ctx.fillStyle = "#000";
		ctx.beginPath();
		ctx.moveTo(325 - 4, 325 - (outsideRadius + 15));
		ctx.lineTo(325 + 4, 325 - (outsideRadius + 15));
		ctx.lineTo(325 + 4, 325 - (outsideRadius - 15));
		ctx.lineTo(325 + 9, 325 - (outsideRadius - 15));
		ctx.lineTo(325 + 0, 325 - (outsideRadius - 23));
		ctx.lineTo(325 - 9, 325 - (outsideRadius - 15));
		ctx.lineTo(325 - 4, 325 - (outsideRadius - 15));
		ctx.lineTo(325 - 4, 325 - (outsideRadius + 15));
		ctx.fill();
	}
}

function spin() {
	spinAngleStart = Math.random() * 10 + 10;
	spinTime = 0;
	spinTimeTotal = Math.random() * 3 + 4 * 1000;
	rotateWheel();
}

function rotateWheel() {
	spinTime += 30;
	if(spinTime >= spinTimeTotal) {
		stopRotateWheel();
		return;
	}
	var spinAngle = spinAngleStart - easeOut(spinTime, 0, spinAngleStart, spinTimeTotal);
	startAngle += (spinAngle * Math.PI / 180);
	drawRouletteWheel();
	spinTimeout = setTimeout('rotateWheel()', 30);
}

function stopRotateWheel() {
	if(a==0){
		clearTimeout(spinTimeout);
		var degrees = startAngle * 180 / Math.PI + 90;
		var arcd = arc * 180 / Math.PI;
		var index = Math.floor((360 - degrees % 360) / arcd);
		ctx.save();
		// ctx.font = 'bold 30px sans-serif';
		var text = menus[index];
		// ctx.fillText(text,  - ctx.measureText(text).width / 2 + 150, 150 + 10);
		// ctx.restore();
		menuData.select(text);
	}

	a+=1;
}

function easeOut(t, b, c, d) {
	var ts = (t/=d)*t;
	var tc = ts*t;
	return b+c*(tc + -3*ts + 3*t);
}

draw();