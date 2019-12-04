<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Auth;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('blogs/index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        return view('blogs/single', compact('blog'));
    }

    public function create()
    {
        return view('blogs/create');
    }

    public function store(Request $request)
    {
//        $request->validate([
//            'title' => 'required',
//            'subject' => 'required',
//        ]);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'subject' => 'required'
        ]);

//        if ($validator->fails()) {
////            dd(redirect()->back()->withInput());
//            $request->session()->flash('error', $validator->messages()->first());
////            dd(redirect()->back()->withInput());
//            return redirect()->back()->withInput();
//        }

        Blog::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'slug' => str_slug($request->title),
            'subject'=> $request->subject
        ]);
        return redirect('/blog/'.str_slug($request->title));
    }

    public function edit($slug)
    {
        $blog = Blog::where('slug', $slug)->first();

        if($blog->user->id !== Auth::user()->id)
            abort(403);

        return view('blogs/edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);

        if($blog->user->id !== Auth::user()->id)
            abort(403);

        $blog->update([
            'title' => $request->title,
            'subject' => $request->subject,
        ]);

        return redirect('/blog/'.$blog->slug);
    }


}
