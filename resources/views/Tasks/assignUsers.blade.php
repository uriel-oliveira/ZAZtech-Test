@extends('app')

@section('content')
	
	<h1>Tarefa: {{$Task->name}}</h1>
	
	{!! Form::open(['action' => ['TasksController@updateUsers',$Task->id], 'method' => 'POST'])!!}
	<table align=center>		
		<tr>
			<th>Descrição</th>
			<td>{{$Task->description}}</td>
		</tr>
		<tr>
			<th>Prioridade</th>
			<td>{{$Task->priority}}</td>
		</tr>
		<tr>
			<th>Estado</th>
			<td>{{$Task->status}}</td>
		</tr>
		<tr>
			<th colspan=2><h4>Atribuir Usuários</h4></th>
		</tr>
		<tr>
			<th colspan=2>
				@foreach($Users as $k => $User)
					{{Form::checkbox('users[]',$User->id,in_array($User->id,$Task->user_ids),['id' => 'user_'.$k])}}
					{{Form::label('user_'.$k,$User->name)}}<br>
				@endforeach
			</td>
		</tr>
		<tr>
			<td colspan=2 style="padding-top:15px">
				{{Form::hidden('_method','PUT')}}
				{{Form::submit('Confirmar', ['class' => 'btn btn-primary btn-block'])}}
			</td>
		</tr>		
	</table>
	{!! Form::close()!!}
@endsection