<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory;
use SoftDeletes;

    protected $fillable = [
        'name_Doc',
        'categories_id',
        'Status',
        'doc_pdf',
        'user_id',
        'user_id_update'
    ];
protected $dates = ['deleted_at'];
    public function user()
    {
        return $this->belongsTo('app\Models\User', 'user_id');
    }
    public function categories()
    {
        return $this->belongsTo('App\Models\Categories', 'categories_id');
    }
    public function userupdate()
    {
        return $this->belongsTo('app\Models\User', 'user_id_update');
    }

}
