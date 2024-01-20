<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Api\Api;
use Modules\Auth\Controllers\AuthController;
use Modules\Control\Controllers\ControlController;
use Modules\Controller\Controllers\ControllerController;
use Modules\Cooling\Controllers\CoolingController;
use Modules\Cpus\Controllers\CpusController;
use Modules\Errors\Services\ErrorsServices;
use Modules\Server\Controllers\ServerController;
use Modules\Status\Controllers\StatusController;
use Modules\Temperatures\Controllers\TemperaturesController;
use Modules\Temperatures\Models\TemperaturesCategories;

Route::group(['prefix' => 'api'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/checkAuth', [AuthController::class, 'getCurrentAuth'])->name('auth.currentAuth');

    // For authorized users
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
    Route::group(['prefix' => 'server'], function () {
        Route::get('/getStatus', [ServerController::class, 'getStatus'])->name('server.getStatus');
        Route::get('/inventory', [ServerController::class, 'inventory'])->name('server.inventory');
        Route::get('/initDevices', [ServerController::class, 'initDevices'])->name('server.initDevices');
        Route::get('/on', [ServerController::class, 'serverOn'])->name('server.serverOn');
        Route::get('/off', [ServerController::class, 'serverOff'])->name('server.serverOff');
        Route::get('/reboot', [ServerController::class, 'serverReboot'])->name('server.serverReboot');
    });
    Route::group(['prefix' => 'temperatures'], function () {
        // Роуты для авторизованных
        Route::get('/getData', [TemperaturesController::class, 'getData'])->name('temperatures.getData');
        Route::get('/getMainData', [TemperaturesController::class, 'getMainData'])->name('temperatures.getMainData');
        Route::get('/getSwitchData', [TemperaturesController::class, 'getSwitchData'])->name('temperatures.getSwitchData');
        Route::get('/getControllerData', [TemperaturesController::class, 'getControllerData'])->name('temperatures.getControllerData');
    });
    Route::group(['prefix' => 'status'], function () {
        Route::get('/getData', [StatusController::class, 'getData'])->name('status.getData');
        Route::get('/getActiveDevices', [StatusController::class, 'getActiveDevices'])->name('status.getActiveDevices');
    });
    Route::group(['prefix' => 'control'], function () {
        Route::get('/getMainPowerData', [ControlController::class, 'getMainPowerData'])->name('control.getMainPowerData');
        Route::get('/getMbCbData', [ControlController::class, 'getMbCbData'])->name('control.getMbCbData');
        Route::get('/rebootAllCB', [ControlController::class, 'rebootAllCB'])->name('control.rebootAllCB');
        Route::get('/rebootSwitch/{id?}', [ControlController::class, 'rebootSwitch'])->name('control.rebootSwitch');
        Route::get('/rebootUsb/{id?}', [ControlController::class, 'rebootUsb'])->name('control.rebootUsb');
        Route::get('/getTemperatures', [ControlController::class, 'getControlData'])->name('control.getTemperatures');
    });
    Route::group(['prefix' => 'cpus'], function () {
        Route::get('/getData', [CpusController::class, 'getData'])->name('cpus.getData');
        Route::post('/powerOn', [CpusController::class, 'powerOn'])->name('cpus.powerOn');
        Route::post('/powerOff', [CpusController::class, 'powerOff'])->name('cpus.powerOff');
        Route::post('/powerReboot', [CpusController::class, 'powerReboot'])->name('cpus.powerReboot');
    });
    Route::group(['prefix' => 'controller'], function () {
        Route::get('/getData', [ControllerController::class, 'getData'])->name('controller.getData');
        Route::get('/powerOff', [ControllerController::class, 'powerOff'])->name('controller.powerOff');
        Route::get('/softReboot', [ControllerController::class, 'softReboot'])->name('controller.softReboot');
        Route::get('/hardReboot', [ControllerController::class, 'hardReboot'])->name('controller.hardReboot');
    });
    Route::group(['prefix' => 'cooling'], function () {
        Route::get('/getData', [CoolingController::class, 'getData'])->name('control.getTemperatures');
    });
    Route::get('/test', function (Api $api, ErrorsServices $errorsServices) {
        $data = $api->get('/temperature/getCpusData');
        dd($data);
    });
});

Route::get('/{any}', fn() => view('spa'))
    ->where('any', '.*')
    ->name('spa');
