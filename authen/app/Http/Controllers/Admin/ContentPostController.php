<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\ContentCategoryModel;
use App\Model\Admin\ContentPostModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ContentPostController extends Controller
{
    //
    /**
     * hàm khởi tạo của class được chạy ngay khi khởi tạo đối tượng
     * hàm này luôn được chạy trước các hàm khác trong class
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $items = DB::table('content_posts')->paginate(10);
        /**
         * Đây là biến truyền từ controller xuống view
         */
        $data = array();
        $data['posts'] = $items;

        return view('admin.content.content.post.index', $data);
    }

    public function create(){
        /**
         * Đây là biến truyền từ controller xuống view
         */
        $data = array();

        $cats = ContentCategoryModel::all();

        $data['cats'] = $cats;

        return view('admin.content.content.post.submit', $data);
    }

    public function edit($id){
        $data = array();

        $item = ContentPostModel::find($id);
        $data['post'] = $item;

        $cats = ContentCategoryModel::all();

        $data['cats'] = $cats;

        return view('admin.content.content.post.edit', $data);
    }

    public function delete($id){
        $data = array();



        $item = ContentPostModel::find($id);
        $data['post'] = $item;
        return view('admin.content.content.post.delete', $data);
    }
    public function slugify($str){
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ấ|ầ|ậ|ẩ|ẫ|ă|ắ|ằ|ẳ|ẵ|ặ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ê|ẽ|ế|ề|ể|ễ|ệ)/', 'e', $str);
        $str = preg_replace('/(í|ì|ỉ|ĩ|ị)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ủ|ũ|ụ|ư|ừ|ứ|ử|ữ|ự)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỷ|ỹ|ỵ)/', 'y', $str);
        $str = preg_replace('/(d)/', 'd', $str);
        $str = preg_replace('/([^a-z0-9-\s])/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'images' => 'required',
            'intro' => 'required',
            'desc' => 'required',
        ]);

        $input = $request->all();

        $item = new ContentPostModel();

        $item->name = $input['name'];
        $item->slug = $input['slug'] ? $this->slugify($input['slug']) : $this->slugify($input['name']);
        $item->images = $input['images'];
        $item->intro = $input['intro'];
        $item->author_id = isset($input['author_id']) ? $input['author_id'] : 0;
        $item->view = isset($input['view']) ? $input['view'] : 0 ;
        $item->desc = $input['desc'];
        $item->cat_id = $input['cat_id'];

        $item->save();

        return redirect('admin/content/post');
    }

    public function update(Request $request, $id){

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'images' => 'required',
            'intro' => 'required',
            'desc' => 'required',
        ]);

        $input = $request->all();

        $item = ContentPostModel::find($id);

        $item->name = $input['name'];
        $item->slug = $input['slug'] ? $this->slugify($input['slug']) : $this->slugify($input['name']);
        $item->images = $input['images'];
        $item->intro = $input['intro'];
        $item->author_id = isset($input['author_id']) ? $input['author_id'] : 0;
        $item->view = isset($input['view']) ? $input['view'] : 0 ;
        $item->desc = $input['desc'];
        $item->cat_id = $input['cat_id'];

        $item->save();

        return redirect('admin/content/post');
    }

    public function destroy($id){
        $item = ContentPostModel::find($id);


        $item->delete();

        return redirect('admin/content/post');
    }
}
