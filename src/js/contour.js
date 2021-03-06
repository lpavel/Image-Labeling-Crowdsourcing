var createImage = function(src, title) {
    var img   = new Image();
    img.src   = src;
    img.alt   = title;
    img.title = title;
    return img;
};

var images = [
    createImage("../img/Image0.jpg",  "Image0"),
    createImage("../img/Image1.jpg",  "Image1"),
    createImage("../img/Image2.jpg",  "Image2"),
    createImage("../img/Image3.jpg",  "Image3"),
    createImage("../img/Image4.jpg",  "Image4"),
    createImage("../img/Image5.jpg",  "Image5"),
    createImage("../img/Image6.jpg",  "Image6"),
    createImage("../img/Image7.jpg",  "Image7"),
    createImage("../img/Image8.jpg",  "Image8"),
    createImage("../img/Image9.jpg",  "Image9"),
    createImage("../img/Image10.jpg", "Image10"),
    createImage("../img/Image11.jpg", "Image11"),
    createImage("../img/Image12.jpg", "Image12"),
    createImage("../img/Image13.jpg", "Image13"),
    createImage("../img/Image14.jpg", "Image14"),
    createImage("../img/Image15.jpg", "Image15"),
    createImage("../img/Image16.jpg", "Image16"),
    createImage("../img/Image17.jpg", "Image17"),
    createImage("../img/Image18.jpg", "Image18"),
    createImage("../img/Image19.jpg", "Image19"),
    createImage("../img/Image20.jpg", "Image20"),
    createImage("../img/Image21.jpg", "Image21"),
    createImage("../img/Image22.jpg", "Image22")
];

var minAnnotationPoints = 4;
var clickNumber = 0;
var annotations = [];
var sessionId;
var imageIndex;
var currentAnnotation = 0;
var maxDistance = 5; // max distance at which 2 points are considered the same

$(document).ready(function() {
    getSessionId();
    choosePicture();
});

function getSessionId() {
    $.ajax({
	type: 'GET',
	url: '../Controller/SessionId.php',
	dataType: 'json'
    }).done(function (data) {
	sessionId      = data.id;
	console.log();
    }).fail(function() {
	alert("something went very bad. Couldn't get session id");
    });    
}

// main thing left to do after debugging
function choosePicture() {
    var occurences = 2323; // occurences of the image
    $.ajax({
	type: 'GET',
	url: '../Controller/AnnotationController.php',
	dataType: 'json'
    }).done(function (data) {
	imageIndex = data.id;
	occurences = data.occurences;
	
	var imageHeight = data.height;
	var imageWidth  = data.width; 
	
	$('#canvas').css('background-image', 
			 'url(' + images[imageIndex].src + ')');
	$('#canvas').height(imageHeight).width(imageWidth);
    }).fail(function(ts) {
	alert("something went very bad. Couldn't choose picture" + 
	     ts.responseText);
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
    x1 = annotations[currentAnnotation][clickNumber - 1].X;
    y1 = annotations[currentAnnotation][clickNumber - 1].Y;
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
$('#dot_container_0').click(function(e){
    console.log("blabla");
    // only this div needs to catch the click
    e.stopImmediatePropagation();

    // if it has active then the last dot has been touched
    if ($(this).hasClass('active')) {
	drawLine(annotations[currentAnnotation][0].X, 
		 annotations[currentAnnotation][0].Y);
    }
});

function isFirstPoint(posX,posY) {
    firstX = annotations[currentAnnotation][0].X;
    firstY = annotations[currentAnnotation][0].Y;
    console.log('posX:' + posX + ' | posY:' + posY + ' | firstX:' +
	       firstX + ' | firstY:' + firstY);
    if((Math.abs(posX - firstX) < maxDistance) &&
       (Math.abs(posY - firstY) < maxDistance)) {
	return true;
    }
    else {
	return false;
    }
}

// when the image is clicked, join it with a line to the previous dot
$( '#canvas' ).click(function(e){

    // get coordinates first
    
    var parentX = $(this).offset().left;
    var parentY = $(this).offset().top;
    
    var posX = e.pageX - parentX;
    var posY = e.pageY - parentY;


    if(clickNumber == 0) {
	positions= [];
	positions.push({ X: posX, Y: posY });
	annotations.push(positions);
	drawPoint(posX, posY);
	++clickNumber;
    }
    else {
	if(isFirstPoint(posX, posY)) {
	    // need at least 4 points for a contour
	    if(annotations[currentAnnotation].length < minAnnotationPoints) {
		alert("You need at least 4 points to have a valid annotation");
	    }
	    else {
		annotations[currentAnnotation].push({ X: posX, Y: posY });
		drawLine(posX, posY);
		clickNumber = 0;
		++currentAnnotation;
/*		alert('you finished this contour. You ' +
		      'can start another one or submit the work');
*/	    }
	}
	else {
	    annotations[currentAnnotation].push({ X: posX, Y: posY });
	    drawPoint(posX, posY);
	    drawLine(posX, posY);
	    ++clickNumber;
	}
    }
});

function hasEnoughPoints() {
    var arrSize = annotations.length;
    if(arrSize < 1) {
	return false;
    }
    for(var i = 0; i < arrSize; ++i) {
	if(annotations[i].length < minAnnotationPoints) {
	    return false;
	}
    }
    return true;
}

$('#submitButton').click(function() {
//    if(hasEnoughPoints()) {
	sendAnnotation();
/*    }
    else {
	alert("You need at least 4 points to have a valid label");
    }*/
});

function sendAnnotation() {
    var annotationData = {session_id: sessionId,
			 image_index: imageIndex,
			 coordinates: annotations};

    $.ajax({
	type: "POST",
	url: "../Controller/AnnotationController.php",
	data: annotationData,
	dataType: 'json'
    }).done(function(data) {
	if(data.response != null) {
	    $('#canvas').remove();
	    $('#submitButton').remove();
	    $('#directions').remove();
	    cleanAnnotations();
	    var thankYouHtml = '<h2> Thank you very much!<h2>';
	    var responseCodeHtml = "<h1> Your validation code: " 
		+ data.response + " </h1>";
	    $('#main_content').append(thankYouHtml + responseCodeHtml);
	}
	else {
	    prepareNewImage();
	}
    });    
}

function cleanAnnotations() {
    // first empty the array
    while(annotations.length > 0) {
	while(annotations[annotations.length-1].length > 0) {
	    annotations[annotations.length-1].pop();
	}
	annotations.pop();
    }
    clickNumber = 0;
    currentAnnotation = 0;
}

function prepareNewImage() {
    cleanAnnotations();

    // now remove all children fmor canvas
    $('#canvas').empty();
    
    // now choose picture and let it flow again
    choosePicture();
}
