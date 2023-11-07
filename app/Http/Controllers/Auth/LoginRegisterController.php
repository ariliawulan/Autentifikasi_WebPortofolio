<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\View\View;
use App\Mail\SendEmail;
use App\Jobs\SendMailJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\ImageManagerStatic as Image;

class LoginRegisterController extends Controller
{

    public function someMethod()
    {
    $filePath = 'storage/file.txt'; 
    $url = Storage::url($filePath);
    // $contents = Storage::get('file.jpg');
    // $exists = Storage::disk('local')->exists('file.jpg');

    // return view('nama_view', ['fileUrl' => $url]);
    // return Storage::download('file.jpg');
    // return Storage::download('file.jpg', $name, $headers);

    }
    

    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard', 'users']);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate ([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'photo' => 'image|nullable|max:1999'
        ]);

        $data = [
            'name'=> $request->name,
            'email' => $request->email,
            'subject' => "Berhasil Register",
            'body' => "Hai. Selamat datang di CV Milik Jaehyuk. Nice To Meet You",
        ];

        if ($request->hasFile('photo')) {
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('photo')->storeAs('photos', $filenameSimpan);
        } 
        else {
            // tidak ada file yang diupload
            dd("fail");
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make ($request->password),
            'photo' => $path
        ]);

        // File::delete(public_path() . 'photos/' . $contents->photo_yang_akan_dihapus);


        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();

        dispatch(new SendMailJob($data));
        return redirect()->route('dashboard')
        ->withSuccess('You have successfully registered & logged in!');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate ([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
            ->withSuccess('You have succesfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }

        return redirect()->route('login')
        ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
        ->withSuccess('You have logged out succesfully!');;
    }   

    public function users()
    {
        $users = User::all();
        return view('users', compact('users'));
    }

    public function usersEdit(string $id) : View
    {
        $user = User::findOrFail($id);
        return view('user.edit', [
            'users' => $user
        ]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'photo'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'name'     => 'required|min:5',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('photo')) {

            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('photo')->storeAs('photos', $filenameSimpan);

            //delete old image
            Storage::delete('storage/photos/'.$user->image);

            //update post with new image
            $user->update([
                'photo'    => $path,
                'name'     => $request->name,
            ]);

        } else {

            //update post without image
            $user->update([
                'name'     => $request->name,
            ]);
        }

        $selectedPhotoSize = $request->input('photoSize');

            if (Storage::exists('photos/' . $user->photo)) {
                
                $originalImagePath = public_path('storage/photos/' . $user->photo);  

                $filenameSimpanThumbnail = 'thumbnail_' . $filename . '_' . time() . '.' . $extension;
                $filenameSimpanSquare = 'square_' . $filename . '_' . time() . '.' . $extension;
            
                if ($selectedPhotoSize === 'thumbnail') {
                    $resizedImage = Image::make($originalImagePath);
                    $resizedImage->fit(160, 90);
                    $resizedImage->save(public_path('public/storage/thumbnails/' . $filenameSimpanThumbnail));
                } 
                
                elseif ($selectedPhotoSize === 'square') {
                    $resizedImage = Image::make($originalImagePath);
                    $resizedImage->fit(200, 200);
                    $resizedImage->save(public_path('public/storage/square/' . $filenameSimpanSquare));
                }

                dd($filenameSimpanThumbnail, $filenameSimpanSquare);
            }

        $user->save();
        return redirect()->route('users');
    }
}
