
function mostrarComprobantes(id_alumna){
	
	num=document.getElementById("actividad").selectedIndex
	id=document.getElementById("actividad")[num].value;
	
	$.ajax({
				data:"id="+ id+"&id_alumna="+id_alumna,
				url:'ajax/mostrarComprobantes.php',
				type:'get',
				success:function(response){					
					
					$("#comprobantes").html(response);
				}
				});
	
	
}

function recargarGrupos(){
	
	num=document.getElementById("id_sede").selectedIndex
	id_sede=document.getElementById("id_sede")[num].value;
	
	$.ajax({
				data:"id_sede="+id_sede,
				url:'ajax/recargarGrupos.php',
				type:'get',
				success:function(response){					
					$("#actividad").html(response);
				}
				});
	
	
	
}