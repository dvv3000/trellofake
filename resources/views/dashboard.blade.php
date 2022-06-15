@extends('layout.master')


@push('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/date-1.1.2/fh-3.2.3/r-2.3.0/rg-1.2.0/sc-2.0.6/sp-2.0.1/sl-1.4.0/datatables.min.css"/>
@endpush


@section('content')
    <!-- Figure  -->
    <div class="container-fluid py-4">
        <div class="row justify-content-evenly">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-bars-progress"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Number of cards</p>
                            <h4 class="mb-0" id="n-cards"></h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-table-columns"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">From boards</p>
                            <h4 class="mb-0" id="n-boards"></h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End figure  -->

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h4 class="text-white text-capitalize ps-3">
                            Cards
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="data-table table">
                        <table class="table align-items-center justify-content-center mb-0" id="cards-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Board</th>
                                    <th>Label</th>
                                    <th>Status</th>
                                    <th>Due time</th>
                                    <th>Created at</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
 
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/date-1.1.2/fh-3.2.3/r-2.3.0/rg-1.2.0/sc-2.0.6/sp-2.0.1/sl-1.4.0/datatables.min.js"></script>
    <script>
            $('#cards-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{route('card.api.getAll')}}",
                        columns: [
                            {data: 'id', name: 'id'},
                            {data: 'title', name: 'title'},
                            {data: 'board_title', name: 'board'},
                            {data: 'label', name: 'label'},
                            {data: 'status', name: 'status'},
                            {data: 'due_time', name: 'due time'},
                            {data: 'created_at', name: 'created_at'},
                        ]
                    });
        
        
                let xhr = new XMLHttpRequest();
                xhr.open('GET', "{{route('card.api.getAll')}}", true);
        
                xhr.onload = () => {
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){

                            let cards = JSON.parse(xhr.responseText).data
                            document.getElementById('n-cards').innerHTML = cards.length

                            let boards = cards.map((object) => object.board_title)
                                                .filter((value, index, data) => data.indexOf(value) === index)
                                                
                            document.getElementById('n-boards').innerHTML = boards.length
                        }
                        else{
                            console.log(xhr.response)
                        }
                    }
                }
                xhr.send()
        </script>
@endpush
