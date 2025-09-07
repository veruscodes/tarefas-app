<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToCompany;

class Task extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'title','description','status','priority','due_date','company_id','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
