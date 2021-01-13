<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title','description','image','heading','sub_heading','button_text','button_link','page_name'];
}
