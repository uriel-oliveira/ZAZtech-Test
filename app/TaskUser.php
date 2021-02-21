<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
	public $timestamps = false;

    protected $table = 'tasks_users';
	
	protected $task_id;
	protected $user_id;
		
}
