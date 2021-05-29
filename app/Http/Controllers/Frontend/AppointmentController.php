<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Apponitment;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Modal;
use App\Models\Part;
use App\Models\ApponitmentDetail;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(){
        return view('frontend.appointment.appointment');
    }



    
    public function loadData($table,$id,$option1,$option2){
     
        if($table=='category'){
           
            $sub=Subcategory::where('category_id',$id)->get();
            $data='';

        foreach ($sub as $value) {
            $data.="<option value='".$value->id."'>".$value->subcategory."</option>";
        }
                    return response()->json($data);
        }
        if($table=='subcategory'){
            $sub=Modal::where('category_id',$option1)->where('subcategory_id',$id)->get();
            $data='';

        foreach ($sub as $value) {
            $data.="<option value='".$value->id."'>".$value->modal."</option>";
        }
                    return response()->json($data);
        }

        if($table=='model'){
            $sub=Part::where('category_id',$option1)->where('subcategory_id',$option2)->where('modal_id',$id)->get();
            $data='';
       
        foreach ($sub as $value) {
            
            $data.="<option value='".$value->id."' data-price='".$value->price."'>".$value->part."</option>";
        }
                    return response()->json($data);
        }
        
    }

   public function loadPrice($id){
       $price=Part::where('id',$id)->value('price');
        return response()->json($price);
    }


    public function store(Request $request){
        $request->validate([
            'device'=>'required',
            'brand'=>'required',
            'model'=>'required',
            'name'=>'required',
            'email'=>'email|required',
            'phone'=>'required',
            'address'=>'required',
            'date'=>'required',
            'time'=>'required',
            'price'=>'required',




        ]);
        try {
            $appo=new Apponitment;           
     
            $appo->name=$request->name;
            $appo->phone=$request->phone;
            $appo->address=$request->address;
            $appo->email=$request->email;
            $appo->date=$request->date;
            $appo->total=$request->price;
            $appo->time=$request->time;

            if($appo->save()){
            $appoD=new ApponitmentDetail;           
                    $appoD->device=$request->device;
                    $appoD->brand=$request->brand;
                    $appoD->modal=$request->modal;
                    $appoD->part=$request->part;
                    $appoD->price=$request->price;
                    $appoD->msg=$request->msg;



                $notification=array(
                    'alert-type'=>'success',
                    'messege'=>'Thank you for choosing us.We are happy to see you at our store',
                   
                 );
                 return redirect()->back()->with($notification);
            }else{
                $notification=array(
                    'alert-type'=>'info',
                    'messege'=>'opps.we are having problem right now.Try again later.',
                   
                 );
                 return redirect()->back()->with($notification);
            }
            
           
        } catch (\Throwable $th) {
            $notification=array(
                'alert-type'=>'error',
                'messege'=>'Something went wrong.Please try again later',
                
             );
             return redirect()->back()->with($notification);
        
        }
    }


    public function history(){

        if(Auth::check()){
            try {
                //code...
           
            $appointment=Apponitment::where('user_id',Auth::user()->id)->get();
            return view('frontend.appointment.history',compact('appointment'));
        } catch (\Throwable $th) {
            $notification=array(
                'alert-type'=>'error',
                'messege'=>'Something went wrong.Try again later',
               
             );
             return redirect()->back()->with($notification);
        }
        }else{
            $notification=array(
                'alert-type'=>'error',
                'messege'=>'Please login',
               
             );
             return redirect()->route('/')->with($notification);
        }
      
    }


    public function show($id){

        if(Auth::check()){
            try {
                //code...
           
            $appointment=Apponitment::where('user_id',Auth::user()->id)->where('id',$id)->first();
            if($appointment){
                $appo=ApponitmentDetail::where('appointment_id',$id)->get();
                return view('frontend.appointment.show',compact('appointment','appo'));
            }else{
                $notification=array(
                    'alert-type'=>'error',
                    'messege'=>'Something went wrong.Try again later',
                   
                 );
                 return redirect()->route('/')->with($notification);
            }
          

        } catch (\Throwable $th) {
            $notification=array(
                'alert-type'=>'error',
                'messege'=>'Something went wrong.Try again later',
               
             );
             return redirect()->back()->with($notification);
        }
        }else{
            $notification=array(
                'alert-type'=>'error',
                'messege'=>'Please login',
               
             );
             return redirect()->route('/')->with($notification);
        }
      
    }


}