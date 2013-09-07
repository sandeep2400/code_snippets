// JavaScript Document
<script>
var rec_tot = 0;
var rec_count = 0;  
var err_count = 0;
//Define global variables here

function launchquery(){
var id_count = $("div[id=idnum]").length;
alert(id_count);
bestship();
}


function launchquery(){
//set any varable here: rec_tot = $("div[id=idnum]").length;	
$("div[id=status]").text('This will take a few seconds...'); //  for an id status message	
$( "div[id=idnum]").each(function (i) {
	 var id_number = $("div[id=idnum]").eq(i).text();
	 bestsingleship(id_number,i); // call the ajax loader which creates xmlhttp variable. 
  });
//$("div[id=status]").text('All records processed.').css('color', '#0A733B');	 //lft this out because the 
}


function bestsingleship(id_number,index)
{
	var xmlhttp = new XMLHttpRequest(); // define the latest instance
	
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
 		{ var my_JSON_object = JSON.parse(xmlhttp.responseText)
//		  var id_value = $("div[id=idnum]").eq(index).text();
		  if ((my_JSON_object[0].carrier) == null)
		     {$("div[id=carrier]").eq(index).text('Error').css('color', '#B50000');
			  $("div[id=quotenum]").eq(index).text('Error').css('color', '#B50000');
			  $("div[id=trantime]").eq(index).text('Error').css('color', '#B50000');
			  $("div[id=cost]").eq(index).text('Error').css('color', '#B50000');	
			 }
		  else	 
			  {   $("div[id=carrier]").eq(index).text(my_JSON_object[0].carrier);
				  $("div[id=quotenum]").eq(index).text(my_JSON_object[0].quote);
				  $("div[id=trantime]").eq(index).text(my_JSON_object[0].time);
				  $("div[id=cost]").eq(index).text(my_JSON_object[0].cost);			  			  
			  }
		  rec_count = rec_count + 1;	

		  if (rec_count != rec_tot)
		  	{ statmsg = "Calculated estimates for " + rec_count + " of " + rec_tot + " records.";
			  $("div[id=status]").text(statmsg);	 
			}
		 else 	
		   { statmsg = "All " + rec_count + " records were processed.";
		     $("div[id=status]").text(statmsg);	 
		   }

		}
	  
	  }

	xmlhttp.open("GET","www.example.com?q="+parameter,true);
//	xmlhttp.open("POST","swww.example.com?id_number="+id_number+"&fromzip="+fromzip+"&tozip="+tozip+"&po="+po+"&weight="+weight,true);	
	xmlhttp.send();
}
