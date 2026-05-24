<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class AuthControllerAntiguo extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email o Contaseña son incorrectas.',
        ]);
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol_id' => 2,
        ]);

        Auth::login($user);

        return redirect('/comunidad');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgotPassword');
    }


    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return back()->with('error', 'No se encuentra el correo');
        }
       //guardamos el email
        $request->session()->put('email', $request->email);
        return redirect('/resetearContrasena');
    }

    public function showResetPasswordForm()
    {
        if (!session()->has('email')) {
            return redirect('/olvideContrasena');
        }
        return view('auth.resetPassword');
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        
        $email = $request->session()->get('email');
        if (!$email) {
            return back()->with('error', 'No se encuentra el correo');
        }
        $user = User::where('email', $email)->first();
        $user->password = bcrypt($request->password);
        $user->save();
        session()->forget('email');
        return redirect('/login');
    }
    public function logout(Request $request) 
    {
        Auth::logout();
        
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
