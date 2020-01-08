<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Product;
use App\Category;
use App\Contact;
use App\Config;
use App\Banner;
use App\Testimoni;

class ApiController extends Controller
{
    public function serviceData()
    {
        $service = Service::where('serviceDelete',0)->get();

        return response([
            'status' => 200,
            'result' => $service
        ]);
    }

    public function productData()
    {
        $data = [];
        $product = Product::join('categories','categories.categoryId','=','products.categoryId')
                            ->where('productDelete',0)
                            ->get();
        foreach ($product as $pr) {
           $data[] = [
               'productId'          => $pr->productId,
               'productName'        => $pr->productName,
               'productDescription' => $pr->productDescription,
               'productImage'       => asset('data/product/'.$pr->productImage),
               'categoryId'         => $pr->categoryId,
               'categoryName'       => $pr->categoryName
           ];
        }
        return response([
            'status' => 200,
            'result' => $data
        ]);
    }

    public function categoryData()
    {
        
        $category = Category::where('categoryDelete',0)->get();

        return response([
            'status' => 200,
            'result' => $category
        ]);
    }

    public function bannerData()
    {
        $banner = Banner::where('bannerDelete',0)->get();

        return response([
            'status' => 200,
            'result' => $banner
        ]);
    }

    public function productByCategory($categoryId)
    {
        $data = [];
        $product  = Product::join('categories','categories.categoryId','=','products.categoryId')->where(['products.categoryId' => $categoryId, 'productDelete' => 0])->get();
        foreach ($product as $pr) {
            $data[] = [
                'productId'          => $pr->productId,
                'productName'        => $pr->productName,
                'productDescription' => $pr->productDescription,
                'productImage'       => asset('data/product/'.$pr->productImage),
                'categoryId'         => $pr->categoryId,
                'categoryName'       => $pr->categoryName
            ];
         }
        return response([
            'status' => 200,
            'result' => $data
        ]);
    }

    public function staticData()
    {
        $config = Config::where('configDelete',0)->first();
        $contact= Contact::where('contactDelete',0)->first();

        return response([
            'status' => 200,
            'result' => [
                'config' => $config,
                'contact' => $contact
            ]
        ]);
    }

    public function testimoniData()
    {
        $testimoni = Testimoni::where('testimoniDelete',0)->get();

        return response([
            'status' => 200,
            'result' => $testimoni
        ]);
    }
}
