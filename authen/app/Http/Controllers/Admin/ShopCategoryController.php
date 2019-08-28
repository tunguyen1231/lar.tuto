<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\ShopCategoryModel;

class ShopCategoryController extends Controller
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
        $items = DB::table('shop_category')->paginate(10);
        /**
         * Đây là biến truyền từ controller xuống view
         */
        $data = array();
        $data['cats'] = $items;

        return view('admin.content.shop.category.index', $data);
    }

    public function create(){
        /**
         * Đây là biến truyền từ controller xuống view
         */
        $data = array();
        return view('admin.content.shop.category.submit', $data);
    }

    public function edit($id){
        $data = array();

        $item = ShopCategoryModel::find($id);
        $data['cat'] = $item;
        return view('admin.content.shop.category.edit', $data);
    }

    public function delete($id){
        $data = array();



        $item = ShopCategoryModel::find($id);
        $data['cat'] = $item;
        return view('admin.content.shop.category.delete', $data);
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
        ]);

        $input = $request->all();
        $item = new ShopCategoryModel();

        $item->name = $input['name'];
        $item->slug = $input['slug'] ? $this->slugify($input['slug']) : $this->slugify($input['name']);
        $item->images = isset($input['images']) ? $input['images'] : '';
        $item->intro = isset($input['intro']) ? $input['intro'] : '';
        $item->desc = isset($input['desc']) ? $input['desc'] : '';;

        $item->save();

        return redirect('admin/shop/category');
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $input = $request->all();
        $item = ShopCategoryModel::find($id);

        $item->name = $input['name'];
        $item->slug = $input['slug'] ? $this->slugify($input['slug']) : $this->slugify($input['name']);
        $item->images = isset($input['images']) ? $input['images'] : '';
        $item->intro = isset($input['intro']) ? $input['intro'] : '';
        $item->desc = isset($input['desc']) ? $input['desc'] : '';;

        $item->save();

        return redirect('admin/shop/category');
    }

    public function destroy($id){
        $item = ShopCategoryModel::find($id);


        $item->delete();

        return redirect('admin/shop/category');
    }
}
