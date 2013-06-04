/*
	R�cup�ration des infos systemes toutes les 3 secondes + envoi � la page + actualisation
*/

$(document).ready(function() {
	function getData(){
		jQuery.ajax({
		  type: 'GET', 
		  url: 'oid_translate.php', 
		  data: {
			snmpdata: 'OyoKooN',
		  }, 
		  success: function(data, textStatus, jqXHR) {
			$("#cpu").width(data+'%');
			$("#cputxt").text(data+'%');
			if(data>20){
				$("#cpu").css("background-color","#e74c3c");
			}else{
				if(data>10){
					$("#cpu").css("background-color","#f1c40f");
				}else{
					$("#cpu").css("background-color","##27ae60");
				}
			}
		  },
		  error: function(jqXHR, textStatus, errorThrown) {
			// Une erreur s'est produite lors de la requete
			alert('fail');
		  }
		});
		// la requete est faite toutes les 3000ms
		setTimeout(getData,3000);
	}
	// premier appel � la fonction
	getData();
});