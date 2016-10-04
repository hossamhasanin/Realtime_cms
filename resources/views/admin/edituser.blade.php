@extends("admin.main")

@section("title" , "| $user->name")

@section("content")

	<div class="content-wrapper">
		<section class="content">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
			<div class="row">
				<div class="col-md-6">
					<div class="box box-primary">
            <div class="box-header with-border text-center">
              <h3 class="box-title">Edit: {{ $user->name }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(["route" => ["admin.users.update" , $user->id] , "method" => "PUT" ,"role" => "form" , "files" => true]) }}
              <div class="box-body">
                <div class="form-group">
                 {{ Form::label("username" , "Username") }}
                 {{ Form::text("name" , $user->name ,["class" => "form-control"]) }}
                </div>
                <div class="form-group">
                {{ Form::label("email address" , "Email address") }}
                {{ Form::email("email" , $user->email ,["class" => "form-control"]) }}
                </div>
                <input type="hidden" name="old_password" value="{{ $user->password }}">
                <div class="form-group">
                 {{ Form::label("password" , "New Password") }}
                 {{ Form::password("new_password" ,["class" => "form-control" , "placeholder" => "Leave it empty if you don't want to change it"]) }}
                </div>
                <div class="form-group">
                 {{ Form::label("status" , "Status") }}
                  <select name="status" class="form-control">
                  @foreach($perms as $perm)
                      <option value="{{ $perm->id }}" @if ($user->status == $perm->id) selected="" @endif >{{ $perm->name }}</option>
                  @endforeach
                 </select>
                </div>
                <div class="form-group">
                  <img src='{{ asset("images/users/$user->img") }}' id="reb_img" width="100" height="100" />
                </div>
                 <div class="form-group">
                 {{ Form::label("user_image" , "User Image") }}
                 {{ Form::file("user_image" , ["onchange" => "readimg(this)"]) }}
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                {{ Form::submit("save" , ["class" => "btn btn-primary"]) }}
              </div>
            {{ Form::close() }}
          </div>
				</div>
			</div>
		</section>
	</div>

@endsection