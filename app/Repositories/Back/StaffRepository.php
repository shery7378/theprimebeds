<?php

namespace App\Repositories\Back;

use App\{
    Models\Admin,
    Models\User,
    Models\Role,
    Helpers\ImageHelper
};
use Illuminate\Support\Str;

class StaffRepository
{

    /**
     * Store Admin.
     *
     * @param  \App\Http\Requests\AdminRequest  $request
     * @return void
     */

    public function store($request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($request['password']);
        $input['photo'] = ImageHelper::handleUploadedImage($request->file('photo'),'images');
        $admin = Admin::create($input);

        // Sync with frontend User if role is 'merchant'
        $role = Role::find($request->role_id);
        if ($role && strtolower($role->name) == 'merchant') {
            $names = explode(' ', $request->name, 2);
            $firstName = $names[0];
            $lastName = isset($names[1]) ? $names[1] : '';
            
            // Check if user already exists
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $user = new User();
            }
            
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->is_merchant = 1;
            
            // Generate unique store name
            $baseSlug = Str::slug($request->name);
            $slug = $baseSlug;
            $counter = 1;
            while (User::where('store_name', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $user->store_name = $slug;
            $user->save();
        }
    }

    /**
     * Update Admin.
     *
     * @param  \App\Http\Requests\AdminRequest  $request
     * @return void
     */

    public function update($staff, $request)
    {
        $oldEmail = $staff->email;
        $oldRole = $staff->role;
        $wasMerchant = ($oldRole && strtolower($oldRole->name) == 'merchant');

        $input = $request->all();
        if ($request->password) {
            $input['password'] = bcrypt($request['password']);
        } else {
            unset($input['password']);
        }
        if ($file = $request->file('photo')) {
            $input['photo'] = ImageHelper::handleUpdatedUploadedImage($file,'images',$staff,'images','photo');
        }
        $staff->update($input);

        $role = Role::find($request->role_id);
        $isMerchant = ($role && strtolower($role->name) == 'merchant');

        if ($isMerchant) {
            $names = explode(' ', $request->name, 2);
            $firstName = $names[0];
            $lastName = isset($names[1]) ? $names[1] : '';

            $user = User::where('email', $oldEmail)->first();
            if (!$user) {
                $user = User::where('email', $request->email)->first();
            }
            if (!$user) {
                $user = new User();
            }

            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->is_merchant = 1;

            if (!$user->store_name) {
                $baseSlug = Str::slug($request->name);
                $slug = $baseSlug;
                $counter = 1;
                while (User::where('store_name', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                $user->store_name = $slug;
            }
            $user->save();
        } else {
            // If it was a merchant but is no longer
            if ($wasMerchant) {
                $user = User::where('email', $oldEmail)->first();
                if ($user) {
                    $user->delete();
                }
            }
        }
    }

    /**
     * Delete category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($staff)
    {
        $oldRole = $staff->role;
        $wasMerchant = ($oldRole && strtolower($oldRole->name) == 'merchant');

        ImageHelper::handleDeletedImage($staff,'photo','images');
        $staff->delete();

        if ($wasMerchant) {
            $user = User::where('email', $staff->email)->first();
            if ($user) {
                $user->delete();
            }
        }
    }

}

