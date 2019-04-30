$(document).ready(function(){

	$("#s").click(function(e)
	{
		alert("fds");
		
		e.preventDefault();
		$.post("form.php","nom=unNom",
		function(data)
		{
			$("#bo").html(data);
		},
		'text');
	});

});


//On ajoute le formulaire dans l'id div (ex : #divForm )
function formulaire(div,nom)
{	
	$(div).load("form.html"); 
}

//Valider
function valideFormulaire(div,nom)
{
	
	alert("fds");
	
	$.post("form.php","nom=unNom",
	function(data)
	{
		$("#bo").html(data);
	},
	'text');
}

