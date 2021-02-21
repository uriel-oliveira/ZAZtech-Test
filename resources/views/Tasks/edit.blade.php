@extends('app')

@section('content')

	<h1>Editar Tarefa</h1>
	
	{!! Form::open(['action' => ['TasksController@update',$Task->id], 'method' => 'POST'])!!}
	<table align=center>
		<tr>
			<th>{{Form::label('name','Tarefa')}}</th>
			<td>{{Form::text('name',$Task->name)}}</td>
		</tr>
		<tr>
			<th>{{Form::label('description','Descrição')}}</th>
			<td>{{Form::textarea('description',$Task->description,['rows' => 4 ])}}</td>
		</tr>
		<tr>
			<th>{{Form::label('priority','Prioridade')}}</th>
			<td>
				@foreach($Task->priorityOptions as $k => $priorityOption)
					{{Form::radio('priority',$priorityOption,$Task->priority == $priorityOption,['id' => 'priority_'.$k])}}
					{{Form::label('priority_'.$k,$priorityOption)}}
				@endforeach
			</td>
		</tr>
		<tr>
			<th>{{Form::label('status','Estado')}}</th>
			<td>
				@foreach($Task->statusOptions as $k => $statusOption)
					{{Form::radio('status',$statusOption,$Task->status == $statusOption,['id' => 'status_'.$k])}}
					{{Form::label('status_'.$k,$statusOption)}}
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