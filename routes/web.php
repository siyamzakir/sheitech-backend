<?php

use App\Http\Controllers\Nova\LoginController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login.page');
});

Route::get('/admin-login', [LoginController::class, 'loginPage'])->name('login.page');
Route::post('login-check', [LoginController::class, 'loginCheck'])->name('admin-login-check');

Route::get('/order/invoice/{id}', [OrderController::class, 'orderInvoiceGenerate'])->name("order.invoice");
Route::get('/guest-order/invoice/{id}', [OrderController::class, 'guestOrderInvoiceGenerate'])->name("guest.order.invoice");
Route::get('/order/test', [OrderController::class, 'text']);


//import data from csv

Route::get('/area',function (){
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//create table

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    $path = asset('/areas.csv');
    $file = fopen($path, 'r');
    $header = fgetcsv($file);
    $data = [];
    while ($row = fgetcsv($file)) {
        $data[] = array_combine($header, $row);
    }
    fclose($file);
    foreach ($data as $item){
        \App\Models\System\Area::create([
            'id' => $item['id'],
            'city_id' => $item['city_id'],
            'name' => $item['name'],
//            'shipping_charge' => $item['shipping_charge'],
        ]);
    }
    return "success";
});


