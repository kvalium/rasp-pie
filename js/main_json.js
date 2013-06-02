$(document).ready(function() {
	function getData(){
		$.getJSON('oid_translate.php', function(data) {
		  // Construction d'une liste contenant les donnees JSON
			var output = '<table class="table_infos">';

		  // On passe en revue les cles et valeurs une a une
			$.each(data, function(key, value) {
				output += '<tr>';
				output += '<td>' + key + '</td>';
				output += '<td><br /><div class="progress"><div class="bar" style="width : '+value+'%"><span>'+value+'%</span></div></div></td></tr>';
			}); 
			output += '</table>';
		
		  // Enfin on insere la liste dans la page
		  $('#json-use-response').html('').html(output);
		});
		setTimeout(getData,3000);
	}
	
	getData();
});