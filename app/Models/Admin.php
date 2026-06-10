<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = "admin";

    protected $fillable = [
        "name",
        "email",
        "phone",
        "role_id",
        "photo",
        "email_token",
        "password",
    ];

    protected $hidden = ["password"];

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) {
            return asset("assets/img/noimage.png");
        }
        // Check images/ subfolder first (where StaffRepository saves)
        if (file_exists(public_path("assets/img/images/" . $this->photo))) {
            return asset("assets/img/images/" . $this->photo);
        }
        // Fall back to root img folder (legacy / super admin)
        if (file_exists(public_path("assets/img/" . $this->photo))) {
            return asset("assets/img/" . $this->photo);
        }
        return asset("assets/img/noimage.png");
    }

    public function role()
    {
        return $this->belongsTo("App\Models\Role")->withDefault(function (
            $data,
        ) {
            foreach ($data->getFillable() as $dt) {
                $data[$dt] = __("Deleted");
            }
        });
    }

    public function IsSuper()
    {
        if ($this->id == 1) {
            return true;
        }
        return false;
    }

    public function sectionCheck($value)
    {
        $sections = json_decode($this->role->section ?? "", true);
        if (is_array($sections) && in_array($value, $sections)) {
            return true;
        } else {
            return false;
        }
    }
}
