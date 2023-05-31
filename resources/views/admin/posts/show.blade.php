@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="py-3">
        <h1>Visualizzazione post</h1>
        <div class="text-center">
            <img class="w-50" src="{{ asset('storage/' . $post->cover_image) }}" alt="">
        </div>
        <div>Categoria: {{ $post->category?->name }}</div>
        <div>Tecnologie: @foreach ($post->technologies as $technology) 
           {{ $technology->name . ' ' }}
        @endforeach
        </div>

        <hr>

        <h2>{{$post->title}}</h2>

        <br>

        <h4>{{$post->slug}}</h4>

        <br>

        <p>{{$post->description}}</p>

        <h4>{{$post->language}}</h4>
    </div>

    <div class="d-flex justify-content-around">
        <a href="{{route('admin.posts.edit', $post)}}" class="btn btn-primary">Modifica post</a>
        
        <form action="{{route('admin.posts.destroy', $post)}}" method="POST">
            @csrf

            @method('DELETE')
          <button type="submit" class="btn btn-danger">Elimina post</button>
        </form>
    </div>
</div>
@endsection