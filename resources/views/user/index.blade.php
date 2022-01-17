@extends('layouts.master')
@if(isset($title))
    @section('title')
    - {{ $title }}
    @endsection
@endif

@section('content')
    <div class="container-fluid">

        <div class="card p-3">
            <form method="get" action="{{ route('users.index') }}" id="search-form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input name="search_name" class="form-control" value="{{ request('search_name') }}"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Status </label>
                            <select name="search_status" class="form-control">
                                @foreach(DNA::getUserStatusList() as $key => $status)
                                    @php $selected = request('search_status') == $key ? 'selected' : ''; @endphp
                                    <option value="{{ $key }}" {{ $selected }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Address </label>
                            <textarea class="form-control" rows="3" name="search_address">{{ request('search_address') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search pr-2"></i>Search
                        </button>
                    </div>
                </div>
            </form>
       </div>
        <div class="card">
            <div class="card-header bg-white">
                <div class="card-tools">
                    @can('users-add')
                        <a class="btn btn-primary" href="{{ route('users.create') }}" style="color:white">
                            <i class="fas fa-plus mr-2"></i>
                            Create
                        </a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                sad
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
    @include('components.user.delete')
@endsection

@section('scripts')
{!! $dataTable->scripts() !!}

<script type="text/javascript">
    $(function () {
        $(document).on("click", ".delete_modal", function(e) {
            var that = $(this);
            var href = $(this).data('href');
            $("#user-delete-form").attr('action', href);

            $.get(href, function(data) {
                $("#user-delete-modal span[class='name']").html(data['name']);
            });
        });
    });
</script>
@endsection