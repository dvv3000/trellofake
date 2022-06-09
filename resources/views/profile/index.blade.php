@extends('layout.master')

@section('content')

    <div class="container-fluid py-0">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="card mt-4">
                    <div class="card-header p-3 bg-gradient-primary text-white">
                        Profile Information
                    </div>
                    <div class="card-body p-3 pb-0">
                        <form action="{{route('profile.update', ['user' => $user])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <div class="my-3">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" class="form-control ms-1 border rounded px-3" name="name" value="{{$user->name}}">
                                    </div>
        
                                    <div class="mb-3 ">
                                        <label for="password" class="form-label">Password:</label>
                                        <input type="password" class="form-control ms-1 border rounded px-3" name="password"
                                            placeholder="Password">
                                    </div>
                                </div>
    
                                <div class="form-group col-4">
                                    <label for="avatar">Avatar</label>
                                    <img src="{{ asset(session()->get('avatar')) }}" alt="avatar" class="rounded img-thumbnail" />
                                    <input type="file" name="avatar">
                                </div>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    {{$errors->first()}}
                                </div>
                            @endif

                            @if(Session::has('alert'))
                                <div class="alert alert-warning" role="alert">
                                    {{Session::get('alert')}}
                                    @php Session::forget('alert') @endphp
                                </div>
                            @endif
                            <button type="submit" class="btn btn-success float-end my-3">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush