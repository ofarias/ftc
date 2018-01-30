//Function para envio de formulario

$(document).ready(function() {
 
	$('form').submit(function(e) {
		e.preventDefault();
 
		var data = $(this).serializeArray();
		data.push({name: 'tag', value: 'login'});
 
		$.ajax({
			url: 'generaExcel.php',
			type: 'post',
			dataType: 'json',
			data: data,
			beforeSend: function() {
				$('.fa').css('display','inline');
			}
		})
		.done(function() {  //true
			$('span').html("Correcto");
		})
		.fail(function() {  //false
			$('span').html("Falso");
		})
		.always(function() {
			setTimeout(function() {
				$('.fa').hide();
			}, 1000);
		});
		
	});
});


 //Funcion del DatePicker jQuery UI
 /*
$(function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' }).val();
    $( "#datepicker1" ).datepicker({ dateFormat: 'dd/mm/yy' }).val();
  });*/
  
  
$(document).on('click',".fechas", function(){
       $(this).datepicker(
        {
             format:'dd/mm/yyyy',
             language:'es',
             weekStart:1
         }); 
    });
  //
  /*
  $(function() {

    $('#side-menu').metisMenu();

});
*/

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
/*
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});*/

