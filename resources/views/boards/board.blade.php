@extends('layout.master')

@push('css')
    <style>
        .completed {
            color: #20c997;
        }
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

            @if (getRole($board->role) === 'OWNER')
                <button class="btn btn-primary mt-3 me-3 new-member-btn" data-bs-toggle="modal" data-bs-target="#add-member">
                    Add member
                </button>
                <button class="btn btn-primary mt-3 me-3 new-list-btn" data-bs-toggle="modal" data-bs-target="#create-task">
                    Add Task
                </button>

                <button type="submit" class="btn btn-primary mt-3 me-3 delete-btn" data-bs-toggle="modal"
                    data-bs-target="#delete-modal" route="{{ route('board.delete', ['board' => $board->id]) }}"
                    onclick="getRouteForDeleteForm(this)">
                    Delete
                </button>
            @else

                <button class="btn btn-primary mt-3 me-3 quit-board-btn" data-bs-toggle="modal" data-bs-target="#quit-board">
                    Quit this board
                </button>
            @endif
        </div>
    </div>
    {{-- End board buttons --}}


    {{-- All tasks --}}
    <div class="container-fluid">
        <div class="row g-3">
            {{-- task --}}
            @foreach ($board->tasks as $task)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        {{-- Task name and its buttons --}}
                        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between py-3">
                            <div class="fs-4">
                                {{ $task->title }}
                            </div>
                            <div class="action d-flex justify-content-between">
                                <div class="btn-sm px-2 fs-5" data-bs-toggle="modal" data-bs-target="#update-task"
                                    data-attr="{{ $task->id }}" onclick="updateTaskInfo(this)" id="task-update-btn">
                                    <i class="fa-solid fa-pen"></i>
                                </div>
                                @if (getRole($board->role) === 'OWNER')
                                    <button class="btn-sm border-0 px-2 fs-5" data-bs-toggle="modal"
                                        data-bs-target="#delete-modal" style="background-color: transparent; color: #fff;"
                                        route="{{ route('task.delete', ['task' => $task->id]) }}"
                                        onclick="getRouteForDeleteForm(this)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endif

                            </div>
                        </div>
                        {{-- Cards --}}
                        <div class="card-body py-0">

                            @foreach ($task->cards as $card)
                                <div class="card bg-gray-100 my-3">
                                    {{-- Label and delete card --}}
                                    <div class="d-flex justify-content-between">
                                        <div class="mx-3 my-1 tag" style="color: {{ $card->label->color }}">
                                            {{ $card->label->name }}
                                        </div>
                                        @if (getRole($board->role) === 'OWNER')
                                            <button type="submit" class="border-0 me-1 mt-2" data-bs-toggle="modal"
                                                data-bs-target="#delete-modal" style="background-color:transparent;"
                                                route="{{ route('card.delete', ['card' => $card->id]) }}"
                                                onclick="getRouteForDeleteForm(this)">
                                                <i class="fa-solid fa-circle-xmark"></i>
                                            </button>
                                        @endif

                                    </div>

                                    <div class="card-body d-flex justify-content-between pe-0 py-4 ps-3">
                                        <div class="fs-5">
                                            @if (strlen($card->title) < 12)
                                                {{ $card->title }}
                                            @else
                                                {{ substr($card->title, 0, 9) . '...' }}
                                            @endif
                                        </div>
                                        <div class="">
                                            @if (session()->get('id') === $card->member->id)
                                                <a class=" btn-sm fs-5 px-0">
                                                    <i class="fa-solid fa-circle-check check-completed" id="status"
                                                        card="{{ $card->id }}" onclick="setStatus(this)"></i>
                                                </a>
                                            @endif

                                            <a class="btn-outline-info btn-sm fs-5" data-bs-toggle="modal"
                                                data-bs-target="#update-card" card="{{ $card->id }}"
                                                onclick="updateCardInfo(this)">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                        </div>

                                    </div>
                                    <div class="p-2 d-flex justify-content-between">
                                        <div class="date {{ isCompleted($card->status) }}"
                                            id="date-{{ $card->id }}">
                                            {{ $card->due_time }}</div>
                                        @if (isAssigned($card))
                                            <img src="{{ asset($card->member->avatar) }}" class="rounded-circle"
                                                style="width: 35px; height:35px" alt="avatar">
                                        @else
                                            <p></p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Create new card button --}}
                        <div class="card-footer mx-auto">
                            @if (getRole($board->role) === 'OWNER')
                                <button class="btn btn-primary new-card-btn mb-0" data-bs-toggle="modal"
                                    data-bs-target="#create-card" task="{{ $task->id }}"
                                    onclick="getTaskIdForCreateCard(this)">
                                    Add new card
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
            {{-- End tasks --}}
        </div>
    </div>
    {{-- End all tasks --}}


    {{-- Update board modal --}}
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
                            <div class="d-flex justify-content-start">
                                <h6 class="mx-1">Owner: {{ $owner->name }}</h6>
                                <img src="{{ asset($owner->avatar) }}" class="rounded-circle mx-3"
                                    style="width: 35px; height:35px">
                            </div>
                            <label for="title" class="col-form-label">Title</label>
                            <input type="text" class="form-control border rounded px-3 title" name="title" id="board-title"
                                value="{{ $board->title }}">

                            <label for="description" class="col-form-label">Description</label>
                            <textarea class="form-control border rounded px-3 description" name="description" id="board-description">{{ $board->description }}</textarea>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        @if (getRole($board->role) === 'OWNER')
                            <button type="submit" class="btn btn-danger">Submit</button>
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
    <div class="modal" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure to delete this board?</h5>
                    <form method="post" id="form-delete">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer pb-3">
                    <button type="button" class="btn btn-danger mb-1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger mb-1" form="form-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Quit board --}}
    <div class="modal" id="quit-board">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure to quit this board?</h5>
                    <form method="post" action="{{ route('board.quit', ['board' => $board->id]) }}" id="quit">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer pb-3">
                    <button type="button" class="btn btn-danger mb-1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger mb-1" form="quit">Quit</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Create task modal --}}
    <div class="modal" id="create-task">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Create new task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('task.create', ['board' => $board->id]) }}" method="post" id="create-task">
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
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Update task info modal --}}
    <div class="modal" id="update-task">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Update task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="post" id="update-task-form">
                    @csrf
                    @method('PUT')
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-start">
                                <h6 class="mx-1">Owner: {{ $owner->name }}</h6>
                                <img src="{{ asset($owner->avatar) }}" class="rounded-circle mx-3"
                                    style="width: 35px; height:35px">
                            </div>
                            <label for="title" class="col-form-label">Title</label>
                            <input type="text" class="form-control border rounded px-3 title" name="title" id="task-title">

                            <label for="description" class="col-form-label">Description</label>
                            <textarea class="form-control border rounded px-3 description" name="description" id="task-description"></textarea>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        @if (getRole($board->role) === 'OWNER')
                            <button type="submit" class="btn btn-danger">Submit</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Create card modal --}}
    <div class="modal" id="create-card">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="card-name">New card</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="post" id="create-card-form">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Title</label>
                            <input type="text" class="form-control border rounded px-3 card-title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="col-form-label">Description</label>
                            <textarea class="form-control border rounded px-3 card-description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Color</label>
                            <select name="label-id" class="form-select form-select-sm select-label">
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="member" class="form-label">Member</label>
                            <select name="member-id" class="form-select form-select-sm select-member">
                            </select>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="due-time" class="form-label me-3">Due time:</label>
                            <input type="date" name="due-time" class="due-time">
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


    {{-- Update a card modal --}}
    <div class="modal" id="update-card">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="card-name">Update card</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="post" id="update-card-form">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Title</label>
                            <input type="text" class="form-control border rounded px-3 card-title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="col-form-label">Description</label>
                            <textarea class="form-control border rounded px-3 card-description" name="description"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="color" class="form-label">Color</label>
                            <select name="label-id" class="form-select form-select-sm select-label">
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="member" class="form-label">Member</label>
                            <select name="member-id" class="form-select form-select-sm select-member">
                            </select>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="due-time" class="form-label me-3">Due time:</label>
                            <input type="date" name="due-time" class="due-time">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label me-3">Status:</label>
                            <p class="form-label me-3 status"></p>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        @if (getRole($board->role) === 'OWNER')
                            <button type="submit" class="btn btn-danger">Submit</button>
                        @endif
                    </div>
                </form>
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

        // Disable all input fields while updating for member
        let inputFields = document.querySelectorAll('input type=["text"], textarea')
        let selectFields = document.querySelectorAll('select')

        @if (getRole($board->role) !== 'OWNER')
            for (input of inputFields) {
                input.disabled = true
            }
            for (select of selectFields) {
                select.disabled = true
            }
        @endif



        // Get all members 
        let xhrGetMember = new XMLHttpRequest();
        xhrGetMember.open('GET', "{{ route('board.getAllMembers', ['board' => $board->id]) }}", true);
        xhrGetMember.onload = () => {
            if (xhrGetMember.readyState === XMLHttpRequest.DONE) {
                if (xhrGetMember.status === 200) {
                    let data = JSON.parse(xhrGetMember.responseText);
                    // console.log(data)
                    let html = ''
                    for (user of data) {
                        html += `<option value="${user.id}">${user.email} - ${user.name}</option>`
                    }
                    let selectMemberFields = document.querySelectorAll('.select-member')
                    for (select of selectMemberFields) {
                        select.innerHTML = html
                    }

                } else {
                    console.log(xhrGetMember.response)
                }
            }
        }
        xhrGetMember.send()

        // Get all labels 
        let xhrGetLabels = new XMLHttpRequest();
        xhrGetLabels.open('GET', "{{ route('label.getAll') }}", true);
        xhrGetLabels.onload = () => {
            if (xhrGetLabels.readyState === XMLHttpRequest.DONE) {
                if (xhrGetLabels.status === 200) {
                    let data = JSON.parse(xhrGetLabels.responseText);
                    // console.log(data);
                    let html = ''
                    for (label of data) {
                        html += `<option value="${label.id}" style="color:${label.color}">${label.name}</option>`
                    }
                    let selectLabelFields = document.querySelectorAll('.select-label')
                    for (select of selectLabelFields) {
                        select.innerHTML = html
                    }

                } else {
                    console.log(xhrGetLabels.response)
                }
            }
        }
        xhrGetLabels.send()

        // Update task info
        function updateTaskInfo(element) {
            let taskId = element.getAttribute('data-attr')

            urlUpdate = "{{ route('task.update', ['task' => ':id']) }}"
            urlUpdate = urlUpdate.replace(':id', taskId)
            document.querySelector('#update-task-form').setAttribute('action', urlUpdate)

            let xhr = new XMLHttpRequest();
            urlShow = "{{ route('task.api.show', ['task' => ':id']) }}"
            urlShow = urlShow.replace(':id', taskId)
            xhr.open('GET', urlShow, true);

            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        data = JSON.parse(xhr.responseText);
                        document.querySelector('#task-title').setAttribute('value', data.title)
                        document.querySelector('#task-description').innerText = data.description
                    } else {
                        console.log(xhr.response)
                    }
                }
            }
            xhr.send()
        }

        function updateCardInfo(element) {
            let cardId = element.getAttribute('card')
            urlUpdate = "{{ route('card.update', ['card' => ':cardId']) }}"
            urlUpdate = urlUpdate.replace(':cardId', cardId)
            document.getElementById('update-card-form').setAttribute('action', urlUpdate)

            let xhr = new XMLHttpRequest();
            urlShow = "{{ route('card.show', ['card' => ':id']) }}"
            urlShow = urlShow.replace(':id', cardId)
            xhr.open('GET', urlShow, true);

            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        data = JSON.parse(xhr.responseText)
                        document.querySelector('#update-card-form .card-title').setAttribute('value', data.title)
                        document.querySelector('#update-card-form .card-description').innerText = data.description
                        document.querySelector('#update-card-form .due-time').setAttribute('value', data.due_time)

                        // Hardcode
                        document.querySelector('#update-card-form .status').innerText = data.status ? "COMPLETED" :
                            "PENDING"

                        if (data.member_id) {
                            document.querySelector(`#update-card-form .select-member [value="${data.member_id}"]`)
                                .selected = true
                        }
                    } else {
                        console.log(xhr.response)
                    }
                }
            }
            xhr.send()
        }

        function getTaskIdForCreateCard(element) {
            let taskId = element.getAttribute('task')
            let url = "{{ route('card.create', ['task' => ':id']) }}"
            url = url.replace(':id', taskId)
            document.getElementById('create-card-form').setAttribute('action', url)
        }

        function getRouteForDeleteForm(element) {
            let route = element.getAttribute('route')
            document.querySelector('#form-delete').setAttribute('action', route)
        }

        function setStatus(element) {
            let cardId = element.getAttribute('card')
            let url = "{{ route('card.setStatus', ['card' => ':id']) }}".replace(':id', cardId)
            let xhr = new XMLHttpRequest

            xhr.open('GET', url, true)
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        currentStatus = xhr.responseText
                        let a = document.querySelector(`#date-${cardId}`)
                        console.log(a)
                        a.classList.toggle('completed')

                    } else {
                        console.log(xhr.response)
                    }
                }
            }
            xhr.send()
        }
    </script>
@endpush
