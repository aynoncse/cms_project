@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
	<a href="{{route('categories.create')}}" class="btn btn-success float-right">Add Category</a>
</div>
<div class="card card-default">
	<div class="card-header">
		Categories
	</div>
	<div class="card-body">
		@if($categories->count()>0)
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th class="text-center">Posts Count</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($categories as $category)
				<tr>
					<td>{{ $category->name }}</td>
					<td class="text-center">{{ $category->posts->count() }}</td>
					<td>
						<a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">Edit</a>
						<button id="#delete-btn" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id='{{$category->id}}'>
							Delete
						</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
			<h3 class="text-center">No Catagories Yet</h3>
		@endif
		<!-- The Modal -->
		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form action="" method="POST" id="deleteCategoryForm">
					@csrf
					@method('DELETE')
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input type="hidden" name="cat_id" value="" placeholder="">
							<p class="text-bold">
								Are you sure to delete this category?
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
		var form = document.getElementById('deleteCategoryForm');
		form.action = 'categories/'+id; 
	});

</script>
@endsection