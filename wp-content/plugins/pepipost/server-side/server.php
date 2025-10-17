<?php
include( "http://plugin.datagrid.co.in/wordpress/wp-content/plugins/pepipost/common_functions.php" );
 echo "here";
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
//$table = 'datatables_demo';
 
// Table's primary key
//$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes


$logs_key = get_option('wpp_api_key');
if($logs_key!='')
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.pepipost.com/v2/logs?startdate=2018-01-01&limit=1000000&sort=desc",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 550,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "api_key: ".$logs_key
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
   // print_r($response); exit();
    curl_close($curl);

    if ($err) {
      $rows=array();
    } else {
      $rows=json_decode($response,true);
    }
}


$columns = array(
    array( 'data' => 'fromaddress', 'dt' => 0 ),
    array( 'data' => 'rcptEmail', 'dt' => 1  ),
    array( 'data' => 'size', 'dt' => 2 ),
    array( 'data' => 'deliveryTime', 'dt' => 3 ),
    array( 'data' => 'modifiedTime', 'dt' => 4  ),
    array( 'data' => 'status', 'dt' => 5 ),
    array( 'data' => 'remarks', 'dt' => 6 ),
    
);
 
// SQL server connection information
// $sql_details = array(
//     'user' => '',
//     'pass' => '',
//     'db'   => '',
//     'host' => ''
// );
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $response, $columns )
);