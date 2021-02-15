@extends('layouts.dashboard')
    @section('content')
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8 align-self-center"> 
                        <h3><i class="fas fa-users">Users</i></h3>
                    </div>

                    <div class="col-4  text-right">
                        <button class="btn btn-sm text-secondary" data-toggle="modal" data-target="#deleteModal" title="Delete"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                    <form method="post" action="{{ route('dashboard.users.update', ['id' => $user->id]) }}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') {{ 'is-invalid'}} @enderror" name="name" value="{{ old('name') ?? $user->name}}">        
                           <!--4# ini langkah membuat validasi -->
                            @error('name')
                                <span class="text-danger">{{ $message}}
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                        <input type="text" class="form-control @error('email') {{ 'is-invalid' }} @enderror" name="email" value="{{old('email') ?? $user->email}}">

                             <!--5# ini langkah membuat validasi -->
                            @error('email')
                                 <span class="text-danger">{{ $message}}</span>
                            @enderror
                        </div>
                        {{--ini untuk membuat cancel menggunakan javascript--}}
                        <div class="form-group mb-2">
                            <button type="button" onclick="window.history.back()" class="btn btn-secondary btn-sm">Cancel</button>
                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <p>Apa kamu yakin ingin menghapus user {{ $user->name }} ??</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('dashboard.users.delete', ['id'=> $user->id]) }}" method="post">
                        @csrf
                            <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    @endsection