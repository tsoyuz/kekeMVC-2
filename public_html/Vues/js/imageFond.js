function theme()
{
	var iTheme = document.getElementById("menuTheme").selectedIndex;

	if(iTheme==0)
	{
		document.location.reload(true);
	}
	else
	{
		if(iTheme==1)
		{
			document.body.style.backgroundImage = "url(Images/fondIntermediaire.png)";
			document.getElementById("hcentre").innerHTML="Prêt à devenir le meilleur ?";
			document.getElementById("titre").style.textShadow="0 0 0.2em #BAB400, 0 0 0.2em #BAB400";
			document.getElementById("titre").style.backgroundColor="#FFFDC6";
			document.getElementById("copyright").style.backgroundColor="#FFFDC6";
			var tabBout = document.getElementsByTagName("button");
			for(var i=0; i<tabBout.length; i++)
				tabBout[i].style.backgroundImage="radial-gradient(#FFFDC6, #F0F041)";
			document.getElementById("imgNiv").src = "../Images/imageIntermediaire.png";
		}
		else
		{
			document.body.style.backgroundImage = "url(Images/fondExpert.png)";
			document.getElementById("hcentre").innerHTML="Prêt à écraser les autres joueurs ?";
			document.getElementById("titre").style.textShadow="0 0 0.2em #FD1919, 0 0 0.2em #FD1919";
			document.getElementById("titre").style.backgroundColor="#FAE1E1";
			document.getElementById("copyright").style.backgroundColor="#FAE1E1";
			var tabBout = document.getElementsByTagName("button");
			for(var i=0; i<tabBout.length; i++)
				tabBout[i].style.backgroundImage="radial-gradient(#FAE1E1, #E65151)";
			document.getElementById("imgNiv").src = "../../Images/imageExpert.png";
		}
	}
}