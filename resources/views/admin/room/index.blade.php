@extends('layouts.backoffice')
@section('menu-room','active')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAdd"><i class="bx bx-chat"></i> Tambah Room</button>
            <div class="row mt-4">
                @foreach ($room as $item)
                <div class="col-md-3 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="push-right">
                                <a href="{{ url('/room/chat/'.$item->code) }}" class="to-room"><i class='bx bx-link'></i></a>
                                <a data-bs-toggle="modal" data-bs-target="#modalActionDelete{{ $item->id }}" href='{{ url("/room/{$item->id}") }}'><i class='bx bx-trash'></i></a>
                                <a data-bs-toggle="modal" data-bs-target="#modalActionEdit{{ $item->id }}" href='{{ url("/room/{$item->id}") }}'><i class='bx bx-edit'></i></a>
                            </div>
                            <h2><b>{{ $item->code }}</b></h2>
                            <div>
                                {!! QrCode::size(200)->generate(url('/room/chat/'.$item->code)); !!}
                            </div>
                            <a href="{{ url('/room/pending-chat/'.$item->id) }}" class="btn btn-sm btn-secondary mt-3"><i class='bx bx-time-five' ></i> Pending Chat</a><br>
                            <small>Dibuat pada {{ date('d-m-Y', strtotime($item->created_at)) }}</small>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalActionEdit{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action='{{ url("room/$item->id") }}' method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update data</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Kode</label>
                                        <input type="text" class="form-control" name="code" value="{{ $item->code }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalActionDelete{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Yakin ingin menghapus <b>{{ $item->code }}</b>?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer">
                                <form action='{{ url("room/delete/$item->id") }}' method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Yakin</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Tambah Data -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('room/store') }}" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">Kode</label>
                            <input type="text" name="code" class="form-control" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        $('.to-room').click(function(e) {
            localStorage.setItem('flag-field', true);
        });
    </script>
@endpush