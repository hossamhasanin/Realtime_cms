@extends("admin.main")

@section("title" , "| All users")

@section("css")

<style>
  /* The Modal (background) */
  .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 1; /* Sit on top */
      padding-top: 100px; /* Location of the box */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }

  /* Modal Content */
  .modal-content {
      position: relative;
      background-color: #fefefe;
      margin: auto;
      padding: 0;
      border: 1px solid #888;
      width: 80%;
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
      -webkit-animation-name: animatetop;
      -webkit-animation-duration: 0.4s;
      animation-name: animatetop;
      animation-duration: 0.4s
  }

  /* Add Animation */
  @-webkit-keyframes animatetop {
      from {top:-300px; opacity:0} 
      to {top:0; opacity:1}
  }

  @keyframes animatetop {
      from {top:-300px; opacity:0}
      to {top:0; opacity:1}
  }

  /* The Close Button */
  .close {
      color: white;
      float: right;
      font-size: 28px;
      font-weight: bold;
  }

  .close:hover,
  .close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
  }

  .modal-header {
      padding: 2px 16px;
      background-color: #5cb85c;
      color: white;
  }

  .modal-body {padding: 2px 16px;}

  .modal-footer {
      padding: 2px 16px;
      background-color: #5cb85c;
      color: white;
  }
</style>

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
<div class="container" style="width:1006px;">
	  <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title text-center">Users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Username</th>
                  <th>email</th>
                  <th>Permission</th>
                  <th>Control</th>
                </tr>
                </thead>
                <tbody>
                <?php use App\Permission; ?>
                @foreach($users as $key => $user)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <?php
                        $per = Permission::find($user->status);
                    ?>
                    <td>
                      {{ $per->name }}
                    </td>
                    <td><a href='{{ route("admin.users.edit" , ["id" => $user->id]) }}' class="btn btn-success">Edit</a> 
                    {{ Form::open(["route" => ["admin.users.destroy" , $user->id] , "method" => "delete" , "style" => "display: -moz-box;"]) }}
                    {{ Form::submit("Delete" , ["class" => "btn btn-danger"]) }}
                    {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
                </tbody>
                {{ $users->links() }}
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
    </div>
      <div class="row">
      		<div class="col-md-6">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Members</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger">8 New Members</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                  @foreach($last_users as $user)
                    <li>
                      <img src='{{ asset("images/users/$user->img") }}' alt="User Image">
                      <a class="users-list-name" href='{{ route( "admin.users.edit" , ["id" =>$user->id]) }}'>{{ $user->name }}</a>
                      <span class="users-list-date">{{ date("M , Y" , strtotime($user->created_at)) }}</span>
                    </li>
                  @endforeach
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="{{ route('admin.users.index') }}" class="uppercase">View All Users</a>
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
            	<div class="btn btn-success" id="myBtn">تسجيل عضو جديد</div>
            </div>

      </div>
      <!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content" style="margin-top: -80px;width: 678px;">
    <div class="modal-header">
      <span class="close">X</span>
    </div>
    <div class="modal-body">
               <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add new user</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(["route" => "admin.users.store" , "method" => "post" ,"role" => "form" , "files" => true]) }}
              <div class="box-body">
              <div style="display: -moz-box;">
                <div class="form-group" style="width: 305px;">
                 {{ Form::label("username" , "Username") }}
                 {{ Form::text("name" , "" ,["class" => "form-control"]) }}
                </div>
                <div class="form-group" style="margin-right: 10px;width: 312px;">
                {{ Form::label("email address" , "Email address") }}
                {{ Form::email("email" , "" ,["class" => "form-control"]) }}
                </div>
              </div>
                <div class="form-group">
                 {{ Form::label("password" , "Password") }}
                 {{ Form::password("password" ,["class" => "form-control"]) }}
                </div>
                <div class="form-group">
                 {{ Form::label("status" , "Status") }}
                 <select name="status" class="form-control">
                  @foreach($perms as $perm)
                      <option value="{{ $perm->id }}">{{ $perm->name }}</option>
                  @endforeach
                 </select>
                </div>
                <div class="form-group">
                  <img src="" id="reb_img" width="100" height="100" />
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
          <!-- /.box -->
    </div>
  </div>

</div>
</div>
</section>
</div>
<script>
  // Get the modal
  var modal = document.getElementById('myModal');

  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks the button, open the modal 
  btn.onclick = function() {
      modal.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
      modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }

</script>
@endsection