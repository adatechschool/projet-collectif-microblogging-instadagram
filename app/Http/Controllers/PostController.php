<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
//use Illuminate\Http\Response;

class PostController extends Controller
{
    
    public function index(): View 
    {
    
        //return view('posts.index');
        return view('posts.index', [
            'posts' => Post::with('user')->latest()->get(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $request->user()->posts()->create($validated);
 
        return redirect(route('posts.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        //
        Gate::authorize('update', $post);
 
        return view('posts.edit', [
            'post' => $post,
        ]);
    }

     /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, Post $post): RedirectResponse
     {
         //
         Gate::authorize('update', $post);
  
         $validated = $request->validate([
             'message' => 'required|string|max:255',
         ]);
  
         $post->update($validated);
  
         return redirect(route('posts.index'));
     }

      /**
     * Remove the specified resource from storage.
     */

     public function destroy(Post $post): RedirectResponse
    {
        //
        Gate::authorize('delete', $post);
 
        $post->delete();
 
        return redirect(route('posts.index'));
    }
}



