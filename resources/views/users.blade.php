@extends('auth.layout')

@section('content')

<table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama</th>
        <th scope="col">Email</th>
        <th scope="col">Photo</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email}}</td>
            <td><img src="{{asset('storage/'.$user->photo )}}" width="150px"></td>
            <td>
                <a href="{{ route('edit', $user->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
@endsection