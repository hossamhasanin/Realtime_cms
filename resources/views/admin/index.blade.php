@extends("admin.main")

@section("title" , "| Dashboard")



@section("content")

  <div class="content-wrapper">
  		    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>2</h3>

              <p>اﻷعضاء</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">للمزيد <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>60<sup style="font-size: 20px">%</sup></h3>

              <p>نسبة المعجبين بالمنشورات</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">للمزيد <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>5</h3>

              <p>اﻷعضاء الغير مفعلين</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">للمزيد <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>20</h3>

              <p>عدد منشوراتك</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">للمزيد <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row">
        <div class="col-md-6">
            <!-- Chat box -->
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-comments-o"></i>

              <h3 class="box-title">Chat</h3>

              <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                <div class="btn-group" data-toggle="btn-toggle">
                  <button type="button" id="online" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
                  </button>
                  <button type="button" id="offline" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
                </div>
              </div>
            </div>
            <div class="box-body chat" id="chat-box">
              <!-- chat item -->
                  <div data-id="4"></div>
              <!-- /.item -->
            </div>
            <!-- /.chat -->
            <div class="box-footer">
            <form>
              <div class="input-group">
                <input class="form-control" autocomplete="off" id="message_content" value="" placeholder="Type message..." onkeypress="return sendmessage(event)">

                <div class="input-group-btn">
                  <button type="button" id="send_message" class="btn btn-success"><i class="fa fa-plus"></i></button>
                </div>
            </form>
              </div>
            </div>
          </div>
          <!-- /.box (chat box) -->
        </div>
        <div class="col-md-6">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Online Members</h3>

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
                  <ul class="users-list clearfix" id="online_list">
                  @foreach($online_users as $online_user)
                  @if ($online_user->name != Auth::user()->name)
                    <li>
                      <img src='{{ asset("images/users/$online_user->img") }}' alt="User Image">
                      <a class="users-list-name" href=''>{{ $online_user->name }}</a>
                      <span class="users-list-date" id="{{ $online_user->name }}"><i class="fa fa-circle text-success"></i> Online</span>
                    </li>
                  @endif
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
      </div>
  </div>

  <script type="text/javascript">

    // Socket

    var chatBox = $("#chat-box");
    var token = "{{ csrf_token() }}";
    function bringmessages() {
        var lastmessage = chatBox.find('> div:last-child')[0];

        $.post('{{ route("allmess") }}', {"last": ! lastmessage ? "" : lastmessage.dataset.id , "_token": token}, function(data) {

          datas = jQuery.parseJSON(data);

                $( "#chat-box" ).append( "<div class='item' data-id='"+ datas.id +"'>"+"<img src='/images/users/"+ datas.user_img +"' alt='user image' class='online'>" + "<p class='message'><a href='#' class='name'><small class='text-muted pull-right'><i class='fa fa-clock-o'></i> Today</small>"+ datas.user +"</a>"+ datas.body +"</p>" +"</div>" );
          bringmessages();
        });
    }


    function sendmessage(event){
        if (event.keyCode == 13){

          event.preventDefault();

           var message_content = document.getElementById('message_content').value;
           var user = "{{ Auth::user()->name }}";

          if (message_content != "" ){

             $.post("{{ route("chat") }}", {"message": message_content , "_token": token , "user":user}, function(data) {
                
                 $datas = jQuery.parseJSON(data);

                  document.getElementById("chat-box").innerHTML += "<div class='item' data-id='"+ datas.id +"'>"+"<img src='/images/users/"+ datas.user_img +"' alt='user image' class='online'>" + "<p class='message'><a href='#' class='name'><small class='text-muted pull-right'><i class='fa fa-clock-o'></i> Today</small>"+ datas.user +"</a>"+ message_content +"</p>" +"</div>";
                $("#message_content").val('');
            });

            $("#defult-message").remove();

          } else {
              alert("ادخل محتوى الرسالة");
          }

          return false;
        }
    }
/*
    var online = document.getElementById("online");
    if (online.className == "btn btn-default btn-sm active"){
      var socket = io.connect('http://localhost:8890');

        socket.on('message', function (data) {

          data = jQuery.parseJSON(data);

          console.log(data.user);

          $( "#chat-box" ).append( "<div class='item'>"+"<img src='/images/users/"+ data.user_img +"' alt='user image' class='online'>" + "<p class='message'><a href='#' class='name'><small class='text-muted pull-right'><i class='fa fa-clock-o'></i> Today</small>"+ data.user +"</a>"+ data.message +"</p>" +"</div>" );

        });


        socket.on('online_users', function (data) {

          data = jQuery.parseJSON(data);

          console.log(data.online_name);


          if (data.offline_name){ 
              document.getElementById(data.offline_name).innerHTML = "<i class='fa fa-circle text-gray'></i> Offline";
          }

        if (document.getElementById(data.online_name) == null){
          if (data.online_name){
            $( "#online_list" ).append( "<li>"+"<img src='/images/users/"+ data.image +"' alt='User Image' />"+"<a class='users-list-name' href=''>"+ data.online_name +"</a>"+"<span class='users-list-status' id='"+ data.online_name +"'>"+"<i class='fa fa-circle text-success'></i> Online</span></li>" );
          }
        } else {
          document.getElementById(data.online_name).innerHTML = "<i class='fa fa-circle text-success'></i> Online";
        }

        });


        $("#send_message").click(function(e) {

          e.preventDefault();

           var message_content = document.getElementById('message_content').value;
           var token = "{{ csrf_token() }}";
           var user = "{{ Auth::user()->name }}";

          if (message_content != "" ){

             $.post("{{ route("chat") }}", {"message": message_content , "_token": token , "user":user}, function(data) {
                console.log(data);
                $("#message_content").val('');
            });

            $("#defult-message").remove();

          } else {
              alert("ادخل محتوى الرسالة");
          }

          return false;
        });
    } else {
        $( "#chat-box" ).append( "<div class='item'>" + "<div class='alert alert-info'>انت في وضع اﻷوفلين" + "</div>" +"</div>" );
    }
*/
   $(function() {
     bringmessages();
   });

  </script>

@endsection