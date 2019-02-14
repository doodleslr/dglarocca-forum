//signout sonfirmation
var confirmBox = document.getElementById("confirmBox");
var signout = document.getElementById("signout");
var decline = document.getElementById("stay");
signout.onclick = function(){
	confirmBox.style.display = "block";
}
decline.onclick = function(){
	confirmBox.style.display = "none";
}
window.onclick = function(event){
	if(event.target == confirmBox){
		confirmBox.style.display = "none";
	}
}

//edit and delete hover
if($(window).width() < 1366){
	$('.action').children('.edit-content').addClass('current');
} else {
	$('.action').hover(function(){
		$(this).children('.edit-content').toggleClass('current');
	});
}


//delete item
var deleteBox = document.getElementById("deleteBox");
var keep = document.getElementById("keep");
var idHolder = "";
var item = "";

keep.onclick = function(){
	deleteBox.style.display = "none";
}
window.onclick = function(event){
	if(event.target == deleteBox){
		deleteBox.style.display = "none";
	}
}
$(document).on('click','.del-button', function(){
	idHolder = $(this).attr('id').replace("del","");//get target ID
	item = $(this).closest('li');//targets the li element
	console.log(idHolder);
	deleteBox.style.display = "block";
});
$(document).on('click', "#delete", function(){
	var id = idHolder;
	deleteBox.style.display = "none";
	$.ajax({
		url: 'scripts/delete-post.php',
		type: 'POST',
		data: { 'id':id },
		success: function(response){
			if(response == 'ok') {
				item.slideUp(300,function(){
					item.remove();
				});
			} else if(response == 'error') {
				console.log("error couldn't delete");
				console.log(response);
			} else {
				console.log(response);
			}
		}
	});	
});

//voting
$('.arrow-up').on('click', function() {
	if($(this).hasClass('select-up')) {
		console.log(session + 'has already upvoted');
	} else {
		$(this).addClass('select-up');
		$(this).siblings('.arrow-down').removeClass('select-down');
		
		var itemId = $(this).parents('li').attr('id');

		$.ajax({
			url: 'scripts/vote.php',
			type: 'POST',
			data: { 'postId':itemId, 'value':'true', 'username':session },
			success: function(response){
				if(response) {
					console.log(response + ' on ' + itemId);
				} else if(response) {
					console.log("Error - unable to upvote.");
				} else {
					console.log(response);
				}
			}
		});	
	}
});
$('.arrow-down').on('click', function() {
	if($(this).hasClass('select-down')) {
		console.log(session + 'has already downvoted');
	} else {
		$(this).addClass('select-down');
		$(this).siblings('.arrow-up').removeClass('select-up');
		
		var itemId = $(this).parents('li').attr('id');
		
		$.ajax({
			url: 'scripts/vote.php',
			type: 'POST',
			data: { 'postId':itemId, 'value':'false', 'username':session },
			success: function(response){
				if(response) {
					console.log(response + ' on ' + itemId);
				} else if(response) {
					console.log("Error - unable to downvote.");
				} else {
					console.log(response);
				}
			}
		});	
	}
});