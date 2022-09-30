{{-- modal Login  --}}
<div class="modal fade" id="login">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Modal Login</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('login')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Modal content -->
                <div class="container">
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" class="form-control w-50">
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" class="form-control w-50">
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" id="update" class="btn btn-primary" >Login</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
          </div>
    </div>
    </div>
</div>