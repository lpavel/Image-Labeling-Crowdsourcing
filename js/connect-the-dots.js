var createImage = function(src, title) {
    var img   = new Image();
    img.src   = src;
    img.alt   = title;
    img.title = title;
//    img.height = 400;
//    img.width = 600;
    return img;
};

var images = [
    createImage("img/Image0.jpg", "Image0"),
    createImage("img/Image1.jpg", "Image1"),
    createImage("img/Image2.jpg", "Image2"),
    createImage("img/Image3.jpg", "Image3"),
    createImage("img/Image4.jpg", "Image4"),
    createImage("img/Image5.jpg", "Image5"),
    createImage("img/Image6.jpg", "Image6"),
    createImage("img/Image7.jpg", "Image7"),
    createImage("img/Image8.jpg", "Image8"),
    createImage("img/Image9.jpg", "Image9"),
    createImage("img/Image10.jpg", "Image10")

];

var minAnnotationPoints = 4;
var clickNumber = 0;
var positions = [];
var sessionId;
var imageIndex;

$(document).ready(function() {
    getSessionId();
    choosePicture();

});

function getSessionId() {
    $.ajax({
	type: 'GET',
	url: 'php/SessionId.php',
	dataType: 'json'
    }).done(function (data) {
	sessionId      = data.id;
	console.log();
    }).fail(function() {
	alert("something went very bad. I'm sorry");
    });    
}

// main thing left to do after debugging
function choosePicture() {
    var occurences = 2323; // occurences of the image
    $.ajax({
	type: 'GET',
	url: 'php/RequestImage.php',
	dataType: 'json'
    }).done(function (data) {
	imageIndex      = data.id;
	occurences = data.occurences;
	$('#canvas').css('background-image', 
			 'url(' + images[imageIndex].src + ')');
    }).fail(function() {
	alert("something went very bad. I'm sorry");
    });
}

function drawPoint(posX, posY) {

    css = {
	left: posX,
	top: posY,
	//to ensure lower numbers are on top of higher ones in case of overlap
	zIndex: clickNumber
    }
    
    //set only the first dot active
    class_active = (clickNumber == 0) ? ' active' : '';
	
    // html/css for the dot
    div = $('<div id="dot_container_' + clickNumber +
	    '" order_value="' + clickNumber +
	    '" class="dot_container' + class_active +
	    '"><div class="dot"></div></div>').css(css);
    
    //add the dot to the page
    $('#canvas').append(div);
}

function drawLine(posX, posY) {
    
    //draw line from previous dot to this dot
    x1 = positions[clickNumber - 1].X;
    y1 = positions[clickNumber - 1].Y;
    x2 = posX;
    y2 = posY;
    
    // slope, angle, length
    var m = (y2-y1)/(x2-x1);
    var angle = (Math.atan(m))*180/(Math.PI);
    var d = Math.sqrt(((x2-x1)*(x2-x1)) + ((y2-y1)*(y2-y1)));
    var transform;
    
    // the (css) transform angle depends on the direction of movement of the line
    if (x2 >= x1){
	transform = (360 + angle) % 360;
    } else {
	transform = 180 + angle;
    }
    
    // add the (currently invisible) line to the page
    var id ='line_'+new Date().getTime();
    var line = "<div id='"+id+"'class='line'>&nbsp;</div>";
    $('#canvas').append(line);
    
    //rotate the line
    $('#'+id).css({
	'left': x1,
	'top': y1,
	'width': '0px',
	'transform' : 'rotate('+transform+'deg)',
	'transform-origin' : '0px 0px',
	'-ms-transform' : 'rotate('+transform+'deg)',
	'-ms-transform-origin' : '0px 0px',
	'-moz-transform' : 'rotate('+transform+'deg)',
	'-moz-transform-origin' : '0px 0px',
	'-webkit-transform' : 'rotate('+transform+'deg)',
	'-webkit-transform-origin' : '0px 0px',
	'-o-transform' : 'rotate('+transform+'deg)',
	'-o-transform-origin' : '0px 0px'
    });
    
    // 'draw' the line
    $('#'+id).animate({
	width: d,
    }, 100, "linear", function(){
    });
}

// handle this only when the first dot is pressed
$('.dot_container').click(function(){
    // if it has active then the last dot has been touched
    if ($(this).hasClass('active')) {
	drawLine(positions[0].X, positions[0].Y);
    }
});

// when the image is clicked, join it with a line to the previous dot
$( '#main' ).click(function(e){
    // get coordinates first
    
    var parentX = $(this).offset().left;
    var parentY = $(this).offset().top;
    
    var posX = e.pageX - parentX;
    var posY = e.pageY - parentY;

    positions.push({ X: posX, Y: posY });

    if(clickNumber == 0) {
	// do nothing
	drawPoint(posX, posY);
    }
    else {
	drawPoint(posX, posY);
	drawLine(posX, posY);
    }
    clickNumber++;
});

$('#submitButton').click(function() {
    if(positions.length < minAnnotationPoints) {
	alert("You need at least 4 points to have a valid annotation");
    }
    sendAnnotation();
//    changeImage();
});

function sendAnnotation() {
    var annotationData = {session_id: sessionId,
			 image_index: imageIndex,
			 coordinates: positions};

    $.ajax({
	type: "POST",
	url: "php/Annotation.php",
	data: annotationData,
	dataType: 'json'
    }).done(function(data) {
	console.log(data);
    });    
}
