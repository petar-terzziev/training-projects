
function getting_stats()
{
	var el=document.createElement('p');
	var text='';
 $.ajax({
type:'POST',
url: 'getting_data_stats.php',
datatype: 'json',
success: function (d){
	for(i in d){
text+="number of "+ i + " is "+d[i][0]+" ";

	}
	el.appendChild(document.createTextNode(text))
}
});

document.body.appendChild(el);
}

function selishte_danni()
{

 $.ajax({
type:'POST',
url: 'getting_data_stats.php',
datatype: 'json',
data: 
{
selishte: document.getElementById("sel")
},
success: function (d){
	for(i in d){
text+="number of "+ i + " is "+d[i][0]+" ";

	}
	el.appendChild(document.createTextNode(text))
}
});



}

getting_stats();