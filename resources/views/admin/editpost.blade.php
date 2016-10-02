@extends("admin.main")

@section("title" , "| Create post")

@section("stylies")
	
	{{ Html::Script("stylies/tinymce/js/tinymce/tinymce.min.js") }}

<script>
		  var editor_config = {
		    path_absolute : "/",
		    selector: "#create_post",
		    plugins: [
		      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
		      "searchreplace wordcount visualblocks visualchars code fullscreen",
		      "insertdatetime media nonbreaking save table contextmenu directionality",
		      "emoticons template paste textcolor colorpicker textpattern"
		    ],
		    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
		    relative_urls: false,
		    file_browser_callback : function(field_name, url, type, win) {
		      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
		      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

		      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
		      if (type == 'image') {
		        cmsURL = cmsURL + "&type=Images";
		      } else {
		        cmsURL = cmsURL + "&type=Files";
		      }

		      tinyMCE.activeEditor.windowManager.open({
		        file : cmsURL,
		        title : 'Filemanager',
		        width : x * 0.8,
		        height : y * 0.8,
		        resizable : "yes",
		        close_previous : "no"
		      });
		    }
		  };
		  tinymce.init(editor_config);
</script>

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
					<div class="col-md-12">
											 <div class="box box-primary">
            <div class="box-header with-border text-center">
              <h3 class="box-title">Edit: {{ $post->title }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(["route" => ["admin.posts.update" , $post->id] , "method" => "put" ,"role" => "form" , "files" => true]) }}
              <div class="box-body">
                <div class="form-group">
                 {{ Form::label("title" , "Title") }}
                 {{ Form::text("title" , $post->title ,["class" => "form-control" , "id" => "title_post" , "value" => "" , "onkeyup" => "slug_url()"]) }}
                </div>
                <div class="form-group">
                {{ Form::label("slug" , "Slug") }}
                {{ Form::text("slug" , $post->slug ,["class" => "form-control" , "id" => "slug_post"]) }}
                </div>
                <div class="form-group">
                 {{ Form::label("status" , "Status") }}
                 <select name="category" class="form-control">
                 @foreach($cats as $cat)
                 	<option value='{{ $cat->id }}' @if($post->id == $cat->id) selected="" @endif>{{ $cat->name }}</option>
                 @endforeach
                 </select>
                </div>
                <div class="form-group">
                	<textarea id="create_post" name="content">{{ $post->content }}</textarea>
                </div>
                <div class="form-group">
                  <img src='{{ asset("images/posts/$post->image") }}' id="reb_img" width="100" height="100" />
                </div>
                 <div class="form-group">
                 {{ Form::label("image" , "Post Image") }}
                 {{ Form::file("image" , ["onchange" => "readimg(this)"]) }}
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                {{ Form::submit("Save" , ["class" => "btn btn-primary"]) }}
              </div>
            {{ Form::close() }}
          </div>

					</div>
				</div>
			</div>
		</section>
	</div>

	<script type="text/javascript">
			
			function slug_url() {
				var title = $("#title_post").val();
				var pure_title = title.split(" ").join("-");
				var slug = $("#slug_post").val(pure_title);
			}
	</script>

@endsection