<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //return $posts = Post::all();
        // Lấy data từ DB ra
            // nếu model của chúng ta ko phải số nhiều hay tên khác thì mình đặt tên model có tên trùng với Table của chúng ta
                // rồi set thêm biến protected $table('[tên table mình muốn Model này xài]')
            // giống như Yii2 khi sử dụng model nào thì mình phải khai báo namespace nó lên trên
            //return $posts = Post::all();

        // Kết nối Table và lấy dữ liệu name của nhau khi trùng dữ liệu
            //DB::table('posts')->join('categories','posts.category_id' , '=','categories.id')->get();
            // cái này có lưu ý , nên đọc lại note của note full

        // Delete data
            //1 : DB::table('posts')->where('id',59)->delete();
            //2 : DB::table('posts')->delete(59);
            // dạng 2 xóa data theo id

        // lấy data dạng where
            //DB::table('posts')->where('id','=',10)->get();

        // lấy 1 dữ liệu đầu tiên của Table
            //DB::table('posts')->first();

        // lấy 1 dữ liệu duy nhất với id của nó
            //DB::table('posts')->find(7);


        // lấy full DB
            return DB::table('posts')->get();

        // update Data DB
            // DB::table('posts')->where('id',59)->update(
            //     [
            //             'titile' => 'update title',
            //             'descripition' => 'update descripition',
            //     ]);

        // Học cách truyền dữ liệu cho page cơ bản nhất
            // $home = 'vãi cả sồi';
            // $blogs = [
            //     [
            //         'title' => 'title One',
            //         'body' => "this is a body text"
            //     ],
            //     [
            //         'title' => 'title Two',
            //         'body' => "this is a body text"
            //     ],
            //     [
            //         'title' => 'title Three',
            //         'body' => "this is a body text"
            //     ],
            //     [
            //         'title' => 'title Four',
            //         'body' => "this is a body text"
            //     ]
            // ];
            //return view('home',compact('blogs','home'));

        // trả về view
            //return view('home');
    }
}
