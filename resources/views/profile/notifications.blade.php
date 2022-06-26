@extends('layout.master')

@section('content')
    <div class="card mt-4">
        <div class="card-header p-3">
            <h5 class="mb-0">Notifications</h5>
        </div>

        <div class="card-body p-3 pb-0 notif-content" id="notif-content">

        </div>
    </div>

@push('js')
    {{-- bugs on select element --}}


    <script>
        // Throw message
        @if (Session::has('message'))
            alert('{{ Session::get('message') }}')
            @php Session::forget('message') @endphp
        @endif
        let xhr = new XMLHttpRequest();

        xhr.open('GET', `{{ route('getNotifs') }}`, true);

        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    response = JSON.parse(xhr.responseText);

                    let html = ''
                    for (notif of response) {
                        boardId = notif.data.board.id
                        url = "{{ route('board.show', ['board' => ':id']) }}".replace(':id', boardId)
                        console.log(notif)
                        if (notif.type.includes('NewCardAssigned')) {
                            content = `<span class="text-white">
                                    You have a new card "${notif.data.card.title}" from board
                                    <a href="${url}" class="alert-link text-white">${notif.data.board.title}</a>
                                    . Check it out.</span>
                                    <span class="text-white float-end">${notif.created_at}</span>`
                        } else if (notif.type.includes('JoinBoard')) {
                            content = `<span class="text-white">
                                    You have been added to
                                    <a href="${url}" class="alert-link text-white"> a new board</a>
                                    . Check it out.</span>
                                    <span class="text-white  float-end">${notif.created_at}</span>`
                        } else {
                            content = `<span class="text-white">
                                    You just quitted 
                                    <a href="${url}" class="alert-link text-white"> ${notif.data.board.title}</a>
                                    board.</span>
                                    <span class="text-white float-end">${notif.created_at}</span>`
                        }
                        html +=
                            `<div class="alert alert-info alert-dismissible text-white" role="alert">
                                ${content}
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`
                    }

                    document.querySelector('.notif-content').innerHTML = html
                }
            }
        }
        xhr.send()
    </script>
