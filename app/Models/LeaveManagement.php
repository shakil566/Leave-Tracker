<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveCategory;
use App\Models\User;


class LeaveManagement extends Model
{
    protected $table = 'leave_management';
    public $timestamps = true;


    public static function boot()
    {
        parent::boot();
        static::creating(function($post)
        {
            $post->created_by = isset(Auth::user()->id) ? Auth::user()->id : 1;
            $post->updated_by = isset(Auth::user()->id) ? Auth::user()->id : 1;
        });

        static::updating(function($post)
        {
            $post->updated_by = isset(Auth::user()->id) ? Auth::user()->id : 1;
        });

    }

     
    public function LeaveCategory() {
        return $this->belongsTo('App\Models\LeaveCategory', 'leave_category_id');
    }
    
    public function User() {
        return $this->belongsTo('App\Models\User', 'employee_id');
    }
    
}
