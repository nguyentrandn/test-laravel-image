<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 Image Upload Example - ItSolutionStuff.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
      
<body>
<div class="container">
       
    <div class="panel panel-primary">
  
      <div class="panel-heading">
        <h2>Laravel 9 Image Upload Example - ItSolutionStuff.com</h2>
      </div>
 
      <div class="panel-body">
       
        {{-- @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        <img src="public/images/{{ Session::get('image') }}">
        @endif --}}
      
        <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
  
            <div class="mb-3">
                <label class="form-label" for="inputImage">Image:</label>
                <input 
                    type="file" 
                    name="image" 
                    id="inputImage"
                    class="form-control @error('image') is-invalid @enderror">
  
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
   
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Upload</button>
            </div>
       
        </form>
        <div class="d-flex gap-1 img-group">
            @foreach ($imgs as $img)
            <div class="img-item">
                    <img src="{{asset('images/'.$img->name)}}" alt="{{$img->name}}" style="width: 150px">
                    <button class="btn-close"><i class="fa-solid fa-xmark-lagred"></i></button>
                </div>
            @endforeach
        </div>
      </div>
    </div>
</div>
</body>
    
</html>