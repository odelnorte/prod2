/*jslint white: true, browser: true, undef: true, nomen: true, eqeqeq: true, plusplus: false, bitwise: true, regexp: true, strict: true, newcap: true, immed: true, maxerr: 14 */
/*global window: false, REDIPS: true */
var maquina=''; var serie=''; var posicion='';/* var posSala='';*/
/* enable strict mode */
"use strict";

// define redips_init variable
//function cargar(){alert("entra");
// redips initialization
function inicio(){//alert('entre');
       var redips_init;
//redips_init = function () {alert('h3i');
       var num = 0,                        // number of successfully placed elements
               rd = REDIPS.drag;        // reference to the REDIPS.drag lib
       // initialization
       rd.init();
       // set hover color
       rd.hover.color_td = '#9BB3DA';
       
       rd.myhandler_dropped = function () {rd.enable_drag(false, rd.obj.id);}
       rd.myhandler_dropped_before = function () {//alert('hola');
       //var ser='';
               if(rd.target_cell.className==='green_cell'){alert('Este espacio del Rack ya esta ocupado'); return false;}
                if(rd.target_cell.className==='tablaOrigen'){return false;}
			   else{rd.target_cell.className = 'green_cell'; var pos=rd.get_position(); posicion=pos[1]+'-'+pos[2];
			   maquina=rd.obj.id; serie=document.getElementById(maquina).title;
			   creaMovimiento(serie,maquina,posicion);     
               }
       };
}
function desabilita2(id){//alert(id+"||");
rd = REDIPS.drag; 
rd.enable_drag(false, id);}
 //alert(serie+' | '+posicion);
/*redips_init=function (){alert("entra");

var redips_init;

	var num = 0,			// number of successfully placed elements
		rd = REDIPS.drag;	// reference to the REDIPS.drag lib
	rd.init();
	rd.hover.color_td = '#9BB3DA';
	
	rd.myhandler_dropped_before = function () {alert('hola');
	//var ser='';
		if(rd.target_cell.className==='green_cell'){alert('Este espacio del Rack ya esta ocupado'); return false;
		}else{alert("entra a else");rd.target_cell.className = 'green_cell'; var pos=rd.get_position(); posicion=pos[1]+'-'+pos[2]; alert(serie+' | '+posicion); 
			//creaMovimiento(serie, posicion);
		
		}//rd.enable_drag(false, rd.obj.id);

	};
}*///}
/*redips_init = function () {alert('h3i');
	var num = 0,			// number of successfully placed elements
		rd = REDIPS.drag;	// reference to the REDIPS.drag lib
	// initialization
	rd.init();
	// set hover color
	rd.hover.color_td = '#CCC';
	
	rd.myhandler_dropped_before = function () {//alert('hola');
	//var ser='';
		if(rd.target_cell.className==='green_cell'){alert('Este espacio del Rack ya esta ocupado'); return false;
		}else{rd.target_cell.className = 'green_cell'; var pos=rd.get_position(); posicion=pos[1]+'-'+pos[2]; alert(serie+' | '+posicion); 
			//creaMovimiento(serie, posicion);
		
		}//rd.enable_drag(false, rd.obj.id);
		};
};*/
//obtiene el la serie de la maquina a mover	
/*function seleccionaSerie(ser,maq){//alert(ser+" "+maq);
	serie=ser;  maquina=maq;
}*/
//crea un movimiento por cada movimiento de maquina
/*function creaMovimiento(serie, posicion){alert(serie+' | '+posicion);
   $.ajax({
   url: 'creaMovimiento.php',
   type: 'POST',
   async: true,
   data: 'seriex='+serie+'&posicionx='+posicion,
   dataType: "text",
   success: function Respuesta(result){//alert(result);
   document.getElementById('textaOriRu'+fol).innerHTML=result;
   },
   error: Error
   });
}*/
// add onload event listener
if (window.addEventListener) {//alert('hi');
	window.addEventListener('load', redips_init, false);
}
else if (window.attachEvent) {//alert('hi2');
	window.attachEvent('onload', redips_init);
}