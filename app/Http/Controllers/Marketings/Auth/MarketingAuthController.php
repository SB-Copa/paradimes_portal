<?php

namespace App\Http\Controllers\Marketings\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MarketingAuthController extends Controller
{
    //

    public function __construct(){

    }

    public function login(Request $request){
        
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);



        if(Auth::guard('marketing_users_session')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])){
            $request->session()->regenerate();
            // return redirect()->intended('/admin'); 

            session()->save();

            // Update the session row AFTER it exists
            DB::table('sessions')->where('id', session()->getId())->update([
                'authenticatable_id' => Auth::guard('marketing_users_session')->id(),
                'authenticatable_type' => get_class(Auth::guard('marketing_users_session')->user()),
            ]);
            

            return response()->json('Authenticated');
        }else{
            return response()->json('Unauthenticated');
        }

        //Stateless

        
        // $user = MarketingOwnerModel::where('email', $request->username)->first();
        

        // if (! $user || ! Hash::check($request->password, $user->password)) {
        //     return response()->json(['message' => 'Invalid credentials'], 401);
        // }

        // $user->tokens()->delete();
        // $token = $user->createToken('marketing-api-token')->plainTextToken;
        


        // return response()->json([
        //     'user' => $user,
        //     'token' => $token
        // ]);

    }
}
