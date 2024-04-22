<?php

use App\Order;
use Carbon\Carbon;
use Illuminate\Routing\Route;

function is_active($routeName) {
    return request()->routeIs($routeName) ? 'active' : '';
}

function active_class($path, $active = 'active') {
  return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function is_active_route($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
}

function show_class($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
}
function route_active_class($routeName, $active = 'active') {
    return request()->routeIs($routeName) ? $active : '';
}

function route_is_active_route($routeName) {
    return request()->routeIs($routeName) ? 'true' : 'false';
}

function route_show_class($routeName) {
    return request()->routeIs($routeName) ? 'show' : '';
}


function getAmount($num) {
    // Remove any commas from the string
    $num = str_replace(',', '', $num);
    
    // Remove any non-numeric characters except for periods
    $num = preg_replace('/[^0-9.]/', '', $num);
    
    // Convert the string to a float, and then to an integer
    $amount = (int) round((float) $num);
    
    return $amount;
}
function rp($num){
  return 'Rp '.number_format($num,2,'.',',');
}
function num($num){
  return number_format($num,2,'.',',');
}
function dateFormat($d){
  return date('d M Y',strtotime($d));
}


function getMonthStartEndDates($monthOffset) {
    $startOfMonth = Carbon::now()->startOfMonth()->subMonths($monthOffset);
    $endOfMonth = Carbon::now()->endOfMonth()->subMonths($monthOffset);
    return [$startOfMonth, $endOfMonth];
}

// function trx()
// {
//     // Get the current date in the format 'yymmdd'
//     $date = date('ymd');

//     // Get the last order record from the database
//     $lastOrder = Order::latest()->first();

//     // If there are no existing orders, set the order number to 1
//     $orderNumber = 1;

//     // If there are existing orders, increment the last order number by 1
//     if ($lastOrder) {
//         $orderNumber = $lastOrder->order_number + 1;
//     }

//     // Format the order number with leading zeros if needed (assuming max 9999)
//     $formattedOrderNumber = str_pad($orderNumber, 4, '0', STR_PAD_LEFT);

//     // Concatenate the components to form the transaction number
//     $transactionNumber = 'ORDR' . $date . $formattedOrderNumber;

//     return $transactionNumber;
// }
