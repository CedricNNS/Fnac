$(document).ready(function(){
	var array = [];

	$.getJSON( "controller/T_e_photo_phoController", function( data ) {
	  $.each( data, function( key, val ) {
	   array.push(val);
	  });
  	});
	  console.log(array);
	var val;
	$('#BandeauNews').prepend('<center id="test"></center>');
	for(var i = 0; i<array.length;i++){
		array[i] = "<img src='https://srv-prj.iut-acy.local/INFO/213/Sprint1/Photos/"+array[i]+"'\" id=\""+i+"\" class=\"news\" ></img>";
		if(i == 0)
			$('#test').append(array[0]);
		val = 0;
	}
	$('#BandeauNews').append('<img src="https://srv-prj.iut-acy.local/INFO/213/Sprint1/JS/flecheGauche.png" id="turnLeft"></img>');
	$('#BandeauNews').append('<img src="https://srv-prj.iut-acy.local/INFO/213/Sprint1/JS/flecheDroite.png" id="turnRight"></img>');
	
	$('#turnLeft').click(function() {
	    $('#'+val).remove();
		
		if(val == 0){
			val = array.length-1;
		}else{
			val--;
		}
		$('#test').prepend(array[val]);
	});
	$('#turnRight').click(function(){
			$('#'+val).remove();
	
		if(val == array.length-1){
			val = 0;
		}else{
			val++;
		}
		$('#test').prepend(array[val]);
	});
	
	setInterval(function(){
		$('#'+val).remove();
		
		if(val == array.length-1){
			val = 0;
		}else{
			val++;
		}
		$('#test').prepend(array[val]);
	}, 1000);
});