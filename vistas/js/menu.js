$(function() {

    jQuery(".sidebar-nav").on('click','li',function(){ 
        // alert("Hola");
        jQuery(this).addClass("active").siblings().removeClass("active"); 
      });


});




