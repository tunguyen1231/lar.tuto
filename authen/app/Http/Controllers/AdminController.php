<?php


namespace App\Http\Controllers;



use App\Model\AdminModel;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    /**
     * hàm khởi tạo của class được chạy ngay khi khởi tạo đối tượng
     * hàm này luôn được chạy trước các hàm khác trong class
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->only('index');
    }

    /**
	 * phương thức trả về view khi đăng nhập admin thành công
	 * @return [type] [description]
	 */
    public function index(){
    	return view('admin.dashboard');
    }


    /**
     * phương thức trả về view để đăng kí tài khoản admin
     * @return [type] [description]
     */
    public function create(){
    	//return view('admin.auth.register');
    	return view('admin.auth.registertemplate');
    }

    public function store(Request $request){


    	// validate dữ liệu gửi từ form  đi
        $this->validate($request,array(
           'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ));

        // khởi tạo model để  lưu admin mới
        $adminModel = new AdminModel();
        $adminModel->name = $request->name;
        $adminModel->email = $request->email;
        $adminModel->password = bcrypt($request->password);
        $adminModel->save();

    	return redirect()->route('admin.auth.login');
    }
}
