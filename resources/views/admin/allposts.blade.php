@extends("admin.main")

@section("title" , "| All posts")

@section("stylies")

	{{ Html::Script("stylies/socket.io.js") }}

@section("content")

	<div class="content-wrapper">
		<section class="content">
<div class="container" style="width:1006px;">
	  <div class="row">
        <div class="col-xs-12">
       	@if (!$posts)
        	<div class="alert alert-info"><h2 class="text-center">لا يوجد مقالات اﻷن</h2></div>
       	@else
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
	                  <th>title</th>
	                  <th>slug</th>
	                  <th>Category</th>
	                  <th>Created By</th>
	                  <th>created at</th>
	                  <th>Control</th>
	                </tr>
	                </thead>
	                <tbody id="online_posts">
	                @foreach($posts as $key => $post)
	                <tr>
	                    <td>{{ $key + 1 }}</td>
	                    <td>{{ $post->title }}</td>
	                    <td>{{ $post->slug }}</td>
	                    <td>{{ $post->category->name }}</td>
	                    <td>
	                    	@if ($post->users->name == Auth::user()->name)
	                    		Me
	                    	@else
	                    		{{ $post->users->name }}
	                    	@endif
	                    </td>
	                    <td>{{ date("D , m , y" , strtotime($post->created_at)) }}</td>
	                    <td><a href='{{ route("admin.posts.edit" , ["id" => $post->id]) }}' class="btn btn-success">Edit</a> 
	                    {{ Form::open(["route" => ["admin.posts.destroy" , $post->id] , "method" => "delete" , "style" => "display: inline;"]) }}
	                    {{ Form::submit("Delete" , ["class" => "btn btn-danger"]) }}
	                    {{ Form::close() }}
	                    </td>
	                </tr>
	                @endforeach
	                </tbody>
	                {{ $posts->links() }}
	              </table>
	            </div>
	            <!-- /.box-body -->
	          </div>
        @endif
        </div>
      </div>
      <div class="row">
      		          <!-- PRODUCT LIST -->
          <div class="box box-primary">
	            <div class="box-header with-border">
	              <h3 class="box-title">Recently Added Products</h3>

	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	              </div>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <ul class="products-list product-list-in-box">
	              @foreach($last_posts as $post)
	                <li class="item">
	                  <div class="product-img">
	                    <img src='{{ asset("images/posts/$post->image") }}' alt="Product Image">
	                  </div>
	                  <div class="product-info">
	                    <a href="javascript:void(0)" class="product-title"> {{ $post->category->name }}
	                      <span class="label label-warning pull-right">$1800</span></a>
	                        <span class="product-description">
	                          {{ $post->title }}
	                        </span>
	                  </div>
	                </li>
	               @endforeach
	                <!-- /.item -->
	              </ul>
	            </div>
	            <!-- /.box-body -->
	            <div class="box-footer text-center">
	              <a href="javascript:void(0)" class="uppercase">View All Products</a>
	            </div>
	            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
      </div>
		</section>
	</div>
	<script type="text/javascript">
		 //socket
     var socket = io.connect('http://localhost:8890');

      socket.on('postes', function (data) {

        data = jQuery.parseJSON(data);

        console.log(data.title);

        document.getElementById("online_posts").innerHTML += "<tr><td>"+data.title+"<td><td>"+data.slug+"<td></tr>";

        alert(data.title);

      });
	</script>
@endsection