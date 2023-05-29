@extends('layouts.admin')

@section('content')
<div class="container">

<h1>Crea post</h1>

    <form action="{{route('admin.posts.store')}}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title">Titolo</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}">
            @error('title')
              <div class="invalid-feedback">
                {{$message}}
              </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description">Descrizione post</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror">
            {{old('description')}}
            </textarea>
            @error('description')
              <div class="invalid-feedback">
                {{$message}}
              </div>
            @enderror
        </div>

        <div class="mb-3">
          <label for="category_id">Categoria</label>
          <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">

            <option value="">Nessuna</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{$category->id == old('category_id') ? 'selected' : ''}}>{{$category->name}}</option>
            @endforeach

          </select>
          @error('category_id')
            <div class="invalid-feedback">
             {{$message}}
            </div>
          @enderror
        </div>

        <div class="mb-3">
            <label for="language">Linguaggio</label>
            <input type="text" name="language" id="language" class="form-control @error('language') is-invalid @enderror" value="{{old('language')}}">
            @error('language')
              <div class="invalid-feedback">
                {{$message}}
              </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Conferma</button>
    </form>
</div>
@endsection