<?php

use App\Order;
use App\Transaction;
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
function bulatkan($number) {
    // Pembulatan ke bawah jika sisa kurang dari 500, atau ke atas jika lebih dari 500
    return round($number / 1000) * 1000;
}
function rp($num){
  return 'Rp '.number_format($num,0,'.',',');
}
function num($num){
  return number_format($num,0,'.',',');
}
function dateFormat($d){
  return date('d M Y',strtotime($d));
}


function getMonthStartEndDates($monthOffset) {
    $startOfMonth = Carbon::now()->startOfMonth()->subMonths($monthOffset);
    $endOfMonth = Carbon::now()->endOfMonth()->subMonths($monthOffset);
    return [$startOfMonth, $endOfMonth];
}
function trx()
{
    // Get the current year and month
    $year = date('y');
    $month = date('m');
    
    // Convert month number to Roman numeral
    $romanMonth = convertToRoman($month);
    
    // Get the last order number from the database and add 100 to it
    $lastOrder = (Transaction::count() + 1) + 100;

    // Construct the invoice number
    $invoiceNumber = sprintf("%02d%03d/QNP-ACC/%s/%d", $year, $lastOrder, $romanMonth, date('Y'));

    return $invoiceNumber;
}

// Function to convert a number to Roman numeral
function convertToRoman($num)
{
    $roman = '';
    $lookup = [
        'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
        'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
        'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
    ];

    foreach ($lookup as $symbol => $value) {
        while ($num >= $value) {
            $roman .= $symbol;
            $num -= $value;
        }
    }

    return $roman;
}

function cutStr($string, $length = 50) {
    // Check if the length of the string is greater than the specified length
    if (strlen($string) > $length) {
        // Truncate the string to the specified length
        $string = substr($string, 0, $length);
        // Append "..." to indicate that the string has been truncated
        $string .= "...";
    }
    // Return the truncated string
    return $string;
}

function Base64($image_path){
    // Read the image file and encode it to Base64
    $base64_image = base64_encode(file_get_contents($image_path));

    // Output the Base64-encoded string
    return $base64_image;
}

function terbilang($angka) {
    $bilangan = [
        '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan'
    ];

    $temp = '';
    if ($angka < 10) {
        $temp = $bilangan[$angka];
    } elseif ($angka < 20) {
        $temp = terbilang($angka - 10) . ' Belas';
    } elseif ($angka < 100) {
        $temp = terbilang($angka / 10) . ' Puluh ' . terbilang($angka % 10);
    } elseif ($angka < 200) {
        $temp = 'Seratus ' . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        $temp = terbilang($angka / 100) . ' Ratus ' . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        $temp = 'Seribu ' . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        $temp = terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        $temp = terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
    } elseif ($angka < 1000000000000) {
        $temp = terbilang($angka / 1000000000) . ' Milyar ' . terbilang($angka % 1000000000);
    }

    return $temp;
}

function df($time){
    return date('d M Y',strtotime($time));
}
