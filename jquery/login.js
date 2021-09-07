
$(".toggle-password").click(function(){
  $(this).toggleClass("fa-lock fa-unlock");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

jQuery('.tabs-menu li').click(function(){
		var index = $(this).index();
		jQuery('.tabs-menu li').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.panes').hide();
		jQuery('.panes').eq(index).show();
		jQuery('.reset').hide();
    jQuery('.profile-update').hide();
		return false
	});
	$(document).ready(function(){
  		$(".signup-txt").click(function(){
    		jQuery('.tabs-menu li.signup').addClass('active');
    		jQuery('.tabs-menu li.login').removeClass('active');
    		jQuery('.clear').eq(2).show();
    		jQuery('.clear').eq(1).hide();
    		jQuery('.reset').hide();
  		});
	});

	$(document).ready(function(){
  		$(".login-txt").click(function(){
    		jQuery('.tabs-menu li.signup').removeClass('active');
    		jQuery('.tabs-menu li.login').addClass('active');
    		jQuery('.clear').eq(2).hide();
    		jQuery('.clear').eq(1).show();
    		jQuery('.reset').hide();
  		});
	});

	$(document).ready(function(){
  		$(".forget-txt").click(function(){
    		jQuery('.reset').show();
  		});
	});

	

	var x = window.matchMedia("(max-width: 900px)");

	function openNav()
	{
  		if (x.matches){
  			document.getElementById("mySidenav").style.height = "144.4px";
  			document.getElementById("openNav").style.display = "none";
  			document.getElementById("closeNav").style.display = "inline";
  		}
	
  		else
  		{
  			document.getElementById("mySidenav").style.height = "58.5px";
  			document.getElementById("closeNav").style.display = "none";
  		}
	}
	function closeNav() 
	{
  		if (x.matches){
	  		document.getElementById("openNav").style.display = "inline";
	  		document.getElementById("closeNav").style.display = "none";
	  		document.getElementById("mySidenav").style.height = "0";
		}
		else
  		{
  			document.getElementById("mySidenav").style.height = "58.5px";
  			document.getElementById("openNav").style.display = "none";
  		}
	}
	x.addListener(openNav);
	x.addListener(closeNav);	
	
