jQuery('.tabs-menu li').click(function(){
	var index = $(this).index();
	jQuery('.tabs-menu li').removeClass('active');
	jQuery(this).addClass('active');
	jQuery('.panes').hide();
	jQuery('.panes').eq(index).show();
	return false
});

$(document).ready(function(){

	$("#myInput1").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
		$("#myTable1 tr").filter(function() {
	    	$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	$("#myInput2").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#myTable2 tr").filter(function() {
		      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	});

	$("#myInput3").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#myTable3 tr").filter(function() {
		      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	});
});
