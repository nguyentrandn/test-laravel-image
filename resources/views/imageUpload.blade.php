<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 Image Upload Example - ItSolutionStuff.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
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
        <div class="img-group">
            @foreach ($imgs as $img)
            
            <div class="img-item" id="img-{{$img->id}}">
                <img src="{{asset('images/'.$img->name)}}" alt="{{$img->name}}" style="width: 150px">
                <button onclick="handlerDelete({{$img->id}},'{{$img->name}}')" class="btn-close"><i class="fa-solid fa-xmark-lagred"></i></button>
            </div>
            
            @endforeach
        </div>
      </div>
    </div>
</div>
<!-- Jquery -->
<!-- <script src="js/js.js"></script> -->

<script type="text/javascript">
    function handlerDelete(id, name) {
    if (window.confirm('Are you sure you want to delete')) {
        $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('delete') }}",
        data: {
            "_token": "{{ csrf_token() }}",
            "id": id,
            "name": name
        },
        dataType: 'json',
        complete: function(){
            $("#img-" + id).remove();
        }
    })
    }

}
</script>
</body>
</html>