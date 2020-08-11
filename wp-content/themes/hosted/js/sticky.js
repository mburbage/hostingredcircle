(function($) {"use strict";
    // <!-- Intializing Navigation Effect-->
   // $("#stick").stick_in_parent({container: $("#page"), offset_top: 0});

   $(function(){
	    $(document).scroll(function(){
	        if($(this).scrollTop() <= 0) {
	            $("#stick").trigger("sticky_kit:detach");
	        } else {
	            $("#stick").stick_in_parent({container: $("#page"), offset_top: 0});
	        }
	    });
	});
   
})(jQuery);