@extends('layouts.app')

@section('content')

<div class="card card-default">
	
	<div class="card-header">
		{{ isset($post)?'Edit Post':'Create Post' }}
	</div>
	<div class="card-body">
		@include('partials.errors')
		<form action="{{isset($post)?route('posts.update', $post->id):route('posts.store')}}" method="POST" enctype="multipart/form-data">
			@csrf
			@if(isset($post))
			@method('PUT')
			@endif
			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" class="form-control" id="title" name="title" value="{{isset($post)?$post->title:''}}" placeholder="">
			</div>
			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" id="description" cols="5" rows="5" class="form-control">{{isset($post)?$post->description:''}}</textarea>
			</div>
			<div class="form-group">
				<label for="content">Content</label>
				<input id="content" value="{{isset($post)?$post->content:''}}" type="hidden" name="content">
				<trix-editor input="content"></trix-editor>
			</div>
			<div class="form-group">
				<label for="published_at">Published at</label>
				<input type="text" class="form-control" id="published_at" name="published_at" value="{{isset($post)?$post->published_at:''}}" placeholder="">
			</div>
			@if(isset($post))
			<div class="form-group">
				<img src="{{ asset('public/storage/'.$post->image) }}" alt="" style="width: 100%">
			</div>
			@endif

			<label for="image">Image</label>
			<div class="custom-file mb-3">
				<input type="file" class="custom-file-input" id="image" name="image" value="{{isset($post)?$post->image:''}}" >
				<label class="custom-file-label" for="image"></label>
			</div>

			<div class="form-group">
				<label for="category">Category</label>
				<select class="form-control" id="category" name="category">
					<option hidden selected disabled>Click to Pick</option>}
					@foreach($categories as $category)
					<option value="{{$category->id}}"
						@if(isset($post))
							@if($category->id==$post->category_id)
							selected 
							@endif
						@endif
						>
						{{$category->name}}
					</option>
					@endforeach
				</select>
			</div>
			
			@if($tags->count() > 0)
			<div class="form-group">
				<label for="category">Tags</label>
				<select class="form-control tag-selector" id="tags" name="tags[]" multiple>

					@foreach($tags as $tag)
					<option value="{{$tag->id}}"
						@if(isset($post))
							@if($post->hasTag($tag->id))
							selected 
							@endif
						@endif
						>
						{{$tag->name}}
					</option>
					@endforeach
				</select>
			</div>
			@endif

			<div class="form-group">
				<button type="submit" class="btn btn-success">{{ isset($post)?'Update Post':'Add Post' }}</button>
			</div>

		</form>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('public/js/trix.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/select2.min.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('public/js/flatpickr.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
	flatpickr("#published_at", {
		enableTime: true
	})
	$(document).ready(function(){
		$('.tag-selector').select2();
	});
</script>
<script>
	$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/trix.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/select2.min.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('flatpickr.min.css') }}"> --}}
@endsection