<?php

$values = array();

$myfile = fopen("C:\Temp2\green.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
   $row_result = fgets($myfile);
   $row_res_arr = explode(';',$row_result);
    
	$values[] = $row_res_arr[8];
}
fclose($myfile);

//========

$conn = odbc_connect('BlizooInventory', 'user_store', 'Eg@w_f8&p!F^+EZW ');

// $store = 80;

$var_ser = '';

foreach ($values as $value)
{
	 $query = "SELECT COUNT(sitID) as number FROM [Paraflow_IS].[dbo].[PI_tbl_stores_items]
      WHERE sitStoreId = 80 AND sitItemSerial =  '".$value."'";
	  
	  $result = odbc_exec($conn, $query);
	  $e = odbc_fetch_object($result);
	  //print_r($e['number']);
	  $number = $e->number;
	  
	  if($number == 2)
	  {
		  
			$query_select = " SELECT MAX(sitID) as max_number FROM PI_tbl_stores_items WHERE sitStoreId = 80 AND sitItemSerial =  '".$value."' ";
		    $result_sel = odbc_exec($conn, $query_select);
			$o_max = odbc_fetch_object($result_sel);
			$var_ser = $o_max->max_number;
	   
		   $query_delete = "DELETE FROM PI_tbl_stores_items WHERE sitID = '".$var_ser."'";
		  
		   $result_del = odbc_exec($conn, $query_delete);
		  
			// echo  $result_del;
		   // echo  '---------';
		   // echo  $var_ser;
		   
		   
		   
		   
	  }
	  else
	  {
		  echo "------one-------";
		  echo $value; 
	  }
	
	$var_ser = '';
	
}


// $query_select = " SELECT MAX(sitID) FROM PI_tbl_stores_items WHERE sitStoreId = '".$store."' AND sitItemSerial =  '".$id."' ";

// $result = odbc_exec($conn, $query_select);


// if (!$result) 
    // {echo("Error in SQL");} 
    // while($e=odbc_fetch_object($result))	
			// {
			   // $output[] = $e;   
			// }
    // print_r(json_encode($output));


 odbc_close($conn);

?>