@extends('products.layout')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('products.update',$product->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
			
			
			<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Price:</strong>
				<input type="number" name="price" value="{{ $product->price }}" step="0.01" class="form-control" placeholder="Price">
			</div>
        </div>
		
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Quantity:</strong>
				<input type="number" name="quantity" value="{{ $product->quantity }}" step="0" class="form-control" placeholder="Quantity">
			</div>
        </div>
		
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Size:</strong>
                <input type="text" name="size" value="{{ $product->size }}" class="form-control" placeholder="Size">
            </div>
        </div>
		
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Product Code:</strong>
                <input type="text" name="code" value="{{ $product->code }}" class="form-control" placeholder="Code" maxlength="4">
            </div>
        </div>
			
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
   
    </form>
@endsection