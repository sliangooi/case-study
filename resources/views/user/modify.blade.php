@extends('layouts.master')
@if(isset($title))
    @section('title')
    - {{ $title }}
    @endsection
@endif

@section('content')
<div class="container-fluid">
    <div class="card card-radius p-4">
        <form id="user-form" action="{{ $route }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($user->id ?? false)
                @method('PUT')
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name<span class="text-danger">*</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required/>
                            @error('name')
							    @include('components.invalid-feedback', compact('message'))
							@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email<span class="text-danger">*</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $user->email ?? '') }}"required/>
                            @error('email')
                                @include('components.invalid-feedback', compact('message'))
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @if(!$user->id)
                            <label>Password<span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="password" required/>
                            @error('password')
                                @include('components.invalid-feedback', compact('message'))
                            @enderror
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if(!$user->id)
                            <label>Confirm Password<span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="password_confirmation" required/>
                            @error('password_confirmation')
                                @include('components.invalid-feedback', compact('message'))
                            @enderror
                        @endif
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('Role') }}</label>
                            <select class="form-control" name="role" required>
                                @foreach($roles as $role)
                                    @php
                                        $check = $user->firstRole->id ?? '';
                                        $selected = old('role', $check) == $role->id ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $role->id }}" {{ $selected }}>{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>




<div class="card-body">
    <button class="btn float-right address_add_btn mr-3" type="button" style="background-color:lightgrey;" data-href="{{ route('address-render') }}">
        <i class="fas fa-thumbtack mr-2" style="font-size:16px;cursor:pointer"></i><span style="color:black">Address</span>
    </button>
    <div class="address_list">
        <div style="font-size:17px"><b><i>Address Detail</i></b></div>
        <hr>
        @if(old('addresses'))
            @foreach(old('addresses') as $key => $address)
                <div>
                    <div class="row">
                        <div class="col-md-11">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control @error('addresses.'.$key.'.address') is-invalid @enderror" name="addresses[{{ $key }}][address]">{{ old('addresses.'.$key.'.address') }}</textarea>
                                        @error('addresses.'.$key.'.address')
                                            @include('components.invalid-feedback', compact('message'))
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Postcode</label>
                                        <input type="text" class="form-control @error('addresses.'.$key.'.postcode') is-invalid @enderror" name="addresses[{{ $key }}][postcode]" value="{{ old('addresses.'.$key.'.postcode') }}"/>
                                        @error('addresses.'.$key.'.postcode')
                                            @include('components.invalid-feedback', compact('message'))
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control" name="addresses[{{ $key }}][state]">
                                            @foreach(DNA::getStateList() as $list_key => $value)
                                                @php
                                                    $selected = old('addresses.'.$key.'.state') == $list_key ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $list_key }}" {{ $selected }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control" name="addresses[{{ $key }}][country]">
                                            @foreach(DNA::getCountryList() as $list_key => $value)
                                                @php
                                                    $selected = old('addresses.'.$key.'.country') == $list_key ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $list_key }}" {{ $selected }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 text-right">
                            <i class="fas fa-trash mr-2 text-red delete_address" style="cursor: pointer;line-height:5"></i>
                        </div>
                    </div>
                </div>   
            @endforeach
        @else
            @foreach ($user->addresses as $key => $address)
                <div>
                    <div class="row">
                        <div class="col-md-11">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control @error('addresses.'.$key.'.address') is-invalid @enderror" name="addresses[{{ $key }}][address]">{{ $address->address }}</textarea>
                                        @error('addresses.'.$key.'.address')
                                            @include('components.invalid-feedback', compact('message'))
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Postcode</label>
                                        <input type="text" class="form-control @error('addresses.'.$key.'.postcode') is-invalid @enderror" name="addresses[{{ $key }}][postcode]" value="{{ $address->postcode }}"/>
                                        @error('addresses.'.$key.'.postcode')
                                            @include('components.invalid-feedback', compact('message'))
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control" name="addresses[{{ $key }}][state]">
                                            @foreach(DNA::getStateList() as $list_key => $value)
                                                @php
                                                    $selected = $address->state == $list_key ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $list_key }}" {{ $selected }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control" name="addresses[{{ $key }}][country]">
                                            @foreach(DNA::getCountryList() as $list_key => $value)
                                                @php
                                                    $selected = $address->country == $list_key ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $list_key }}" {{ $selected }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 text-right">
                            <i class="fas fa-trash mr-2 text-red delete_address" style="cursor: pointer;line-height:5"></i>
                        </div>
                    </div>
                </div>   
            @endforeach
        @endif
    </div>
</div>
            




            <div class="card-footer pt-4" style="background-color:white">
                <div class="row">
                    <div class="col-md-3">
                        <button id="user-btn" class="btn btn-primary" type="submit" style="width:100%">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
   $(function () {
        $('#user-btn').on('click', function(){
            $('#user-form').submit();
        })
        
        $('.address_add_btn').on('click', function(){
            var href = $(this).data('href');
            $.get(href, function(data) {
                $('.address_list').append(data);
            });
        });

        $(document).on('click','.delete_address',function(){
            $(this).parent().parent().parent().remove();

        });
   });
</script>
@endsection
