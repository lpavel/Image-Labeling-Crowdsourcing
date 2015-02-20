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
    createImage("../img/Image10.jpg", "Image10")
];

var minDotsNumber = 1;
var dots = [];
var sessionId;
var imageIndex;
var clickNumber = 0;

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

function choosePicture() {
    $.ajax({
	type: 'GET',
	url: '../Controller/DotsController.php',
	dataType: 'json'
    }).done(function (data) {
	imageIndex = data.id;
	
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
	zIndex: clickNumber
    }
    
    //set only the first dot active
    class_active = '';
	
    // html/css for the dot
    div = $('<div id="dot_container_' + clickNumber +
	    '" order_value="' + clickNumber +
	    '" class="dot_container' + class_active +
	    '"><div class="dot"></div></div>').css(css);
    
    //add the dot to the page
    $('#canvas').append(div);
}


// when the image is clicked, join it with a line to the previous dot
$( '#canvas' ).click(function(e){

    // get coordinates first
    
    var parentX = $(this).offset().left;
    var parentY = $(this).offset().top;
    
    var posX = e.pageX - parentX;
    var posY = e.pageY - parentY;

    dots.push({ X: posX, Y: posY });
    drawPoint(posX, posY);
    ++clickNumber;
});

function hasEnoughPoints() {
    var arrSize = dots.length;
    if(arrSize < minDotsNumber) {
	return false;
    }
    return true;
}

$('#submitButton').click(function() {
    if(hasEnoughPoints()) {
	sendDots();
    }
    else {
	if(minDotsNumber == 1) {
	    alert("You need to indicate at least one thing to be private");
	}
	else {
	    alert("You need to indicate at least " + minDotsNumber 
		  + " things to be private");
	}
    }
});

function sendDots() {
    var dotsData = {session_id: sessionId,
		    image_index: imageIndex,
		    coordinates: dots};

    $.ajax({
	type: "POST",
	url: "../Controller/DotsController.php",
	data: dotsData,
	dataType: 'json'
    }).done(function(data) {
	if(data.response != null) {
	    $('#canvas').remove();
	    $('#submitButton').remove();
	    $('#directions').remove();
	    cleanDots();
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

function cleanDots() {
    // first empty the array
    while(dots.length > 0) {
	dots.pop();
    }
}

function prepareNewImage() {
    cleanDots();

    // now remove all children fmor canvas
    $('#canvas').empty();
    
    // now choose picture and let it flow again
    choosePicture();
}
