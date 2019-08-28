<?php

namespace App\Http\Controllers;

use App\Model\SellerModel;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * hàm khởi tạo của class được chạy ngay khi khởi tạo đối tượng
     * hàm này luôn được chạy trước các hàm khác trong class
     * SellerController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:seller')->only('index');
    }

    /**
     * phương thức trả về view khi đăng nhập seller thành công
     * @return [type] [description]
     */
    public function index(){
        return view('seller.dashboard');
    }

    /**
     * phương thức trả về view để đăng kí tài khoản seller
     * @return [type] [description]
     */
    public function create(){
        return view('seller.auth.register');
    }

    public function store(Request $request){


        // validate dữ liệu gửi từ form  đi
        $this->validate($request,array(
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ));

        // khởi tạo model để  lưu admin mới
        $sellerModel = new SellerModel();
        $sellerModel->name = $request->name;
        $sellerModel->email = $request->email;
        $sellerModel->password = bcrypt($request->password);
        $sellerModel->save();

        return redirect()->route('seller.auth.login');
    }
}
