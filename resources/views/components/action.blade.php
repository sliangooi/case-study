@if (empty($no_action))
    <a role="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Action
    </a>
    <div class="dropdown-menu dropdown-menu-right" style="cursor:pointer">

        {{-- view modal --}}
        @isset($view_modal)
            @can($view_modal['permission'] ?? null)
                <a class="dropdown-item {{ $view_modal['class'] }}"  data-toggle="modal" data-target="#{{ $view_modal['target'] }}" data-href="{{ $view_modal['href'] }}">
                    <i class="fas fa-eye mr-2 text-blue"></i>
                    View
                </a>
            @endcan
        @endisset

        {{-- view button --}}
        @isset($view)
            @can($view['permission'] ?? null)
                @if($view['permission'] ?? true)
                    <a role="button" href="{{ $view['route'] ?? '#' }}" class="dropdown-item" @isset($view['data_attr']) {!! $view['data_attr'] !!} @endisset>
                        <i class="fas fa-eye mr-2 text-blue"></i>
                        View
                    </a>
                @endif
            @endcan
        @endisset

        {{-- update modal --}}
        @isset($edit_modal)
            @can($edit_modal['permission'] ?? null)
                <a class="dropdown-item {{ $edit_modal['class'] }}"  data-toggle="modal" data-target="#{{ $edit_modal['target'] }}" data-href="{{ $edit_modal['href'] }}">
                    <i class="fas fa-edit mr-2 text-purple"></i>
                    Edit
                </a>
            @endcan
        @endisset

        {{-- update button --}}
        @isset($update)
            @can($update['permission'] ?? null)
                <a role="button" href="{{ $update['route'] ?? '#' }}" class="dropdown-item" @isset($update['data_attr']) {!! $update['data_attr'] !!} @endisset>
                    <i class="fas fa-edit mr-2 text-purple"></i>
                    Edit
                </a>
            @endcan
        @endisset

        {{-- delete mdoal --}}
        @isset($delete_modal)
            @can($delete_modal['permission'] ?? null)
                <a class="dropdown-item {{ $delete_modal['class'] }}"  data-toggle="modal" data-target="#{{ $delete_modal['target'] }}" data-href="{{ $delete_modal['href'] }}">
                    <i class="fas fa-trash mr-2 text-red"></i>
                    Delete
                </a>
            @endcan
        @endisset

        {{-- delete button --}}
        @isset($delete)
            @can($delete['permission'] ?? null)
                <a type="button" href="#deleteModal" class="dropdown-item" data-toggle="modal" data-delete-route="{{ $delete['route'] }}" @isset($delete['data_attr']) {!! $delete['data_attr'] !!} @endisset>
                    <i class="fas fa-trash mr-2 text-red"></i>
                    Delete
                </a>
            @endcan
        @endisset

        @isset($permission)
            @can($permission['permission'] ?? null)
                <div class="dropdown-divider"></div>
                    <a role="button" href="{{ $permission['route'] ?? '#' }}" class="dropdown-item">
                    <i class="fas fa-lock mr-2 text-dark"></i>
                        Change Permissions
                    </a>
                </div>
            @endcan
        @endisset

    </div>
@endif