<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', function (Request $request) {
    $validate = Validator::make($request->all(), [
        'email' => 'required',
        'password' => 'required',
    ]);

    if ($validate->fails()) {
        $response = [
            'message' => 'harap isi email dan password',
            'status' => 'failed',
            'code' => 202,
        ];
        return response()->json($response, 400);
    }

    $user = User::where('email', $request->email)->first();
    if ($user == null) {
        $response = [
            'message' => 'email tidak ditemukan',
            'status' => 'failed',
            'code' => 202,
        ];
        return response()->json($response, 200);
    }
    if (!Hash::check($request->password, $user->password, [])) {
        $response = [
            'message' => 'password anda salah',
            'status' => 'failed',
            'code' => 202,
        ];
        return response()->json($response, 200);
    }
    $token = Str::random(60);
    $user->update(['remember_token' => $token]);
    $user = User::whereRememberToken($token)->first();
    $response = [
        'message' => 'Berhasil masuk',
        'status' => 'success',
        'code' => 201,
        'user' => $user
    ];
    return $response;
});

Route::post('check-login', function (Request $request) {
    if ($request->token == null) {
        return [
            'message' => 'Token telah kadaluarsa',
            'status' => 'failed',
            'code' => 202,
        ];
    }
    $user = User::whereRememberToken($request->token)->first();
    if ($user == null) {
        return [
            'message' => 'Token telah kadaluarsa',
            'status' => 'failed',
            'code' => 202,
        ];
    } else {
        if ($request->device_key != null) {
            $user->update(["device_key" => $request->device_key]);
        }
        return [
            "message" => "Selamat datang kembali",
            'status' => 'success',
            'code' => 201,
            'user' => $user
        ];
    }
});

Route::post('logout', function (Request $request) {
    $user = User::whereRememberToken($request->token)
        ->update([
            "remember_token" => ""
        ]);
    return [
        "message" => "Anda berhasil logout",
        'status' => 'success',
        'code' => 201,
    ];
});


Route::middleware('checkToken')->group(function () {
    Route::get('/waste-bank/waste-total/{id}', function ($id) {
        $customer = DB::select("
SELECT SUM(waste_deposit_details.amount) AS amount,waste_types.title
FROM users
JOIN waste_deposits ON waste_deposits.user_id=users.id
JOIN waste_deposit_details ON waste_deposit_details.waste_deposit_id=waste_deposits.id
JOIN waste_types ON waste_deposit_details.waste_type_id=waste_types.id
WHERE users.waste_bank_id=$id
GROUP BY waste_types.title");
        if (count($customer) == 0) {
            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'tidak ada nasabah',
            ];
        } else {
            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'berhasil menampilkan nasabah',
                'waste' => $customer
            ];
        }
    });


    Route::get('/customer/waste-total/{id}', function ($id) {
        $customer = DB::select("
SELECT SUM(waste_deposit_details.amount) AS amount,waste_types.title,users.name,users.id
FROM users
JOIN waste_deposits ON waste_deposits.user_id=users.id
JOIN waste_deposit_details ON waste_deposit_details.waste_deposit_id=waste_deposits.id
JOIN waste_types ON waste_deposit_details.waste_type_id=waste_types.id
WHERE users.waste_bank_id=$id
GROUP BY waste_types.title,users.name,users.id");
        if (count($customer) == 0) {
            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'tidak ada nasabah',
            ];
        } else {
            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'berhasil menampilkan nasabah',
                'customers' => $customer
            ];
        }
    });

    Route::get('/customer/waste-bank/{id}', function ($id) {
        $customer = User::whereWasteBankId($id)->ordeBy('pickup_status_id');
        if ($customer->get()->count() == $customer->wherePickupStatusId(3)->get()->count()) {
            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'seluruh nasabah telah dijemput',
                'user' => $customer->get()
            ];
        }
        if ($customer->get()->count() == 0) {
            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'tidak ada nasabah',
            ];
        } else {
            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'berhasil menampilkan nasabah',
                'data' => $customer->get()
            ];
        }
    });
});
