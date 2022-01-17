@extends('layouts.master')
@if(isset($title))
    @section('title')
    - {{ $title }}
    @endsection
@endif

@section('content')
    <div class="container-fluid">
        <form id="role-permission-form" method="POST" action="{{ route('roles.update-permissions', $role->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <table class="table table-bordered customtable text-center m-0">
                    <thead>
                        <tr><b class="text-center p-3">{{ $role->name }} - {{ $title }}</b></tr>
                        <th>Module</th>
                        @foreach(DNA::getActionList() as $action)
                            <th>{{ $action }}</th>
                        @endforeach
                    </thead>
                    <tbody>
                        @foreach($modules as $module)
                            <tr>
                                @php
                                    $rowspan = !empty($module->not_crud) ? '2' : '1';
                                @endphp
                                <td rowspan = {{ $rowspan }}>{{ $module->display_name }}</td>
                                @foreach(DNA::getActionList() as $key => $action)
                                    @php $exist = false; @endphp
                                    @foreach($module->permissions as $permission)
                                        @if($permission->action == $key)
                                            @php
                                                $exist = true;
                                                $checked = in_array($permission->id, $checked_permissions) ? 'checked' : '';
                                            @endphp
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="permissions[]" id="{{ $permission->id }}" value="{{ $permission->id }}" {{ $checked }}>
                                                    <label class="custom-control-label" for="{{ $permission->id }}"></label>
                                                </div>
                                            </td>
                                        @endif
                                    @endforeach
                                    @if(!$exist)
                                        <td></td>
                                    @endif
                                @endforeach
                                @if(!empty($module->not_crud))
                                    <tr>
                                        <td colspan="4">
                                            <div class="row text-left">
                                                @foreach($module->not_crud as $permission)
                                                @php
                                                    $checked = in_array($permission->id, $checked_permissions) ? 'checked' : '';
                                                @endphp
                                                    <div class="col-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="permissions[]" id="{{ $permission->id }}" value="{{ $permission->id }}" {{ $checked }}>
                                                            <label class="custom-control-label" style="font-weight:normal" for="{{ $permission->id }}">{{ $permission->display_name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-left">
                                <div class="row">
                                    <div class="col-md-3">
                                        <button class="role-permission-btn btn btn-primary" type="submit" style="width:100%">Submit</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(function () {
        $('.role-permission-btn').on('click', function(e){
            e.preventDefault();
            $('#role-permission-form').submit();
        })
    });
</script>
@endsection