<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

use Flasher\Laravel\Facade\Flasher;






class ProfileController extends Controller
{
    

    public function profile()
    {
        $user = auth()->user();
        return view('auth.profile', compact('user'));
    }


    public function editProfile()
    {
        $user = auth()->user();
        return view('auth.edit-profile', compact('user'));
    }

   public function updateProfile(Request $request)
{


 
    $user = auth()->user();



    // Always validate name
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // Validate mobile only if changed
    if ($request->mobile != $user->mobile) {
        $request->validate([
            'mobile' => 'required|string|max:11|unique:users,mobile',
        ]);
        $user->mobile = $request->mobile;
    }

    // Update name
    $user->name = $request->name;


    // Handle profile image upload
    if ($request->hasFile('image')) {
 
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);
 
        $imageName = time() . '.' . $request->image->extension();  
        
        $request->image->move(public_path('profile/images'), $imageName);
        $imagePath = 'profile/images/' . $imageName;
       
        // Delete old image if exists

       $existingImage = Image::where('user_id', $user->id)->first();
        if ($existingImage) {
            // Delete the file from storage
            if (file_exists(public_path($existingImage->image))) {
                unlink(public_path($existingImage->image));
            }
             
            // Delete the database record
            $existingImage->delete();
        }   

        // Save new image
        Image::create([
            'user_id' => $user->id,
            'image' => $imagePath,
        ]);

      
    }

        $user->save();
 
    Flasher::addSuccess('Profile updated successfully!');

    return redirect()->route('user.profile')->with('status', 'Profile updated successfully.');
}



    public function updatePassword(Request $request)
    {
         $user = auth()->user();
    
         $request->validate([
              'current_password' => 'required',
              'new_password' => 'required|string|min:8|confirmed',
         ]);
    
         // Check if current password matches
         if (!Hash::check($request->current_password, $user->password)) {
              return back()->withErrors(['current_password' => 'Current password is incorrect.']);
         }
    
         // Update to new password
         $user->password = Hash::make($request->new_password);
         $user->save();
    
         Flasher::addSuccess('Password updated successfully!');
    
         return redirect()->route('user.profile')->with('status', 'Password updated successfully.');
    }


}
