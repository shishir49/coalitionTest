<?php

namespace App\Http\Controllers;

use App\Models\Master;
use Illuminate\Http\Request;
use DataTables;

class MasterController extends Controller
{   
    //-----------------------------------Front Page-----------------------------------
    
    public function index(Request $request)
    {   
        if ($request->ajax()) {

            $jsonData = file_get_contents("../resources/views/json/test.json");

            $getAllProducts = json_decode($jsonData);
            return Datatables::of($getAllProducts)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="submit" id="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Pages.home');
    }


    //--------------------------------Add a Product ----------------------------------

    public function addProduct(Request $r){

        $allProducts = file_get_contents("../resources/views/json/test.json");

        $products = json_decode($allProducts, true);

        $numberOfProducts = count($products);

        $addProduct = array( 
                     'id' => $numberOfProducts, 
                     'product_name' =>   $r->product_name ,  
                     "product_quanity"=> $r->quantity,
                     'per_item_price' =>   $r->per_item_price ,  
                     "total_price"=> $r->total     
                );  
        $products[] = $addProduct;  
                
        
        $newProduct = json_encode($products);

        file_put_contents("../resources/views/json/test.json", $newProduct);
   }


   //-----------------------------Get Product Data By Id-----------------------------

    public function getProductDataById($id){

        $allProductData = file_get_contents("../resources/views/json/test.json");

        $productDataById = json_decode($allProductData);

        echo json_encode($productDataById[$id]);
    }


   //-----------------------------Get Product Data By Id-----------------------------


    public function editProduct(Request $r){
        $allProductData = file_get_contents("../resources/views/json/test.json");

        $productDataById = json_decode($allProductData, true);

        foreach ($productDataById as $key => $value) {
             if ($value['id']==$r->id) {
                 $productDataById[$key]['product_name'] = $r->product_name;
                 $productDataById[$key]['product_quanity'] = $r->quantity;
                 $productDataById[$key]['per_item_price'] = $r->per_item_price;
                 $productDataById[$key]['total_price'] = $r->total;
             }
        }

        $productUpdated = json_encode($productDataById, JSON_PRETTY_PRINT);

        file_put_contents("../resources/views/json/test.json", $productUpdated);
    }
}
