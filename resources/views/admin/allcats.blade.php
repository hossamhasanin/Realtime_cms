@extends("admin.main")

@section("title" , "| Categories")

@section("content")

<div class="content-wrapper">
	<section class="content">
		<div class="container" style="width:1006px;">
			<div class="row">
				<div class="col-md-12">
								<div class="box">
	            <div class="box-header">
	              <h3 class="box-title text-center">Posts</h3>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <table id="example2" class="table table-bordered table-hover">
	                <thead>
	                <tr>
	                  <th>ID</th>
	                  <th>name</th>
	                  <th>status</th>
	                  <th>parent</th>
	                  <th>Created By</th>
	                  <th>created at</th>
	                  <th>Control</th>
	                </tr>
	                </thead>
	                <tbody>
	                @foreach($cats as $key => $cat)
	                <tr>
	                    <td>{{ $key + 1 }}</td>
	                    <td>{{ $cat->name }}</td>
	                    <td>
	                    	@if ($cat->status == 1)
	                    		Open
	                    	@else
	                    		Close
	                    	@endif
	                    </td>
		                <td>
		                @if ($cat->parent == 0)
		                	No parent
		                @else
		                	<?php $parent = $cats->where("id" , $cat->parent)->first(); ?>
		                	{{ $parent->name }}
		                @endif
		                </td>
	                    <td>{{ $cat->users->name }}</td>
	                    <td>{{ date("D , m , y" , strtotime($cat->created_at)) }}</td>
	                    <td><a href='{{ route("admin.categories.edit" , ["id" => $cat->id]) }}' class="btn btn-success">Edit</a> 
	                    {{ Form::open(["route" => ["admin.categories.destroy" , $cat->id] , "method" => "delete" , "style" => "display: inline;"]) }}
	                    {{ Form::submit("Delete" , ["class" => "btn btn-danger"]) }}
	                    {{ Form::close() }}
	                    </td>
	                </tr>
	                @endforeach
	                </tbody>
	                {{ $cats->links() }}
	              </table>
	            </div>
	            <!-- /.box-body -->
	          </div>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection