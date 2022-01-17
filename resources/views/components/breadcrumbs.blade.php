@if(isset($title) && !empty($title))
    <div class="container-fluid pt-4">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 text-dark">{{ $title }}</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
@endif