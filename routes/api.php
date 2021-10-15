<?php

use App\Models\User;
use App\Models\WasteDeposit;
use App\Models\WasteDepositDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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


Route::post('/mapping/update', function (Request $request) {
    User::find($request->id)->update([
        'name' => $request->name,
        'address' => $request->address,
        'phone' => $request->phone,
    ]);
    return [
        'message' => 'berhasil mengubah data',
        'code' => 201,
        'error' => ''
    ];
});

Route::post('/mapping/update/location', function (Request $request) {
    User::find($request->id)->update([
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);
    return [
        'message' => 'berhasil menyesuaikan lokasi',
        'code' => 201,
        'error' => ''
    ];
});

Route::post('/mapping/update/status', function (Request $request) {
    User::find($request->id)->update([
        'pickup_status_id' => $request->status,
    ]);
    return [
        'message' => 'berhasil mengubah status',
        'code' => 201,
        'error' => ''
    ];
});
Route::post('/mapping/update/photo', function (Request $request) {
    $file = $request->file('file');
    $filename = Str::slug($request->id . '-' . date('Hms')) . '.' . $request->file('file')->getClientOriginalExtension();
    Storage::disk('local')->put('public/mapping/' . $filename, file_get_contents($file));

    User::find(str_replace('"', '', $request->id))->update([
        'profile_photo_path' => 'mapping/' . $filename,
    ]);

    return [
        'message' => 'berhasil mengubah foto',
        'code' => 201,
        'error' => ''
    ];
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
Route::post('mapping/store', function (Request $request) {
//    protected $fillable = ['user_id', 'note', 'created_at', 'updated_at'];
    $wd = WasteDeposit::create(['user_id' => $request->user_id,'note'=>$request->note]);
    if ($request->plastic == null) {
        $request->plastic = 0;
    }
    if ($request->iron == null) {
        $request->iron = 0;
    }
    if ($request->paper == null) {
        $request->paper = 0;
    }
    WasteDepositDetail::create([
        'waste_deposit_id' => $wd->id,
        'waste_type_id' => 3,
        'amount' => $request->plastic,
        'price' => 0,]);
    WasteDepositDetail::create([
        'waste_deposit_id' => $wd->id,
        'waste_type_id' => 2,
        'amount' => $request->iron,
        'price' => 0,]);
    WasteDepositDetail::create([
        'waste_deposit_id' => $wd->id,
        'waste_type_id' => 1,
        'amount' => $request->paper,
        'price' => 0,]);
    return [
        'status' => 'success',
        'code' => 200,
        'message' => 'Berhasil input sampah',
    ];
});

Route::post('mapping/update', function (Request $request) {
//    protected $fillable = ['user_id', 'note', 'created_at', 'updated_at'];
    $wd = WasteDeposit::find($request->id)->update(['note'=>$request->note]);
    WasteDepositDetail::whereWasteDepositId($request->id)->delete();
    if ($request->plastic == null) {
        $request->plastic = 0;
    }
    if ($request->iron == null) {
        $request->iron = 0;
    }
    if ($request->paper == null) {
        $request->paper = 0;
    }
    WasteDepositDetail::create([
        'waste_deposit_id' => $wd->id,
        'waste_type_id' => 3,
        'amount' => $request->plastic,
        'price' => 0,]);
    WasteDepositDetail::create([
        'waste_deposit_id' => $wd->id,
        'waste_type_id' => 2,
        'amount' => $request->iron,
        'price' => 0,]);
    WasteDepositDetail::create([
        'waste_deposit_id' => $wd->id,
        'waste_type_id' => 1,
        'amount' => $request->paper,
        'price' => 0,]);
    return [
        'status' => 'success',
        'code' => 200,
        'message' => 'Berhasil input sampah',
    ];
});

//Route::middleware('checkToken')->group(function () {
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


//Route::get('/customer/waste-total/{id}', function ($id) {
//    $customer = DB::select("
//SELECT SUM(waste_deposit_details.amount) AS amount,waste_types.title,users.name,users.id
//FROM users
//JOIN waste_deposits ON waste_deposits.user_id=users.id
//JOIN waste_deposit_details ON waste_deposit_details.waste_deposit_id=waste_deposits.id
//JOIN waste_types ON waste_deposit_details.waste_type_id=waste_types.id
//WHERE users.waste_bank_id=$id
//GROUP BY waste_types.title,users.name,users.id");
//    if (count($customer) == 0) {
//        return [
//            'status' => 'success',
//            'code' => 200,
//            'message' => 'tidak ada nasabah',
//        ];
//    } else {
//        return [
//            'status' => 'success',
//            'code' => 200,
//            'message' => 'berhasil menampilkan nasabah',
//            'customers' => $customer
//        ];
//    }
//});

Route::get('/customer/waste-bank/{id}', function ($id) {
    $customer = User::whereWasteBankId($id)->orderBy('pickup_status_id')->get();
        return [
            'status' => 'success',
            'code' => 200,
            'message' => 'berhasil menampilkan nasabah',
            'users' => $customer
        ];
});
Route::get('/customer/waste-bank/detail/{id}', function ($id) {
    $customer = WasteDeposit::with('wasteDepositDetails')->whereUserId($id)->get();
    return [
        'status' => 'success',
        'code' => 200,
        'message' => 'berhasil menampilkan data penjemputan',
        'wasteDeposits' => $customer
    ];
});

Route::get('/customer/waste-bank/detail/deposit/{id}', function ($id) {
    $customer = WasteDeposit::with('wasteDepositDetails')->whereUserId($id)->get();
    return [
        'status' => 'success',
        'code' => 200,
        'message' => 'berhasil menampilkan data penjemputan',
        'wasteDeposits' => $customer
    ];
});
