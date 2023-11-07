@extends('auth.layout')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">Edit Data</div>
            {{-- <p>test : {{ $user->id }}</p> --}}
            <div class="card-body">
                <form action="{{ route('update', ['id'=>$users->id]) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $users->name }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="photo" class="col-md-4 col-form-label text-md-end text-start">Photo</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" value="{{ old('photo') }}">
                            @if ($errors->has('photo'))
                            <span class="text-danger">{{ $errors->first('photo') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="photoSize" class="col-md-4 col-form-label text-md-end text-start">Photo Size</label>
                        <div class="col-md-6">
                            <select class="form-select" id="photoSize" name="photoSize">
                                <option value="thumbnail" {{ $users->photo_size === 'thumbnail' ? 'selected' : '' }}>Thumbnail</option>
                                <option value="square" {{ $users->photo_size === 'square' ? 'selected' : '' }}>Square</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Edit">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
    
@endsection