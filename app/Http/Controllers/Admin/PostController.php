<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $technologies = Technology::all();
        return view('admin.posts.create', compact('categories', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->all();

        $this->validation($formData);

        $post = new Post();

        $post->fill($formData);
        $post->slug = Str::slug($post->title, '-');

        $post->save();

        $post->technologies()->attach($formData['technologies']);

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $technologies = Technology::all();
        return view('admin.posts.edit', compact('post', 'categories', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $formData = $request->all();

        $this->validation($formData);

        $post->slug = Str::slug($formData['title'], '-');

        $post->update($formData);

        if(array_key_exists('technologies', $formData)) {

            $post->technologies()->sync($formData['technologies']);

        } else {

            $post->technologies()->detach();
        }

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index');
    }

    private function validation($formData) {
        $validator = Validator::make($formData, [
            "title" => 'required|max:255|min:4',
            "description" => 'required',
            "language" => 'required',
            "category_id" => 'nullable|exists:categories,id',
            "technologies" => 'exists:technologies,id',
        ], [
            "title.max" => 'Il titolo deve avere massimo :max caratteri',
            "title.required" => 'Devi inserire un titolo',
            "category-id.exists" => 'La categoria deve essere presente',
            "tecnologies.exists" => 'La tecnologia deve essere presente',
        ])->validate();
    }
}
