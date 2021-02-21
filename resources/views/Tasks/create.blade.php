@extends('app')

@section('content')

	<h1>Nova Tarefa</h1>
	
	{!! Form::open(['action' => 'TasksController@store', 'method' => 'POST'])!!}
	<table align=center>
		<tr>
			<th>{{Form::label('name','Tarefa')}}</th>
			<td>{{Form::text('name','',['placeholder' => 'Nome da Tarefa'])}}</td>
		</tr>
		<tr>
			<th>{{Form::label('description','Descrição')}}</th>
			<td>{{Form::textarea('description','',['placeholder' => 'Descrição da Tarefa', 'rows' => 4 ])}}</td>
		</tr>
		<tr>
			<th>{{Form::label('priority','Prioridade')}}</th>
			<td>
				@foreach($Task->priorityOptions as $k => $priorityOption)
					{{Form::radio('priority',$priorityOption,false,['id' => 'priority_'.$k])}}
					{{Form::label('priority_'.$k,$priorityOption)}}
				@endforeach
			</td>
		</tr>
		<tr>
			<th>{{Form::label('status','Estado')}}</th>
			<td>
				@foreach($Task->statusOptions as $k => $statusOption)
					{{Form::radio('status',$statusOption,false,['id' => 'status_'.$k])}}
					{{Form::label('status_'.$k,$statusOption)}}
				@endforeach
			</td>
		</tr>
		<tr>
			<td colspan=2 style="padding-top:15px">{{Form::submit('Confirmar', ['class' => 'btn btn-primary btn-block'])}}</td>
		</tr>
	</table>
	{!! Form::close()!!}
@endsection