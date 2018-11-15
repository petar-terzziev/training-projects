
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
text+="Броят на "+ i + " е "+d[i][0]+". ";

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
url: 'selishte_danni.php',
datatype: 'json',
data: 
{
selishte: document.getElementById("sel").value
},
success: function (d){
var data=document.getElementById("sel_danni");
$(data).empty();
var txt;
for(i in d){
	  var li = document.createElement("li");
		txt='';
	txt=d[i]['sel_name']+" се намира в община "+d[i]['obst_name']+" в област "+d[i]['obl_name']+" ";
  li.appendChild(document.createTextNode(txt));
  data.appendChild(li);
}
}
});



}

getting_stats();