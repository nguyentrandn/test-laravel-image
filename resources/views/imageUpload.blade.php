<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 Image Upload Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="css/style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
      
<body>
<div class="container">
       
    <div class="panel panel-primary">
  
      <div class="panel-heading">
        <h2>Laravel 9 Image Upload Example</h2>
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
                <div class="btn-control">
                    <label><i class="fa-solid fa-ellipsis-vertical"></i></label>
                    <div class="btn-group">
                        <div class="btn-item">
                            <div class="btn-edited" id="update-btn" data-id="{{ $img->id }}" data-bs-toggle="modal" data-bs-target="#myModal">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div onclick="handlerDelete({{$img->id}},'{{$img->name}}')" class="btn-closer"><i class="fa-solid fa-x"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Update</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 box-preview">
                            <div class="img-review">
                            </div>
                            <label for="inputImage-update" class="preview-input"><i class="fa-solid fa-plus"></i></label>
                            <input 
                                type="file" 
                                name="image_update" 
                                id="inputImage-update"
                                class="form-control @error('image') is-invalid @enderror"
                                hidden
                                >
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" id="update" class="btn btn-primary" >Save</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                  </div>
            </div>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- Jquery -->
<!-- <script src="js/js.js"></script> -->

<script  type="text/javascript" >
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function handlerDelete(id, name) {
        if (window.confirm('Are you sure you want to delete')) {
            $.ajax({
                type: "POST",
                url: "{{route('delete')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "name": name
                },
                dataType: 'json',
                complete: function() {
                    $("#img-" + id).remove();
                }
            })
        }
    }
    // 
    function preview(input) {
            console.log($("#inputImage-update").get(0).files[0]);
            var file = $("#inputImage-update").get(0).files[0];
            if(file){
            var reader = new FileReader();
            reader.onload = function(e){
                $(".preview-image").attr({"src": e.target.result, "width": "150px"}).fadeIn();
                $(".preview-input").attr("style", "height: fit-content");
                $(".fa-plus").remove();
            }
            reader.readAsDataURL(file);
            }
    }
    $( document ).ready(function() {
        $('body').on('click','#update-btn', function() {
            // get id from data-id attribute
            var id = $(this).data('id');
            $.get("{{url('getImgById')}}"+ "/" + id, function (data) {
                let img = data[0];
                // truyen id qua ben controller
                $('.box-preview').replaceWith(`
                    <input type="hidden" name="id" value="${img.id}" />
                    <div class="mb-3 box-preview">
                        <div class="img-review">
                            <img name="img-name" data-id="${img.id}" src="images/${img.file_path}" alt="" srcset="" width="150px" id="image-update-preview">
                        </div>
                        <div class="line"></div>
                        <label for="inputImage-update" class="preview-input"><img src="" class="preview-image"><i class="fa-solid fa-plus "></i></img></label>
                        <input 
                            type="file" 
                            name="image_update" 
                            id="inputImage-update"
                            class="form-control @error('image') is-invalid @enderror"
                            hidden
                            onchange="preview(this)"
                        >
                    </div>
                `);
            })
        })
    });
        
 

</script>
</body>
</html>