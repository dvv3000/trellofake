@extends('layout.master')

@push('css')
    <style>

    </style>
@endpush

@section('content')
    {{-- Board buttons --}}
    <div class="d-flex justify-content-between">
        <div class="ms-4 ps-3">
            <h4 class=fs-3>{{ strtoupper($board->title) }}</h4>
        </div>
        <div class="board-actions d-flex justify-content-evenly me-3">
            <button class="btn btn-primary mt-3 me-3 info-btn" data-bs-toggle="modal" data-bs-target="#update-board">
                Info
            </button>

            @if (getRole($board) === 'OWNER')
                <button class="btn btn-primary mt-3 me-3 new-member-btn" data-bs-toggle="modal" data-bs-target="#add-member">
                    Add member
                </button>
                <button class="btn btn-primary mt-3 me-3 new-list-btn">
                    Add list
                </button>
                <form action="{{ route('board.delete', ['board' => $board->id]) }}" method="post" id="delete-board">
                    @csrf
                    @method('DELETE')
                </form>

                <button type="submit" class="btn btn-primary mt-3 me-3 delete-btn" data-bs-toggle="modal"
                    data-bs-target="#check-delete">
                    Delete
                </button>
            @endif



        </div>
    </div>
    {{-- End board buttons --}}


    {{-- Lists --}}
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between py-3">
                        <div class="fs-4">
                            List 1
                        </div>
                        <div class="action">
                            <a href="#" class="btn-sm btn-outline-light px-2 fs-5">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="#" class="btn-sm btn-outline-light px-2 fs-5">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body py-0">
                        <div class="card bg-gray-100 my-3">
                            <div class="mx-3 my-1 tag">
                                Tag
                            </div>
                            <div class="card-body d-flex justify-content-between pe-0">
                                <div class="fs-5">
                                    Card 1
                                </div>
                                <div class="">
                                    <a class="btn-sucess btn-sm fs-5 px-0">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </a>
                                    <a class="btn-outline-info btn-sm fs-5">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                </div>

                            </div>
                            <div class="d-flex justify-content-between p-2">
                                <div class="date">Due date</div>
                                <img src="#" class="img-circle" alt="avatar">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer mx-auto">
                        <button class="btn btn-primary new-card-btn">
                            Add new card
                        </button>
                    </div>
                </div>

            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between py-3">
                        <div class="fs-4">
                            List 1
                        </div>
                        <div class="action">
                            <a href="#" class="btn-sm btn-outline-light px-2 fs-5">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="#" class="btn-sm btn-outline-light px-2 fs-5">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body py-0">
                        <div class="card bg-gray-100 my-3">
                            <div class="mx-3 my-1 tag">
                                Tag
                            </div>
                            <div class="card-body d-flex justify-content-between pe-0">
                                <div class="fs-5">
                                    Card 1
                                </div>
                                <div class="">
                                    <a class="btn-outline-sucess btn-sm fs-5 px-0">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </a>
                                    <a class="btn-outline-info btn-sm fs-5">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                </div>

                            </div>
                            <div class="d-flex justify-content-between p-2">
                                <div class="date">Due date</div>
                                <img src="#" class="img-circle" alt="avatar">
                            </div>
                        </div>
                    </div>
                    <div class="card-body py-0">
                        <div class="card bg-gray-100 my-3">
                            <div class="mx-3 my-1 tag">
                                Tag
                            </div>
                            <div class="card-body d-flex justify-content-between pe-0">
                                <div class="fs-5">
                                    Card 1
                                </div>
                                <div class="">
                                    <a class="btn-outline-sucess btn-sm fs-5 px-0">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </a>
                                    <a class="btn-outline-info btn-sm fs-5">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                </div>

                            </div>
                            <div class="d-flex justify-content-between p-2">
                                <div class="date">Due date</div>
                                <img src="#" class="img-circle" alt="avatar">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer mx-auto">
                        <button class="btn btn-primary new-card-btn">
                            Add new card
                        </button>
                    </div>
                </div>

            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between py-3">
                        <div class="fs-4">
                            List 1
                        </div>
                        <div class="action">
                            <a href="#" class="btn-sm btn-outline-light px-2 fs-5">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="#" class="btn-sm btn-outline-light px-2 fs-5">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body py-0">
                        <div class="card bg-gray-100 my-3">
                            <div class="mx-3 my-1 tag">
                                Tag
                            </div>
                            <div class="card-body d-flex justify-content-between pe-0">
                                <div class="fs-5">
                                    Card 1
                                </div>
                                <div class="">
                                    <a class="btn-outline-sucess btn-sm fs-5 px-0">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </a>
                                    <a class="btn-outline-info btn-sm fs-5">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                </div>

                            </div>
                            <div class="d-flex justify-content-between p-2">
                                <div class="date">Due date</div>
                                <img src="#" class="img-circle" alt="avatar">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer mx-auto">
                        <button class="btn btn-primary new-card-btn">
                            Add new card
                        </button>
                    </div>
                </div>

            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between py-3">
                        <div class="fs-4">
                            List 1
                        </div>
                        <div class="action">
                            <a href="#" class="btn-sm btn-outline-light px-2 fs-5">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="#" class="btn-sm btn-outline-light px-2 fs-5">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>

                    <div class="card-footer mx-auto">
                        <button class="btn btn-primary new-card-btn">
                            Add new card
                        </button>
                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between py-3">
                        <div class="fs-4">
                            List 1
                        </div>
                        <div class="action">
                            <a href="#" class="btn-sm btn-outline-light px-2 fs-5">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="#" class="btn-sm btn-outline-light px-2 fs-5">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body py-0">
                        <div class="card bg-gray-100 my-3">
                            <div class="mx-3 my-1 tag">
                                Tag
                            </div>
                            <div class="card-body d-flex justify-content-between pe-0">
                                <div class="fs-5">
                                    Card 1
                                </div>
                                <div class="">
                                    <a class="btn-outline-sucess btn-sm fs-5 px-0">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </a>
                                    <a class="btn-outline-info btn-sm fs-5">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                </div>

                            </div>
                            <div class="d-flex justify-content-between p-2">
                                <div class="date">Due date</div>
                                <img src="#" class="img-circle" alt="avatar">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer mx-auto">
                        <button class="btn btn-primary new-card-btn">
                            Add new card
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
    {{-- End lists --}}

    {{-- Create  list --}}

    {{-- End create list --}}

    {{-- Create a new card --}}
    <div class="card position-absolute top-50 card-modal modal" style="width: 40rem; left: calc(50% - 300px);">
        <div class="card-header bg-gradient-primary text-white">
            <span>Name of card</span>
        </div>
        <div class="card-body">
            <form action="post" class="row">
                @csrf
                <div class="mb-3 col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <br>
                    <textarea name="description" id="" rows="3" class="w-100"></textarea>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="label" class="form-label">Label</label>
                    <select name="label" class="form-select form-select-sm">
                        <option value="1" class="text-danger">Important</option>
                        <option value="1" class="text-warning">Warning</option>
                        <option value="1" class="text-info">Take your time</option>
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="member" class="form-label">Member</label>
                    <select name="member" class="form-select form-select-sm">
                        <option value="1">Adam</option>
                        <option value="2">Zemo</option>
                        <option value="3">Marc</option>
                    </select>
                </div>
                <div class="mb-3 col-md-12">
                    <label for="due-time" class="form-label me-3">Due time:</label>
                    <input type="date" name="due-time" id="">
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="float-end">
                <button class="btn btn-secondary cancel-btn">Cancel</button>
                <button class="btn btn-primary">Submit</button>
            </div>


        </div>
    </div>
    {{-- End create a new card --}}


    {{-- Update board info modal --}}
    <div class="modal" id="update-board">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Update board</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('board.update', ['board' => $board->id]) }}" method="post" id="update-board">
                    @csrf
                    @method('PUT')
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Title</label>
                            <input type="text" class="form-control border rounded px-3" name="title" id="title-info"
                                value="{{ $board->title }}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="col-form-label">Description</label>
                            <textarea class="form-control border rounded px-3" name="description" id="description-info">{{ $board->description }}</textarea>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        @if (getRole($board) === 'OWNER')
                            <button type="submit" class="btn btn-danger" id="submit-info-btn">Submit</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add new member modal --}}

    <div class="modal" id="add-member">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add new member</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('board.addMember', ['board' => $board->id]) }}" method="post">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="email" class="form-control border rounded px-3" name="email">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Check delete button --}}
    <div class="modal" id="check-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure to delete that board?</h5>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer pb-3">
                    <button type="button" class="btn btn-danger mb-1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger mb-1" form="delete-board">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Throw message
        @if (Session::has('message'))
            alert('{{ Session::get('message') }}')
            @php Session::forget('message') @endphp
        @endif

        // let submitInfoBtn = document.querySelector('#submit-info-btn')
        let titleInfo = document.querySelector('#title-info')
        let descriptionInfo = document.querySelector('#description-info')

        @if (getRole($board) === 'MEMBER')
            // submitInfoBtn.disabled = true
            titleInfo.disabled = true
            descriptionInfo.disabled = true

            console.log(1)
        @endif
    </script>
@endpush
