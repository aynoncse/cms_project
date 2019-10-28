@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
	<a href="{{route('tags.create')}}" class="btn btn-success float-right">Add Tag</a>
</div>
<div class="card card-default">
	<div class="card-header">
		Tags
	</div>
	<div class="card-body">
		@if($tags->count()>0)
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th class="text-center">Posts Count</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($tags as $tag)
				<tr>
					<td>{{ $tag->name }}</td>
					<td class="text-center">{{ $tag->posts->count() }}</td>
					<td>
						<a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-info btn-sm">Edit</a>
						<button id="#delete-btn" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id='{{$tag->id}}'>
							Delete
						</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
			<h3 class="text-center">No Tags Yet</h3>
		@endif
		<!-- The Modal -->
		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form action="" method="POST" id="deleteTagForm">
					@csrf
					@method('DELETE')
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="deleteModalLabel">Delete Tag</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input type="hidden" name="cat_id" value="" placeholder="">
							<p class="text-bold">
								Are you sure to delete this tag?
							</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">No, Go Back</button>
							<button type="submit" class="btn btn-danger">Yes Delete</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script>
	$('#deleteModal').on('show.bs.modal', function (e) {
		var id = $(e.relatedTarget).data('id');
		var form = document.getElementById('deleteTagForm');
		form.action = 'tags/'+id; 
	});

</script>
@endsection