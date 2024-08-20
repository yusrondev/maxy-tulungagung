@extends('layouts.backoffice')
@section('menu-room','active')
@section('content')
<style>
    .bg-info{
        background-color: #fff5e0 !important;
        animation: blink 1s; /* 1s is the duration, and infinite means it will keep blinking */

    }

    @keyframes blink {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Pesan</th>
                        <th>Lampiran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $key => $item)
                        <tr class="row-table" data-id="{{ $item->id }}">
                            <td>{{ ($key + 1) }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->text }}</td>
                            <td>
                                <img width="200px" src='{{ asset("$item->image") }}' alt="">
                            </td>
                            <td>
                                <a href="{{ url('/room/approve-chat/'.$item->id) }}" class="btn btn-primary"><i class='bx bx-check' ></i></a>
                                <a data-name="{{ $item->name }}" data-id="{{ $item->id }}" data-msg="{{ $item->text }}" class="btn btn-dark text-white reply"><i class='bx bx-message-dots'></i></a>
                                <form action="{{ route('chat.destroy', $item->id) }}" method="POST" class="d-inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class='bx bx-x'></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 labelmodal"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <small class="msg bg-light p-2"></small>
                <div class="form-group mt-4">
                    <input type="text" class="form-control text" name="text" placeholder="Masukkan balasan..." value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-id="" class="btn btn-primary reply-action">Balas</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
    <script>
        let id = "{{ $id }}";
        let approve_link = "{{ url('/room/approve-chat') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '.reply', function(){
            $('.labelmodal').html(`Balas pesan dari : ` + $(this).data('name'));
            $('.msg').html(`"` + $(this).data('msg') + `"`);
            $('.modal').modal('show');
            $('.reply-action').attr('data-id', $(this).data('id'));
        });

        $('body').on('click', '.reply-action', function(){
            let id_msg = $(this).data('id');
            let msg = $(this).parents().find('.text').val();
            $.ajax({
                url : "{{ url('/room/reply-chat') }}",
                type : "POST",
                data : {
                    id_msg : id_msg,
                    text : msg
                },
                success:function(res) {
                    window.location.reload();
                }
            });
        });
        
        setInterval(() => {
            $.ajax({
                url : "{{ url('/room/pending-chat') }}" + "/" + id,
                type : "GET",
                success:function(res){
                    res.forEach(item => {
                        // Check if the message already exists
                        if (!$(`.row-table[data-id="${item.id}"]`).length) {
                            let newMessage = `
                                <tr class="row-table bg-info text-dark" data-id="${item.id}">
                                    <td>${$(`.row-table`).length + 1}</td>
                                    <td>${item.name}</td>
                                    <td>${item.text}</td>
                                    <td><img width="200px" src="{{ asset('${item.image}') }}"></td>
                                    <td>
                                        <a href="${approve_link + "/" + item.id}" class="btn btn-primary"><i class='bx bx-check' ></i></a>
                                        <a data-name="${item.name}" data-id="${item.id}" data-msg="${item.text}" class="btn btn-dark reply text-white"><i class='bx bx-message-dots'></i></a>
                                        <a href="#" class="btn btn-danger delete-chat" data-id="${item.id}"><i class='bx bx-x'></i></a>
                                    </td>
                                </tr>
                            `;

                            // Append the new message
                            $('tbody').append(newMessage);
                        }
                    });
                }
            })

        }, 500);

        $('body').on('click', '.delete-chat', function(){
            let id_msg = $(this).data('id');
            let elem = $(this);
            $.ajax({
                url : "{{ url('/room/delete-chat') }}" + "/" + id_msg,
                type : "DELETE",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success:function(res) {
                    console.log(res);
                },
                error:function(err){
                    elem.closest('tr').remove();
                }
            });
        });
    </script>
@endpush
