@extends('layouts.master')
@if(isset($title))
    @section('title')
    - {{ $title }}
    @endsection
@endif

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-white">
                @can('roles-add')
                    <div class="card-tools">
                        <a class="btn btn-primary" data-toggle="modal" data-target="#role-create-modal" style="color:white">
                            <i class="fas fa-plus mr-2"></i>
                            Create
                        </a>
                    </div>
                @endcan
            </div>
            <div class="card-body">
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
    @include('components.role.create')
    @include('components.role.show')
    @include('components.role.edit')



@endsection

@section('scripts')
{!! $dataTable->scripts() !!}

<script type="text/javascript">
    $(function () {
        $(document).on("click", ".edit_modal", function(e) {
            var that = $(this);
            var href = $(this).data('href');
            $("#role-edit-form").attr('action', href.replace('/edit', ''));

            $.get(href, function(data) {
                $("#role-edit-modal input[name='display_name']").val(data['display_name']);
                $("#role-edit-modal textarea[name='description']").val(data['description']);
            });
        });

        $(document).on("click", ".view_modal", function(e) {
            var that = $(this);
            var href = $(this).data('href');
            $.get(href, function(data) {
                $("#role-view-modal input[name='display_name']").val(data['display_name']);
                $("#role-view-modal textarea[name='description']").val(data['description']);
            });
        });
    });
</script>
@endsection