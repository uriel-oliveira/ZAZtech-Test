<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\TaskUser;
use App\User;


class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		// Define ordenação
		$orderBy = $request->isMethod('get') && $request->input('orderBy') ? explode("|",$request->input('orderBy')) : array('name','asc');		
		// Busca Tarefas
        $Tasks = Task::orderBy($orderBy[0],$orderBy[1])->get();
		
		// Define opções de ordenação e troca asc/desc na opção selecionada em $request
		$Tasks->orderByOptions = array(
			'name'		=> $orderBy[0] == 'name'		&& $orderBy[1] == 'asc' ? 'name|desc'		: 'name|asc',
			'priority'	=> $orderBy[0] == 'priority'	&& $orderBy[1] == 'asc' ? 'priority|desc'	: 'priority|asc',
			'status'	=> $orderBy[0] == 'status'		&& $orderBy[1] == 'asc' ? 'status|desc'		: 'status|asc'
		);
		
		return view('tasks.index')->with('Tasks',$Tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$Task = new Task();
		return view('tasks.create')->with('Task',$Task);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
			'name' 			=> 'required|max:50',
			'description' 	=> 'max:255',
			'priority' 		=> 'required',
			'status' 		=> 'required'
		]);
		
		$Task = new Task;
		$Task->name 		= $request->input('name');
		$Task->description 	= $request->input('description');
		$Task->priority 	= $request->input('priority');
		$Task->status 		= $request->input('status');
		$Task->save();
		
		return redirect('/tasks')->with('success', 'Nova Tarefa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$Task = Task::find($id);
		// Busca Users vinculados à Tarefa
		$Task->Users = User::join('tasks_users','tasks_users.user_id','=','users.id')->where('tasks_users.task_id',$id)->orderBy('users.name','asc')->get();		
	
		return view('tasks.show')->with('Task',$Task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Task = Task::find($id);
		return view('tasks.edit')->with('Task',$Task);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
			'name' 			=> 'required|max:50',
			'description' 	=> 'max:255',
			'priority' 		=> 'required',
			'status' 		=> 'required'
		]);
		
		$Task = Task::find($id);
		$Task->name 		= $request->input('name');
		$Task->description 	= $request->input('description');
		$Task->priority 	= $request->input('priority');
		$Task->status 		= $request->input('status');
		$Task->save();
		
		return redirect('/tasks')->with('success', "Tarefa editada com sucesso!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$Task = Task::find($id);
		$Task->delete();
        return redirect('/tasks')->with('success', "Tarefa excluída com sucesso!");
    }


    /**********************
	 * FUNÇÕES ADICIONAIS *
	 **********************/


    /**
     * Mostra Form para vincular Users à Task
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignUsers($id)
    {
        $Task = Task::find($id);
		
		// Busca Users atualmente vinculados à Task
		$Task->Users = User::join('tasks_users','tasks_users.user_id','=','users.id')->where('tasks_users.task_id',$id)->get();		
		// Busca TODOS Users, para serem selecionados no Form
		$Users = User::orderBy('users.name','asc')->get();
		
		// Cria array de User->id para seleção no Form
		$user_ids[] = array();
		foreach($Task->Users as $TaskUser)
			$user_ids[] = $TaskUser->id;	
		$Task->user_ids = $user_ids;

		return view('tasks.assignUsers')->with(['Task' => $Task, 'Users' => $Users]);
    }

    /**
     * Atualiza as relações entre Users e uma Task específica
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUsers(Request $request, $id)
    {
		// Error Handling: Caso não houver users selecionados em $request, atribui array vazio
		$user_ids = $request->input('users') ? $request->input('users') : array();
		
		// Validate: Verifica se Users selecionados já estão atribuidos à 3 Tasks (exceto a Task sendo editada)
		foreach($user_ids as $user_id)
		{
			$Users = User::join('tasks_users','tasks_users.user_id','=','users.id')->where('tasks_users.task_id','<>',$id)->where('users.id',$user_id)->get();	
			if(count($Users) >= 3 )
				return redirect("/tasks/{$id}")->with('error', "Usuário {$Users[0]->name} está atribuído à 3 (máximo) Tarefas!");
		}
		
		// Limpa todas relações de Users da Task $id
		TaskUser::where('task_id',$id)->delete();
		
		// Cria um registro de relação para cada User em $request
		foreach($user_ids as $user_id)
		{
			$TaskUser = new TaskUser();
			$TaskUser->task_id = $id;
			$TaskUser->user_id = $user_id;
			$TaskUser->save();
		}
		return redirect("/tasks/{$id}")->with('success', "Usuários vinculados à Tarefa com sucesso!");
    }
	

}
