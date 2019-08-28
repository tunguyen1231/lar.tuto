<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Front\BannerModel;
use App\Model\Front\BrandModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomepageController extends Controller
{
    public function index(){

        $data = array();

        $data['banner_main'] = $banner_main = BannerModel::getBannerByLocation(1);
        $data['sale1_banner'] = $sale1_banner = BannerModel::getBannerByLocation(2);
        $data['sale2_banner'] = $sale2_banner = BannerModel::getBannerByLocation(3);
        $data['sale3_banner'] = $sale3_banner = BannerModel::getBannerByLocation(4);
        $data['sale4_banner'] = $sale4_banner = BannerModel::getBannerByLocation(5);
        $data['sale5_banner'] = $sale5_banner = BannerModel::getBannerByLocation(6);

        $data['brands'] = $brands = BrandModel::all();
        return view('frontend.homepages.index', $data);
    }
}
