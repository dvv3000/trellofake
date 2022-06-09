@extends('layout.master')

@push('css')
@endpush

@section('content')
    <!-- Figure  -->

    <!-- End figure  -->


    {{-- Show table --}}
    <div class="row mt-5">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h4 class="text-white text-capitalize ps-3">
                            Boards
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between">
                            <form action="" method="get" class="ms-5">
                                <label for="" class="me-3">Search</label>
                                <input type="text" name="q" value="{{ $search }}">
                            </form>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
                                Add your new board
                            </button>
                        </div>
                        <div class="data-table">
                            <table class="table align-items-center justify-content-center mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Role</th>
                                        <th>Description</th>
                                        <th>Created at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>


                                @for ($i = 0; $i < count($boards); $i++)
                                    <tr>
                                        <a href="{{ route('board.show', ['board' => $boards[$i]]) }}">
                                            <td>
                                                {{ $i }}
                                            </td>
                                            <td>
                                                {{ $boards[$i]->title }}
                                            </td>
                                            <td>
                                                {{ getRole($boards[$i]) }}
                                            </td>
                                            <td>
                                                {{ $boards[$i]->description }}
                                            </td>
                                            <td>
                                                {{ $boards[$i]->created_at }}
                                            </td>
                                            <td>
                                                <a href="{{ route('board.show', ['board' => $boards[$i]->id]) }}"
                                                    class="btn btn-primary my-1">Info</a>
                                            </td>
                                        </a>
                                    </tr>
                                @endfor
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav aria-label="Page navigation example">
        {{ $boards->links() }}
    </nav>

    {{-- End show table --}}


    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Create new board</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('board.store') }}" method="post" id="create-board">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Title</label>
                            <input type="text" class="form-control border rounded px-3" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="col-form-label">Description</label>
                            <textarea class="form-control border rounded px-3" name="description"></textarea>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-danger">
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        @if (Session::has('success'))
            alert('{{ Session::get('success') }}')
            @php Session::forget('success') @endphp
        @endif
    </script>
@endpush
