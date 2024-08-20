@extends('layouts.backoffice')
@section('menu-dashboard','active')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <h5>Hi <b>{{ Auth::user()->name }}</b>, Selamat datang di halaman panel!</h5>
            <div class="row">
                <div class="col">
                    <div class="alert alert-info">
                        <h5>Jumlah Room </h5>
                        <h3><b>{{ $room }}</b></h3>
                    </div>
                </div>
                <div class="col">
                    <div class="alert alert-warning">
                        <h5>Jumlah Pesan Pending </h5>
                        <h3><b>{{ $pending }}</b></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
