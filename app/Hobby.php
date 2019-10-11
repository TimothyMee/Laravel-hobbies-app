<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hobby extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "user_id", "name", "category", "description"
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function createNew($data)
    {
        $data['user_id'] = auth()->id();
        return $this->create($data);
    }

    public function viewAll()
    {
        return $this->with(['category', 'user'])->get();
    }

    public function viewOne($data)
    {
        return $this->where('name', $data['name'])
                    ->orWhere('id', $data['id'])
                    ->where('user_id', auth()->id())
                    ->with(['category','user'])
                    ->get();
    }

    public function deleteOne($data)
    {
        return $this->where('id', $data['id'])->delete();
    }

    public function updateOne($data)
    {
        return $this->where('id', $data['id'])
                    ->fill($data)
                    ->save();
    }
}
