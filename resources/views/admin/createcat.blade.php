@extends("admin.main")

@section("title" , "| Create new category")

@section("content")

	<div class="content-wrapper">
		<section class="content">
			<div class="row">
				<div class="col-md-12">
					      <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add new Category</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(["route" => "admin.categories.store" , "method" => "post" ,"role" => "form"]) }}
              <div class="box-body">
                <div class="form-group">
                 {{ Form::label("name" , "Category name") }}
                 {{ Form::text("name" , "" ,["class" => "form-control"]) }}
                </div>
                <div class="form-group">
                 {{ Form::label("status" , "Status") }}
                 {{ Form::select("status" , ["1" => "Open" , "0" => "close"] , ["class" => "form-control"]) }}
                </div>
                <div class="form-group">
                 {{ Form::label("parent" , "Parent") }}
                 <select name="parent">
                 	<option value="0">None</option>
                 @foreach($parent_cats as $cat)
                 	<option value="{{ $cat->id }}">{{ $cat->name }}</option>
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