//delete item
var deleteBox = document.getElementById("deleteBox");
var keep = document.getElementById("keep");
var idHolder = "";

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
				window.location.replace("welcome.php");
			} else if(response == 'error') {
				console.log("error couldn't delete");
				console.log(response);
			} else {
				console.log(response);
			}
		}
	});	
});