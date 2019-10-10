<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name", "description", "created_by"
    ];

    public function createNew($data)
    {
        $data['created_by'] = auth()->id();
        return $this->create($data);
    }

    public function viewAll()
    {
        return $this->all();
    }

    public function viewOne($data)
    {
        return $this->where('name', $data['name'])
                    ->orWhere('id', $data['id'])
                    ->get();
    }

    public function deleteOne($data)
    {
        return $this->where('id', $data['id'])->delete();
    }
}
