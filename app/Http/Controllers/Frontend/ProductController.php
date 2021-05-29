<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Productvariation;
use App\Models\Product;
use App\Models\Productcolor;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{

    public function index($id,$name){
        $product=DB::table('products')->join('categories','products.category_id','categories.id')->join('subcategories','subcategories.id','products.subcategory_id')->select('products.*','categories.category','subcategories.subcategory')->where('products.id',$id)->first();
        $variation=Productvariation::where('product_id',$id)->get();
        $color=Productcolor::where('product_id',$id)->get();


       return view('frontend.productdetail',compact('product','variation','color'));
    }

   public function loadPrice($id){
       $price=Productvariation::find($id);
       return response()->json($price->price);
   }


   public function loadImage($id){
    $image=Productcolor::find($id);
    return response()->json(asset($image->image));
}
}
