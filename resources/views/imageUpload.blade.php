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
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="css/style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

</head>
      
<body>
<div class="container">
@auth
    @include('layouts.navigation')
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h2>Laravel 9 Image Upload Example</h2>
      </div>
      <div class="panel-body">
        <?php if(Auth::check()): ?>
        <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="mb-3">
                <label class="form-label" for="inputImage">Image:</label>
                <input 
                    type="file" 
                    {{-- them 1 mang vao Name --}}
                    name="image[]" 
                    id="inputImage"
                    multiple
                    class="form-control @error('image') is-invalid @enderror">
  
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Upload</button>
            </div>
        </form>
        <?php endif; ?>
        <div class="img-group">
            @foreach ($imgs as $img)
            <div class="img-item" id="img-{{$img->id}}">
                <img onclick="getImg({{$img->id}})" src="{{asset('images/'.$img->name)}}" alt="{{$img->name}}" style="width: 150px" data-bs-toggle="modal" data-bs-target="#modal-preview">
                <div class="btn-control">
                    <label><i class="fa-solid fa-ellipsis-vertical"></i></label>
                    <div class="btn-group">
                        <div class="btn-item">
                            <a class="btn-edited" id="update-btn" data-id="{{ $img->id }}" data-bs-target="#myModal" <?php if(Auth::check()) : ?> data-bs-toggle="modal" <?php else: ?> href="{{route('login')}}" <?php endif;?>>
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a <?php if(Auth::check()) : ?> onclick="handlerDelete({{$img->id}},'{{$img->name}}')" <?php else: ?> href="{{route('login')}}" <?php endif;?> class="btn-closer"><i class="fa-solid fa-x"></i></a>
                        </div>
                    </div>
                </div>
                <div class="btn-download"><a href="{{'images/'.$img->name}}" target="_blank" download><i class="fa-solid fa-circle-down"></i></a></div>
            </div>
            @endforeach
        </div>
        {{ $imgs->links() }}
        {{-- Modal Preview --}}
        <div class="modal fade" id="modal-preview">
            <div class="modal-dialog">
                <img src="" alt="" srcset="" class="img-modal-preview">
            </div>
        </div>
        {{-- Modal Update --}}
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
@endauth
@guest
    <p>No authenticated</p>
    <a href="{{ url('login') }}">Login</a>
@endguest
<!-- Jquery -->
<!-- <script src="js/js.js"></script> -->

<script  type="text/javascript" >
    // lang
    var url = "{{ route('changeLang') }}";
  
    $(".changeLang").change(function(){
        window.location.href = url + "?lang="+ $(this).val();
    });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Preview Functions
    function getImg(id) {
        $.get("{{url('getImgById')}}"+ "/" + id, function (data) {
            console.log(data);
            let img = data[0];
            $('.img-modal-preview').attr('src', `images/${img.name}`).fadeIn();
        })
    }
    // Delete Functions
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
    // Preview Update Functions
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
        // Functions Update
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
                            <img name="img-name" data-id="${img.id}" src="images/${img.name}" alt="" srcset="" width="150px" id="image-update-preview">
                        </div>
                        <div class="line"><i class="fa-solid fa-wave-square"></i></div>
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
<script src="/js/handle.js"></script>
</body>
</html>