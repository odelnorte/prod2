// funciones del calendario

function ocultaDiv(fol){//alert(fol);
	//div donde se mostrará calendario debe estar oculto
	//if(fol=='calendarioInicioST'){$('#calendarioInicioST').hide();}					   
	$('#calendario'+fol).hide();
};

function update_calendar(fol2){//alert(fol2);
	var month = $('#calendar_mes'+fol2).attr('value');//alert(month);
	var year = $('#calendar_anio'+fol2).attr('value');//alert(year);
	//var fol = $(fol2).attr('value');alert(fol);

	var valores='month='+month+'&year='+year+'&fol='+fol2;
//alert(valores);
	$.ajax({
		url: 'php/setvalue.php',
		type: "GET",
		data: valores,
		success: function(datos){//alert(datos);
			$("#calendario_dias"+fol2).html(datos);//alert("#calendario_dias"+fol2);
		}
	});
}
	
function set_date(date){//alert(date);
	var arr = date.split('||');
	//input text donde debe aparecer la fecha
	$('#txtFHRCalendario'+arr[1]).attr('value',arr[0]);
	show_calendar(arr[1]);
}

function show_calendar(fol){//alert(fol);
	//div donde se mostrará calendario
	$('#calendario'+fol).toggle(); 
}	