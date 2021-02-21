<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\User;

class Task extends Model
{
	public $timestamps = false;

    protected $table = 'tasks';
	protected $primary_key = 'id';
	
	protected $name;
	protected $description;
	protected $priority;
	protected $status;

	protected $priorityOptions; // Opções do campo ENUM priority
	protected $statusOptions;	// Opções do campo ENUM status
	
	
	public function __get($key)
	{
		switch($key){
			case 'priorityOptions':
				// Busca opções de Prioridade definidas no Banco de Dados: campo ENUM priority
				$attribute = $this->getENumOptions('priority');
				break;
			case 'statusOptions':
				// Busca opções de Estado definidas no Banco de Dados: campo ENUM status
				$attribute = $this->getENumOptions('status');
				break;
			default:
				$attribute = parent::__get($key);
		}
		
		return $attribute;
	}
	
	/**
     * Busca opções de um campo ENUM definido no banco de dados
     *
     * @param  string $field
     * @return array $values
     */	
	 protected function getEnumOptions($field)
	{
		$type = DB::select(DB::raw("SHOW COLUMNS FROM {$this->table} WHERE Field = '{$field}'"))[0]->Type;
		preg_match('/^enum\((.*)\)$/', $type, $matches);
		
		$values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }
		
        return $values;
	}
	

}
