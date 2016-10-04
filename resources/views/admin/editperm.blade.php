@extends("admin.main")

@section("title" , "Edit Permission :" . $perm->name)

@section("content")

	<div class="content-wrapper">
		<section class="content">
			<div class="row">
				<div class="col-md-6">
					<div class="box box-primary">
			            <div class="box-header with-border text-center">
			              <h3 class="box-title">Edit {{ $perm->name }}</h3>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            {{ Form::open(["route" => ["admin.Permission.update" , $perm->id] , "method" => "PUT" ,"role" => "form"]) }}
			              <div class="box-body">
			                <div class="form-group">
			                 {{ Form::label("permission" , "Permission name") }}
			                 {{ Form::text("name" , $perm->name ,["class" => "form-control"]) }}
			                </div>
			                <div class="form-group">
			                <?php $departs = explode("," , $perm->departments); ?>
				                {{ Form::label("departments" , "Departments control in") }}<br>
				                <input type="checkbox" name="dep[]" value="Posts" @if (in_array("Posts", $departs)) checked="true" @endif /> المقالات<br>
				                <input type="checkbox" name="dep[]" value="Category" @if (in_array("Category", $departs)) checked="true" @endif /> الاقسام<br>
				                <input type="checkbox" name="dep[]" value="User" @if (in_array("User", $departs)) checked="true" @endif /> الاعضاء<br>
			                </div>
			                <div class="form-group">
				                {{ Form::label("posts control" , "Allow to see others posts from other users and edit or delete it") }}<br>
								 <input type="radio" name="posts_control" value="1" @if ($perm->full_control_posts == 1) checked="true" @endif > Yes<br>
								 <input type="radio" name="posts_control" value="0" @if ($perm->full_control_posts == 0) checked="true" @endif > No<br>
			                </div>
			                 <div class="form-group">
				                {{ Form::label("categories" , "الاقسام الذي يمكن ان يكتب فيها") }}<br>
				                <p style="color: rgb(17, 105, 161);">لا تحدد اي قسم اذا اردت كل الاقسام</p>
				                @foreach($cats as $cat)
				                	<input type="checkbox" id="cats" name="cats[]" value='{{ $cat->name }}' @if ($perm->categories == $cat->name) checked="true" @endif /> {{ $cat->name }}<br>
				                @endforeach
			                </div>
			                <div class="form-group">
			                 {{ Form::label("description" , "Description") }}
			                 <textarea class="form-control" name="descrip">{{ $perm->description }}</textarea>
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
		</section>
	</div>

	<script type="text/javascript">
		$("#all_cats").click(function() {
			document.getElementById("cats").checked = true;
		});
	</script>

@endsection