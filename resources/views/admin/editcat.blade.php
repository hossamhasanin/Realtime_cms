@extends("admin.main")

@section("title" , "| Create new category")

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
				<div class="col-md-12">
					      <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit: {{ $cat->name }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(["route" => ["admin.categories.update" , $cat->id] , "method" => "put" ,"role" => "form"]) }}
              <div class="box-body">
                <div class="form-group">
                 {{ Form::label("name" , "Category name") }}
                 {{ Form::text("name" , $cat->name ,["class" => "form-control"]) }}
                </div>
                <div class="form-group">
                 {{ Form::label("status" , "Status") }}
                 {{ Form::select("status" , ["1" => "Open" , "0" => "close"] , $cat->status , ["class" => "form-control"]) }}
                </div>
                <div class="form-group">
                 {{ Form::label("parent" , "Parent") }}
                 <select name="parent">
                 	<option value="0" @if($cat->parent == 0) selected="" @endif>None</option>
                 @foreach($parent_cats as $cate)
                 	<option value="{{ $cate->id }}" @if($cate->parent == $cat->parent && $cat->parent != 0) selected=""  @endif >{{ $cate->name }}</option>
                 @endforeach
                 </select>
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
		</section>
	</div>

@endsection