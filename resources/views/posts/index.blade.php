@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
	<a href="{{route('posts.create')}}" class="btn btn-success float-right">Add Post</a>
</div>
<div class="card card-default">
	<div class="card-header">
		Posts
	</div>
	<div class="card-body">
		@if($posts->count()>0)
		<table class="table">
			<thead>
				<tr>
					<th>Image</th>
					<th>Title</th>
					<th>Category</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($posts as $post)
				<tr>
					<td><img src="{{ asset('public/storage/'.$post->image) }} " height="60" width="100"></td>
					<td>{{ $post->title }}</td>
					<td>
						<a href="{{route('categories.edit', $post->category->id)}}" title="">{{ $post->category->name }}</a>
					</td>
					<td class="text-center">
						@if($post->trashed())
						<form action="{{ route('restore-posts', $post->id) }}" method="POST" style="display: inline;">
							@csrf
							@method('PUT')
							<button type="submit" href="" class="btn btn-info btn-sm">Restore</button>
						</form>
						@else
						<a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info btn-sm">Edit</a>
						@endif

						<button id="#delete-btn" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id='{{$post->id}}'>
							Delete
						</button>
					</td>

				</tr>
				@endforeach
			</tbody>
		</table>
		@else
			<h3 class="text-center">No Posts Yet</h3>
		@endif
		<!-- The Modal -->
		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form action="" method="POST" id="deletePostForm">
					@csrf
					@method('DELETE')
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="deleteModalLabel">Delete Post</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input type="hidden" name="cat_id" value="" placeholder="">
							<p class="text-bold">
								Are you sure to delete this post?
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
		var form = document.getElementById('deletePostForm');
		form.action = '{{route('posts.destroy', '')}}'+'/'+id; 
	});

</script>
@endsection