@extends('auth.layout')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <a href="{{ route('gallery.create') }}" class="btn btn-primary mb-4">Tambah Gambar</a>
        
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                <div class="row">
                    @if(count($galleries) > 0)
                    @foreach ($galleries as $gallery)
                    <div class="col-md-3 mb-3">
                        <div class="text-center">
                            <a class="example-image-link" href="{{asset('storage/posts_image/'.$gallery->picture)}}" data-lightbox="roadtrip" data-title="{{$gallery->description}}">
                                <img class="example-image img-fluid" src="{{asset('storage/posts_image/'.$gallery->picture)}}" alt="image-1" />
                            </a>
                            <h4>{{ $gallery->title }}</h4>
                            <p>{{ $gallery->description }}</p>
                            <div class="mt-2 d-flex justify-content-between">
                                <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <h3>Tidak ada data.</h3>
                    @endif
                </div>
                <div class="d-flex justify-content-center">
                    {{ $galleries->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
