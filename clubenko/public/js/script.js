$(document).ready(function() {
    
	$('.primary-nav-tab').mouseout(function(){
		var id = $(this).data('id');
		//console.log('primary-nav')
		//$('.subnav').css('display','none')
	})
	$('.primary-nav-tab').mouseover(function(){
		var id = $(this).data('id');
		$('.subnav-flyout').css('display','none')
		$('#'+id).css('display','block')
		
		
	})


	$('.subnav-flyout').mouseout(function(){
		var id = $(this).attr('id');
		$('#'+id).css('display','none')
	})
	$('.subnav-flyout').mouseover(function(){
		var id = $(this).attr('id');
		$('.subnav-flyout').css('display','none')
		$('#'+id).css('display','block')
		
	})
    
   //Ocultamos el mapa tras hacer clicke en ver mapa
  $(document).ready(function(){
    $('#pull-static-map-wrapper').click(function(){
      $('#pull-static-map-wrapper').css('display','none')
      $('#pull-dynamic-map').css('display','block')
    })
  })


});

