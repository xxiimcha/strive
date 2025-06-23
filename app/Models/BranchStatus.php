<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchStatus extends Model
{
    protected $fillable = ['branch_id', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_user', 'branch_id', 'user_id');
    }

}

