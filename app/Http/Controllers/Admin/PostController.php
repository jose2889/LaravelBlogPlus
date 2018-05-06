<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

use Illuminate\Support\Facades\Storage;


use App\Post;
use App\Category;
use App\Tag;
use App\Policies\PostPolicy;


class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')
                ->where('user_id', auth()->user()->id)->paginate();

        return view('admin.posts.index', compact('posts'));
    }

    
    public function create()
    {
        $categories = Category::orderBy('name','ASC')->pluck('name','id');
        $tags = Tag::orderBy('name','ASC')->get();

        return view('admin.posts.create', compact('categories','tags'));
    }

    
    public function store(PostStoreRequest $request)
    {
        $post = Post::create($request->all());

        //aqui se crea el codigo para guardar imagenes
        if ($request->file('file')){
            $path = Storage::disk('public')->put('image', $request->file('file'));
            $post->fill(['file' => asset($path)])->save();
        }

        //aqui se relacionan las etiquetas

        $post->tags()->attach($request->get('tags'));

        return redirect()->route('posts.edit', $post->id)
        ->with('info', 'Contenido creada con exito');
    }

  
    public function show($id)
    {
        $post = Post::find($id);
        $this->authorize('acces', $post);
        return view('admin.posts.show', compact('post'));
    }

    
    public function edit($id)
    {
        $post = Post::find($id);
        $this->authorize('acces', $post);
        
        $categories = Category::orderBy('name','ASC')->pluck('name','id');
        $tags = Tag::orderBy('name','ASC')->get();

        return view('admin.posts.edit', compact('post','categories','tags'));
    }

    
    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::find($id);
        $this->authorize('acces', $post);
        
        $post->fill($request->all())->save();

        //aqui se crea el codigo para guardar imagenes
        if ($request->file('file')){
            $path = Storage::disk('public')->put('image', $request->file('file'));
            $post->fill(['file' => asset($path)])->save();
        }

        //aqui se relacionan las etiquetas

        $post->tags()->sync($request->get('tags'));


        return redirect()->route('posts.edit', $post->id)->with('info', 'Contenido actualizada con exito');
    }

   
    public function destroy($id)
    {
        $post = Post::find($id);
        $this->authorize('acces', $post);
        $post->delete();
        return back()->with('info','Eliminado correctamente');
    }
}
