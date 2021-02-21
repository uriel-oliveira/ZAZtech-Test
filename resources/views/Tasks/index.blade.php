@extends('app')

@section('content')
	<script>
	  function ConfirmDelete(name){
		return confirm("Confirma EXCLUSÃO de \"" + name + "\" ?");
	  }
	</script>

	<h1>Tarefas</h1>
	
	<table align=center>
		<tr>
			<th><a href='/tasks?orderBy={{$Tasks->orderByOptions["name"]}}'>Tarefa</a></th>
			<th><a href='/tasks?orderBy={{$Tasks->orderByOptions["priority"]}}'>Prioridade</a></th>
			<th><a href='/tasks?orderBy={{$Tasks->orderByOptions["status"]}}'>Estado</a></th>
			<th><a href='/tasks/create' class="btn btn-primary btn-sm btn-block">Nova Tarefa</a></th>
		</tr>
		@foreach($Tasks as $Task)
		<tr>
			<td><a href='/tasks/{{$Task->id}}' class="btn btn-info">{{$Task->name}}</a></td>
			<td>{{$Task->priority}}</td>
			<td>{{$Task->status}}</td>
			<td>
				<a href='/tasks/{{$Task->id}}/assignUsers' class="btn btn-primary btn-sm">Usuários</a>
				<a href='/tasks/{{$Task->id}}/edit' class="btn btn-primary btn-sm">Editar</a>
				{!!Form::open(['action' => ['TasksController@destroy',$Task->id], 'method' => 'POST', 'onSubmit' => 'return ConfirmDelete(this.name.value)', 'class' => 'pull-right'])!!}
					{{Form::hidden('_method','DELETE')}}
					{{Form::hidden('name',$Task->name)}}
					{{Form::submit('Excluir', ['class' => 'btn btn-danger btn-sm'])}}
				{!!Form::close()!!}
			</td>
		</tr>
		@endforeach
	</table>
@endsection