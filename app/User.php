<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	public $timestamps = false;

    protected $table = 'users';
	protected $primary_key = 'id';
	
	protected $name;	
	
}
