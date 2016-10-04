@extends("admin.main")

@section("title" , "| Permission")

@section("content")

	<div class="content-wrapper">
		<section class="content">
			<div class="row">
			@if (session()->has("success_add_perms"))	
				<div class="alert alert-success">{{ session()->get("success_add_perms") }}</div>
			@endif
			@if (session()->has("success_delete_perm"))
				<div class="alert alert-success">{{ session()->get("success_delete_perm") }}</div>
			@endif
			@if (session()->has("success_edit_perms"))
				<div class="alert alert-success">{{ session()->get("success_edit_perms") }}</div>
			@endif
				<div class="col-md-6">
					<div class="btn btn-success" style="float: left;margin-bottom: 10px;" id="add_per">اضافة اذن</div>
				</div>
				<div class="col-md-6" id="per_form" style="display: none;">
					<div class="box box-primary">
			            <div class="box-header with-border text-center">
			              <h3 class="box-title">Add New Permission</h3>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            {{ Form::open(["route" => "admin.Permission.store" , "method" => "POST" ,"role" => "form"]) }}
			              <div class="box-body">
			                <div class="form-group">
			                 {{ Form::label("permission" , "Permission name") }}
			                 {{ Form::text("name" , "" ,["class" => "form-control"]) }}
			                </div>
			                <div class="form-group">
				                {{ Form::label("departments" , "Departments control in") }}<br>
				                <input type="checkbox" name="dep[]" value="Posts" /> المقالات<br>
				                <input type="checkbox" name="dep[]" value="Category" /> الاقسام<br>
				                <input type="checkbox" name="dep[]" value="User" /> الاعضاء<br>
			                </div>
			                <div class="form-group">
				                {{ Form::label("posts control" , "Allow to see others posts from other users and edit or delete it") }}<br>
								 <input type="radio" name="posts_control" value="1"> Yes<br>
								 <input type="radio" name="posts_control" value="0"> No<br>
			                </div>
			                 <div class="form-group">
				                {{ Form::label("categories" , "الاقسام الذي يمكن ان يكتب فيها") }}<br>
				                <p style="color: rgb(17, 105, 161);">لا تحدد اي قسم اذا اردت كل الاقسام</p>
				                @foreach($cats as $cat)
				                	<input type="checkbox" id="cats" name="cats[]" value='{{ $cat->name }}' /> {{ $cat->name }}<br>
				                @endforeach
			                </div>
			                <div class="form-group">
			                 {{ Form::label("description" , "Description") }}
			                 <textarea class="form-control" name="descrip"></textarea>
			                </div>
			              </div>
			              <!-- /.box-body -->

			              <div class="box-footer">
			                {{ Form::submit("save" , ["class" => "btn btn-primary"]) }}
			                <div class="btn btn-default" id="des_per">Cansel</div>
			              </div>
			            {{ Form::close() }}
          			</div>
				</div>
			</div>
			<div class="row">
        		<div class="col-md-12">
	        		<div class="box">
			            <div class="box-header">
			              <h3 class="box-title text-center">Permissions</h3>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body">
			              <table id="example2" class="table table-bordered table-hover">
			                <thead>
			                <tr>
			                  <th>Num</th>
			                  <th>Permission</th>
			                  <th>Can control in</th>
			                  <th>Categories can add on it</th>
			                  <th>Control</th>
			                </tr>
			                </thead>
			                <tbody>
			                @foreach($pers as $per)
			                <tr>
			                    <td>{{ $per->id }}</td>
			                    <td>{{ $per->name }}</td>
			                    <td>{{ $per->departments }}</td>
			                    <td>
			                    	@if ($per->categories == null)
			                    		All categories
			                    	@else
			                    		{{ $per->categories }}
			                    	@endif
			                    </td>
			                    <td><a href='{{ route("admin.Permission.edit" , $per->id) }}' class="btn btn-success">Edit</a> 
			                    {{ Form::open(["route" => ["admin.Permission.destroy" , $per->id], "method" => "delete" ,"style" => "display: -moz-box;"]) }}
			                    {{ Form::submit("Delete" , ["class" => "btn btn-danger"]) }}
			                    {{ Form::close() }}
			                    </td>
			                </tr>
			                @endforeach
			                </tbody>
			                {{ $pers->links() }}
			              </table>
			            </div>
			            <!-- /.box-body -->
	          		</div>
        		</div>
        	</div>
		</section>
	</div>

	<script type="text/javascript">
		$("#add_per").click(function() {
			$("#per_form").css('display', 'block');
		});
		$("#des_per").click(function() {
			$("#per_form").css('display', 'none');
		});
		$("#all_cats").click(function() {
			document.getElementById("cats").checked = true;
		});
	</script>

@endsection