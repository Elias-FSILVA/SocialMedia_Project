<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use Session;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        if (isset($request->image) && $request->image->isValid()) {
            $nameFile = Str::of($request->title)->slug('-') . '.' . $request->image->getClientOriginalExtension();
            $image = $request->image->storeAs('posts', $nameFile, 'public');
            $data['image'] = $image;
        }

        if ($request->user) {
            $data['user'] = Session::get('email');
        }

        $post = Post::create($data);

        return redirect()->route('home', $post);
    }
}
