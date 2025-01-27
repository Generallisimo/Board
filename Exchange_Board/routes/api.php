<?php

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('top_up/{wallet}/{hash_id}', ['as' => 'api.update', 'uses' => 'App\Http\Controllers\TopUp\UpdateController']);

Route::group(['prefix'=>'payment', 'middleware' => ['web']], function(){
    Route::get('/{client_id}/{amount}/{currency}', ['as' => 'payment.index', 'uses' => 'App\Http\Controllers\Exchanges\IndexController']);
    Route::get('/{client}/{amount}/{currency}/{market}/{exchange_id}', ['as' => 'payment.create', 'uses' => 'App\Http\Controllers\Exchanges\CreateController']);
    Route::post('/{exchange_id}', ['as' => 'payment.store', 'uses' => 'App\Http\Controllers\Exchanges\StoreController']);
    Route::get('/update/{exchange}', ['as' => 'payment.update', 'uses' => 'App\Http\Controllers\Exchanges\UpdateController']);
});

Route::group(['prefix'=>'support'], function(){
    Route::post('/store', ['as'=>'support.store', 'uses'=>'App\Http\Controllers\Support\StoreController']);
});

Route::group(['prefix'=>'pay'], function(){
    Route::get('/{currency}/{amount}/{api_key}', ['as'=>'api_key.store', 'uses'=>'App\Http\Controllers\ApiExchange\StoreController']);
    Route::get('/show/{exchange_id}', ['as'=>'api_key.update', 'uses'=>'App\Http\Controllers\ApiExchange\UpdateController']);
});

Route::group(['middleware' => ['web']], function(){
    Route::get('/turnover/{period}/{hash_id}', ['as'=>'home.show', 'uses'=>'App\Http\Controllers\HomeController@show']);
});

Route::group(['prefix'=>'bot', 'middleware' => ['api']], function(){
    Route::group(['prefix'=>'transactions'], function(){
        Route::get('/{status}', ['uses'=>'App\Http\Controllers\Bot\Transactions\IndexController']);
        Route::get('/id/{exchange_id}', ['uses'=>'App\Http\Controllers\Bot\Transactions\ShowController']);
    });
    Route::group(['prefix'=>'personal'], function(){
        Route::get('/{hash_id}', ['uses'=>'App\Http\Controllers\Bot\Personal\IndexController']);
        Route::get('/update/{hash_id}', ['uses'=>'App\Http\Controllers\Bot\Personal\UpdateController']);
        
        Route::group(['prefix'=>'wallet'], function(){
            Route::put('/update/{hash_id}/{details_to}', ['uses'=>'App\Http\Controllers\Bot\Personal\Wallet\UpdateController']);
        });
        
        Route::group(['prefix'=>'details'], function(){
            Route::get('/show/{detail_id}', ['uses'=>'App\Http\Controllers\Bot\Personal\Details\ShowController']);
            Route::put('/update/{detail_id}', ['uses'=>'App\Http\Controllers\Bot\Personal\Details\UpdateController']);
            Route::put('/delete/{detail_id}', ['uses'=>'App\Http\Controllers\Bot\Personal\Details\DeleteController']);
            
            Route::group(['prefix'=>'card'], function(){
                Route::put('/update/{id}/{detail_id}', ['uses'=>'App\Http\Controllers\Bot\Personal\Details\Card\UpdateController']);
                Route::post('/store/{hash_id}/{details_market_to}/{name_method}/{comment}', ['uses'=>'App\Http\Controllers\Bot\Personal\Details\Card\StoreController']);
                // Route::post('/store/{hash_id}/{detail_market_to}/{name_method}/{comment}',function () {
                //     return response()->json(['status' => 'POST route is working']);
                // });
            });
        });
    });
});

Route::group(['prefix'=>'botUAH', 'middleware' => ['api']], function(){
    Route::post('/auth', ['uses'=>'App\Http\Controllers\BotUAH\Users\IndexController']);
    Route::group(['prefix'=>'users'], function(){
        Route::post('/store', ['uses'=>'App\Http\Controllers\BotUAH\Users\StoreController']);
        Route::get('/market_online/show', ['uses'=>'App\Http\Controllers\BotUAH\Users\MarketOnline\ShowController']);
        Route::get('/show', ['uses'=>'App\Http\Controllers\BotUAH\Users\ShowController']);
    });
    Route::group(['prefix'=>'withdrawal'], function(){
        Route::post('/update', ['uses'=>'App\Http\Controllers\BotUAH\Balance\UpdateController']);
    });
    Route::group(['prefix'=>'top_up'], function(){
        Route::post('/store', ['uses'=>'App\Http\Controllers\BotUAH\Balance\StoreController']);
    });
    Route::group(['prefix'=>'change_status'], function(){
        Route::post('/update', ['uses'=>'App\Http\Controllers\BotUAH\Market\UpdateController']);
    });
    Route::group(['prefix'=>'add_details_market'], function(){
        Route::post('/store', ['uses'=>'App\Http\Controllers\BotUAH\Market\Wallet\StoreController']);
        Route::post('/update', ['uses'=>'App\Http\Controllers\BotUAH\Market\Wallet\UpdateController']);
        Route::post('/update/status', ['uses'=>'App\Http\Controllers\BotUAH\Market\Wallet\UpdateStatusController']);
        Route::get('/show', ['uses'=>'App\Http\Controllers\BotUAH\Market\Wallet\ShowController']);
        Route::get('/show/index', ['uses'=>'App\Http\Controllers\BotUAH\Market\Wallet\IndexController']);
        Route::post('/delete', ['uses'=>'App\Http\Controllers\BotUAH\Market\Wallet\DeleteController']);
    });
    Route::group(['prefix'=>'change_details'], function(){
        Route::post('/update', ['uses'=>'App\Http\Controllers\BotUAH\Market\Withdrawal\UpdateController']);
    });
    Route::group(['prefix'=>'check_balance'], function(){
        Route::post('/update', ['uses'=>'App\Http\Controllers\BotUAH\Users\Wallet\UpdateController']);
    });
    Route::group(['prefix'=>'binance'], function(){
        Route::post('/index', ['uses'=>'App\Http\Controllers\BotUAH\Binance\P2P\IndexController']);
        Route::post('/store', ['uses'=>'App\Http\Controllers\BotUAH\Binance\P2P\StoreController']);
        Route::post('/update', ['uses'=>'App\Http\Controllers\BotUAH\Binance\P2P\UpdateController']);
        Route::get('/show/all', ['uses'=>'App\Http\Controllers\BotUAH\Binance\P2P\ShowAllController']);
        Route::get('/show', ['uses'=>'App\Http\Controllers\BotUAH\Binance\P2P\ShowController']);
        Route::group(['prefix'=>'exchange'], function(){
            Route::get('/index', ['uses'=>'App\Http\Controllers\BotUAH\Binance\Exchange\IndexMarketController']);
            Route::get('/admin/index', ['uses'=>'App\Http\Controllers\BotUAH\Binance\Exchange\IndexController']);
            Route::get('/show', ['uses'=>'App\Http\Controllers\BotUAH\Binance\Exchange\ShowController']);
            Route::post('/update', ['uses'=>'App\Http\Controllers\BotUAH\Binance\Exchange\UpdateController']);
        });
    });
});



// test for payment api
Route::get('/test/index', function(){
	return view('test_form');
});
Route::post('/test/show', function(Request $request){
    $data = Test::create(['status'=>$request->input('status')]);
	return response()->json($data);
});