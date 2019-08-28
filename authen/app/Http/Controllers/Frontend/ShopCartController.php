<?php

namespace App\Http\Controllers\Frontend;


use App\Model\Front\ShopProductModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopCartController extends Controller
{
    //view giỏ hàng
    public function index(){

        $data = array();

        $cartCollection = \Cart::getContent();


        $data['cart_products'] = $cartCollection;
        $products = array();

        foreach ($cartCollection as $p){
            $pid = $p->id;
            $products[$pid] = ShopProductModel::find($pid);
        }

        $data['products'] = $products;
        $data['total_payment'] = \Cart::getTotal();
        $data['total_qtt_cart'] = \Cart::getTotalQuantity();

        return view('frontend.cart.index', $data);
    }

    /**
     * Thêm vào giỏ hàng
     */
    public function add(Request $request){

        $input = $request->all();


        $product_id = (int) $input['w3ls1_item'];
        $quantity = (int) $input['add'];

        $product = ShopProductModel::find($product_id);
        $response['status'] = 0;
        if (isset($product->id)){

            // array format
            \Cart::add(array(
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->priceSale,
                'quantity' => $quantity,
                'attributes' => array()
            ));
            $response['status'] = 1;
            session()->save();
        }
        echo json_encode($response);
        exit;
    }

    /**
     * update giỏ hàng
     */
    public function update(Request $request){

        $input = $request->all();


        $product_id = (int) $input['pid'];
        $qtt = (int) $input['quantity'];

        $product = ShopProductModel::find($product_id);
        $response['status'] = 0;
        if (isset($product->id)){

            // array format
//            \Cart::update($product->id, array(
//                'quantity' => $qtt, // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
//            ));

            \Cart::update($product->id, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $qtt
                ),
            ));
            $response['status'] = 1;
            session()->save();
        }
        echo json_encode($response);
        exit;

    }

    /**
     * remove giỏ hàng
     */
    public function remove(Request $request){
        $input = $request->all();


        $product_id = (int) $input['pid'];

        $product = ShopProductModel::find($product_id);
        $response['status'] = 0;
        if (isset($product->id)){

            // array format
            \Cart::remove($product->id);
            $response['status'] = 1;
            session()->save();
        }
        echo json_encode($response);
        exit;
    }

    /**
     * remove toàn bộ giỏ hàng
     */
    public function clear(){
        \Cart::clear();
    }
}
