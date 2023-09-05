<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    // Login Methods
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    // Register User Methods
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'role' => 'required',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'role' => $request->get('role'),
            'password' => Hash::make($request->get('password')),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
    }

    // Edit User Methods
    public function edit(Request $request, $id)
        {
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:255',
                'role' => 'required|string',
                'password' => 'required|string|min:6',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }

            $ubah = User::where('id',$id)->update([
                'name' => $request->get('name'),
                'role' => $request->get('role'),
                'password' => Hash::make($request->get('password')),
            ]);

            if($ubah){
                return response()->json(['status'=>true, 'message' =>'Sukses Mengubah User']);
            } else {
                return response()->json(['status'=>false, 'message' =>'Gagal Mengubah User']);
            }
        }

    // Edit User Methods Ver. 02
    public function edit2(Request $request, $id)
    {
               
            $edit_user = User::find($id);
            $edit_user->name = $request->name;
            $edit_user->username = $request->username;
            $edit_user->password = $request->password;
            $edit_user->role = $request->role;
            $edit_user->save();
            

            if($ubah){
                return response()->json(['status'=>true, 'message' =>'Sukses Mengubah User']);
            } else {
                return response()->json(['status'=>false, 'message' =>'Gagal Mengubah User']);
            }
        }

    // Delete User Methods
    public function delete($id)
        {
            $hapus=User::where('id',$id)->delete();
            if($hapus){
                return Response()->json(['status'=>true, 'message' =>'Sukses Hapus Users']);
            } else {
                return Response()->json(['status'=>false, 'message' =>'Gagal Hapus Users']);
            }
        }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

    // Info ID Admin Methods
    public function profile_admin() {
        return response()->json(JWTAuth::user());
    }

    // Info ID Kasir Methods
    public function profile_kasir() {
        return response()->json(JWTAuth::user());
    }

    // Info ID Manager Methods
    public function profile_manager() {
        return response()->json(JWTAuth::user());
    }

    // Logout Methods
    public function logout() {
        auth()->logout();
        $token = JWTAuth::getToken();
    if ($token) {
        JWTAuth::setToken($token)->invalidate();
    }
        return response()->json([
            'status' => 'success',
            'message' => 'logout'
        ], 200);
    }

    // Get Data
    public function get()
    {
        $dt_user=User::get();
        return response()->json($dt_user);
    }

}