$(document).ready(function(){
  	$(".lower-text-profile").click(function(){
    	jQuery('.profile-update').show();
  	});
});

$(document).ready(function(){
	$("#myInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#myTable tr").filter(function() {
		    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	$("#updateform").click(function(){
		window.location.reload(true);
	});
});

$(document).ready(function(){
  	$("#overlay-on").click(function(){
    	jQuery('.overlay').show();
  	});

  	$(".overlay-cross").click(function(){
    	jQuery('.overlay').hide();
  	});
});

$(document).ready(function(){
  	$("#overlay-on").click(function(){
    	jQuery('.overlay').show();
  	});

  	$(".overlay-cross").click(function(){
    	jQuery('.overlay').hide();
  	});
});
