<?php
/*
***************************************** 
This program reads a table of all valid zip codes in the U.S. and queries a website to read the list of dealers for that company. 
Steps to complete before you run the code: 
		1) Load the zipcode data into a temp database. Zip code table has list of zips and their matching latitude and longitude. 
		2) Figure out the dealer web query. 
What the Script does: 
		1) Read the list of all zips and their matching lats and longs. 
		2) Build a URL to query the dealer database for all their dealers. 
		3) Hit up the URL and retrieve the json data. 
		4) Parse JSON data and for each dealer, check if an entry for that dealer has been made in the dealer DB. 
		5) If not, insert a row, and continue for all zips. 
		6) Wait for an interval of 1 sec between URL lookups to prevent blacklisting. 
		7) Sleep when the query is complete. 		 
		8) If a zip does not ret
***************************************** 
*/
mysql_connect('<Database server>','<Database userid>','<Database Password>');  
mysql_select_db('<Database name>');

$result = mysql_query("select 
                            zip, 
                            state,
                            latt, 
                            longg  
                       from table3  
                            order by zip asc");
$num_rows = mysql_num_rows($result);
if ($num_rows == 0) 
     {  $errstr = "No rows were found bro."; 
        print_r ($errstr);
     } 
else{
//	while($row = mysql_fetch_array($result)) 
$counter = 0;
$store_counter = 0;	
$dup_counter = 0;
//	while($counter <= 25) 	
while($row = mysql_fetch_array($result)) 
     {	  
//     	  $row = mysql_fetch_array($result);	
	      $zip = $row['zip'];  
	      $state = $row['state'];  
	      $latt = $row['latt'];  
	      $longg = $row['longg'];  
	      $url="<< Enter dealer information here>> ";
	      print_r($url);
	      	$counter = $counter + 1;
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 4);
			$json = curl_exec($ch);
			curl_close($ch);
			sleep(1);
			if(!$json) {
				print_r("This zip has no data on stores".$url);
			  }	      
			else{
				$data_return = json_decode($json, true);
//				print_r($data_return);
				foreach ($data_return as $key => $value) {
//					print_r($value['post_title']);
					$store_name = $value['post_title'];
					$store_address1 = $value['address'];
					$store_address2 = $value['address2'];
					$store_city = $value['city'];
					$store_state = $value['state'];
					$store_zip = $value['zip'];
					$store_phone = $value['phone'];
					$store_email = $value['email'];
//Check if the entry exists.
					$existingstore = mysql_query("select * 
												  from store_list 
												  where store_name = '$store_name' and 
                                                        store_city = '$store_city' and 
                                                        store_state = '$store_state' and 
                                                        store_zip = '$store_zip'
                                                        ");   
					$num_rows2 = mysql_num_rows($existingstore);
//					print_r("Num-rows:".$num_rows2);
					if($num_rows2 < 1){
						 $insertSignup = mysql_query("insert into store_list (store_name, store_address1, store_address2, store_city, store_state, store_zip, store_phone, store_email) 
						 	                          values ('$store_name','$store_address1','$store_address2', '$store_city', '$store_state', '$store_zip', '$store_phone', '$store_email')");
			
						if($insertSignup){ //if insert is successful	
							$store_counter = $store_counter + 1;
							}
						else { //if insert fails
								print_r("Error inserting store with name ".$store_name);
						     }
					  }
					  else {$dup_counter = $dup_counter + 1;}
			    } 

     }         
	}   
	}  
print_r("Counter: ".$counter);
print_r("Store Counter:".$store_counter);
print_r("Dup Counter:".$dup_counter);

?>