<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use File;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    // function dưới đây là 1 kiểm tra auth cách khai báo controller bằng contrstruss
    public function __construct()
    {
        // auth chỉ mỗi 1 acction
        //$this->middleware('authCheck2')->only('create');
        // auth cả controller
        //$this->middleware('authCheck2');
        // auth tất cả các action khác trừ mỗi acction index
        $this->middleware('authCheck2')->except('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // lấy tất cả dữ liệu bảng
        //$posts = Post::all();
        // cũng lấy tất cả dữ liệu bảng nhưng giúp giải quyết vấn đề phân trang
        // $posts = Post::paginate(5); // phân trang

        // $posts = Cache::remember('posts', 3, function () {
        //     return Post::with('category')->paginate(5); // giải quyết lỗi về quan hệ bảng với bảng
        // });

        $posts = Cache::remember('posts-page-'.request('page', 1), 60*3, function () {
            return Post::with('category')->paginate(5); // giải quyết lỗi về quan hệ bảng với bảng , cách sẽ tối ưu nhất
        });


        // $posts = Cache::rememberForever('posts', function () {
        //     return Post::with('category')->paginate(5); // giải quyết lỗi về quan hệ bảng với bảng
        // });
        return view('index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // cách 1 để giới hạn người dùng
            //$this->authorize('create_post');
        // cách 2 để giới hạn người dùng
        $this->authorize('create',Post::class);

        $categories = Category::all();
        return view('create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$this->authorize('create_post');
        $this->authorize('create',Post::class);

        $request->validate([
            'image' => ['required', 'max :2028', 'image'],
            'title' => ['required', 'max :255'],
            'category_id' => ['required', 'integer'],
            'description' => ['required'],
        ]);

        // cách lưu file ảnh vào thư mục là 2 đoạn code dưới đây
        $fileName = time() . '_' . $request->image->getClientOriginalName();
        $filePath = $request->image->storeAs('uploads', $fileName);

        $post = new Post();
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->description = $request->description;
        $post->image = $filePath;
        $post->save();
        return redirect()->route('posts.index');
        //dd('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       // $this->authorize('edit_post');
       // điều chỉnh ở phần edit vì bên policy yêu cầu 1 đối số nên phải để dòng dưới đây lên đầu
       $post = Post::findOrFail($id);

       $this->authorize('update', $post);

        $categories = Category::all();
        return view('edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //$this->authorize('edit_post');
        $post = Post::findOrFail($id);

        $this->authorize('update', $post);

        //
        $request->validate([

            'title' => ['required', 'max :255'],
            'category_id' => ['required', 'integer'],
            'description' => ['required'],
        ]);


        if ($request->hasFile('image')) {
            $request->validate([
                'image' => ['required', 'max :2028', 'image'],
            ]);
            // cách lưu file ảnh vào thư mục là 2 đoạn code dưới đây
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $filePath = $request->image->storeAs('uploads', $fileName);

            File::delete(public_path($post->image));

            $post->image = $filePath;
        }


        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->description = $request->description;
        $post->save();
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('delete',$post);

        //$this->authorize('delete_post');

        $post->delete();

        return redirect()->route('posts.index');
    }

    public function trashed()
    {
        //$this->authorize('delete_post');

        $posts = Post::onlyTrashed()->get();
        return view('trashed', compact('posts'));
    }

    public function restore($id)
    {
        //$this->authorize('delete_post');

        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->back();
    }

    public function forceDelete($id)
    {
        //('delete_post');

        $post = Post::onlyTrashed()->findOrFail($id);
        $post->forceDelete();
        return redirect()->back();
    }
}
