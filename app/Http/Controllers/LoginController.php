<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\taikhoan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Mail; 
use Illuminate\Auth\Events\Verified; 
use Illuminate\Support\Str;

use stdClass; 

class LoginController extends Controller
{
    public function signUp(Request $request){
        $Validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email:191|unique:taikhoans',
            'password' => 'required|max:191|min:6',
            'confirmPassword' => 'required|same:password',
            'gender' => 'required',
        ]);

        if($Validator->fails()){
            return response()->json([
                'validation_errors' => $Validator->messages(), 422
            ]);
        }
        else{
            $taikhoan = taikhoan::create([
                'ten' => $request->name,
                'email' => $request->email,
                'GIOITINH' => $request->gender,
                'password' =>Hash::make($request->password),
                'ROLE' => $request->role,
                'AdminVerify' => $request->adminVerify,
            ]);
            
            $taikhoan->sendEmailVerificationNotification(); 

            return response()->json([
                'status' => 200, 
            ]);
        }
    }

    public function verify(Request $request) {
        // Tìm người dùng có ID tương ứng trong request
        $matk = $request->route('id');
        $taikhoan = taikhoan::where('MATK', $matk)->firstOrFail();
        $email = DB::table('taikhoans')->where('MATK', $matk)->value('EMAIL');

        // Kiểm tra xem hash truyền vào có khớp với hash của người dùng không
        if (! hash_equals((string) $request->route('hash'), sha1($email))) {
            return response()->json(['message' => 'Invalid verification link'], 400);
        }

        // Kiểm tra xem người dùng đã xác nhận email trước đó chưa
        if ($taikhoan->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        // Xác nhận email cho người dùng và gửi event Verified
        if ($taikhoan->markEmailAsVerified()) {
            event(new Verified($taikhoan));
        }

        return response()->json(['message' => 'Email verified'], 200);
    }

    public function signIn(Request $request){ 
        $taikhoan = taikhoan::where('email', $request->email)->first();   

        $validator = Validator::make($request->all(), [
            'email' => 'required|email:191',
            'password' => 'required',
        ]);
        
        if($validator->fails())
        {
            return response()->json([
            'validation_errors' =>$validator->messages(),
            ]);
        }
        else
        {
            if(!$taikhoan) { 
                $data = new stdClass();
                $data = "Email không tồn tại"; 
                return response()->json([
                    'status'=>401,
                    'validation_errors' => $data,
                ]);  
            }
            else if(!Hash::check($request->password,$taikhoan->PASSWORD)){
                $data = new stdClass();
                $data = "Mật khẩu sai";
                return response()->json([
                    'status'=>401,
                    'validation_errors' => $data,
                ]);
            }
            else { 
                if (is_null($taikhoan->email_verified_at)) { 
                    $data = new stdClass();
                    $data = "Tài khoản chưa được xác nhận";
                    return response()->json([
                        'status'=>401,
                        'validation_errors' => $data,
                    ]);
                }  
                if ($taikhoan->AdminVerify == 0 && $taikhoan->ROLE == "Nhân viên") { 
                    $data = new stdClass();
                    $data = "Tài khoản chưa được Admin xác nhận";
                    return response()->json([
                        'status'=>401,
                        'validation_errors' => $data,
                    ]);
                } 
                $expiresAt = now()->addHour(); 
                // chưa biết nó sẽ xử lý token thời gian như thế nào nên chưa biết truyền gì vào, có thời gian rảnh thì sẽ mò

                if($taikhoan->ROLE == "Admin"){
                    $abilities = ["nhanvien", "admin"];
                    $token = $taikhoan->createToken($taikhoan->EMAIL, $abilities, $expiresAt)->plainTextToken;
                }
                else if($taikhoan->ROLE == "Nhân viên"){
                    $abilities = ["nhanvien"];
                    $token = $taikhoan->createToken($taikhoan->EMAIL, $abilities, $expiresAt)->plainTextToken;
                }
                else 
                    $token = $taikhoan->createToken($taikhoan->EMAIL, ['*'], $expiresAt)->plainTextToken;
                
                return response()->json([
                    'status' =>200,
                    'email' =>$taikhoan->EMAIL,
                    'matk' => $taikhoan->MATK,
                    'role' => $taikhoan->ROLE,
                    'access_token' => $token,
                    'message' =>'Logged In Successfully', 
                ]); 
            } 
        } 
    }

    public function logout() { 
        Auth::user()->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Logged out Successfully',
        ]);
    }

    public function sendMailRecoverPassword(Request $request) {
        $email = $request->email;
        $taikhoan = taikhoan::where('email', $request->email)->first();
        if (!$taikhoan) { 
            $data = new stdClass();
            $data = "Email không tồn tại"; 
            return response()->json([
                'status'=>401,
                'validation_errors' => $data,
            ]);  
        }
        
        $password = Str::random(10);
        $password_hash = Hash::make($password);
        DB::update("UPDATE taikhoans SET password = '$password_hash' Where EMAIL = '$email'");
        Mail::send('mailRecoverPassword', ['password' => $password], function($message) use ($email){
            $message->to($email)->subject('Khôi phục mật khẩu'); 
        });
        return response()->json([
            'status'=> 200,  
        ]);  
    }
}
