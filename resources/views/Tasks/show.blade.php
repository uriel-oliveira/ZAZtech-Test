@extends('app')

@section('content')
	
	<h1>Tarefa: {{$Task->name}}</h1>
	
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
			<th colspan=2><h4>Usuários Atribuídos <a href='/tasks/{{$Task->id}}/assignUsers' class="btn btn-primary btn-sm">Editar</a></h4></th>
		</tr>
		<tr>
			<th colspan=2>
				@foreach($Task->Users as $k => $User)
				{{$User->name}}<br>
				@endforeach
			</td>
		</tr>		
	</table>
@endsection