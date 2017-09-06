// ******* TEXT-BASED SEARCH SUGGESTIONS ***********//
// This makes an ajax call to suggestImages.php & returns
// text to the drop-down under the search bar
function suggestImages(){
	var jsonString = JSON.stringify({data: $('#inbox').val()});


	$.ajax({
		url: "suggestImages.php",
		type: "POST",
		data: {data : jsonString},
		success: function(data){
			 $('#testdiv').html(data);
		}
	});
}

// THIS FILLS THE TEXT FROM THE CHOSEN DROP-DOWN SUGGESTIONS
// & fills it into the hidden from input to then be submitted
function getImageSearched(elem){
	var sometext = $(elem).text();
	var jsonString = JSON.stringify({data: sometext});
	$('#inbox').val(sometext);
	$('#hiddeninput').val(jsonString);
	
	/*
	$.ajax({
			url: "searchedImages.php",
			type: "POST",
    		data: {data : jsonString},
    		success: function(data){
				 $('#imagediv').html(data);
			}
		});*/
}
$(document).ready(function(){//ajax call - connection to database and retrieve images

	//when search button is clicked - navigate and retrieve images related
	$('#b1').on('click',function(){
		var jsonString = JSON.stringify({data: $('#inbox').val()});
		$('#hiddeninput').val(jsonString);
		
		//alert(jsonString);

		/*
		$.ajax({
			url: "imagetest.php",
			type: "POST",
    		data: {data : jsonString},
    		success: function(data){
				 $('#imagediv').html(data);
			}
		});*/
	});

$('#orig').show();

var firstPlay = true;
// event listener for when scroll
$( window ).scroll(function() {

	var height = $(window).scrollTop(); // get current vertical position

	// on scroll 250px swap the classes (to trigger css animation - based on classes)
	if(height > 250 & firstPlay){ 
		
		// move left & right
		$('#squares-text').fadeOut();
		$('.small-squares-left').addClass('small-squares-left-1');
		$('div').removeClass('small-squares-left');
		$('.small-squares-right').addClass('small-squares-right-1');
		$('div').removeClass('small-squares-right');
		firstPlay = false;

		//rotate squares
		$('.small-squares').addClass('small-squares-rotate');
	}

	// if the class has been added for the animation trigger wait 5 seconds for the animation 
	// to play and then make a square shape
	if($('div').hasClass('small-squares-right-1')){
		setTimeout(function(){ 
			$('.small-squares-left-1').addClass('small-squares-right');
			$('div').removeClass('small-squares-left-1');
			$('.small-squares-right-1').addClass('small-squares-left');
			$('div').removeClass('small-squares-right-1');
			$('#hid').show();
			$('#orig').hide();
		}, 3000);	

	}

});

// check if form is completed (NEEDS TO BE SANITISED LATER!!)
var submissions = 0;
$('#send').on('click',function(){
	submissions++;
	var completed = true;
	$('#contact-form').find('input, textarea, select').each(function(){
		if(!$(this).val()){
			completed = false;
		}
	});
	if (!completed & submissions <= 1){
		$('#contact-form').prepend("<p style='color:white'>hello... please complete the form before submitting</p>");
		$('#send').css('background','red');
		return false;	
	}
	else if (!completed){
		return false;
	}else{
		
		//make the ajax call & send the email
		var emailArray = [];
		emailArray.push($('#name').val());
		emailArray.push($('#email').val());
		emailArray.push($('#message').val());
		var jsonString = JSON.stringify(emailArray);
		console.log(jsonString);

		$.ajax({
			url: "send-email.php",
			type: "POST",
			data: {data : jsonString},
			success: function(data){
				console.log(data);
				 // $('#testdiv').html(data);
			}
		});
		console.log("after ajax");
		return false;
	}
});

//Dropdowns for category gallerys on homepage
var hasTriangle = false;
var clickThing = '';
function showPreview(elem){

	var jsonString = JSON.stringify({data: $(elem).attr('id')});
	console.log(jsonString);
		$.ajax({
			url: "dropdownimages.php",
			type: "POST",
    		data: {data : jsonString},
    		success: function(data){
    			appendTop= '<div class="arrow-up" style="display:none;"></div>';
				appendBody= '<div class="row" id="previewrow"><div class="col-md-6"><div class="row">' + data + '</div></div><button class="col-md-offset-1 col-md-4 col-xs-offset-4 col-xs-4" id="viewmore" onclick="navToGallery(this);">view more</button></div>';

				elem.closest('.container-fluid').append(appendBody);
				elem.closest('div').append(appendTop);
				$('#previewrow').css('display','none');
				$('#previewrow').slideDown();
				$('.arrow-up').fadeIn();
				hasTriangle = true;

			}
		});

}


// if image is clicked, append a preview of 6 related images to the row
$('.shinyimages').on('click',function(){
	console.log($(this).attr('id'));

	// if no triangle present and the last thing is clicked again
	if (!hasTriangle && clickThing == $(this).attr('id')) {
		clickThing = '';
	}
	//if there is a triangle present in DOM
	if(hasTriangle){
		hasTriangle = false;
		$('.arrow-up').fadeOut(function(){$(this).remove();});
		$('#previewrow').slideUp(function(){$(this).remove();});
	}
	//if image clicked is not the last thing clicked
	if(clickThing != $(this).attr('id')){
		clickThing = $(this).attr('id');
		// console.log('passing to function');
		showPreview($(this));

		hasTriangle=true;
	}
	
});
});

//bug present here when click an image -> off image -> back on SAME image: NEED TO FIX THIS
$(window).on('click', function(){
	$('.arrow-up').fadeOut(function(){$(this).remove();});
	$('#previewrow').slideUp(function(){$(this).remove();});
});

//when view more button clicked in dropdown
function navToGallery(galleryItem){

	window.location.href = './viewImages.html';
}
