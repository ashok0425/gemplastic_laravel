@extends('mail.layout')

   @section('content')
       <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                           <td>
                               <div class="invoice">
                                <h3>Invoice</h3> 
                      
                                 Invoice #: Es{{$order_id}}<br /> 
                                 
                               {{\Carbon\Carbon::parse($order_date)->format('d- M-Y')}}
                               <br>
                               Payment method:{{$payment_type}}
                               </div>
                            </td>
                               
                             <td>
                            <div class="bill" style='margin-left:18rem!important;'>
                                <h3>Bill to</h3>
                            {{$ship_name}}
                            <br>
                               {{$ship_email}}
                                <br>
                                {{$ship_phone}}
                                   <br>
                                {{$ship_address}}
                                </div>
                            </td>
                        </tr>
                        
                       
                    </table>
                </td>
            </tr>
            
              <tr class="heading" style='text-align:center!important;'>
                <td > Item</td>
                  <td > Quantity</td>
                    <td >Unit Price</td>
                      <td >Total Price</td>

               
            </tr>


@php $grandtotal=0; @endphp
@foreach ($cart as $item)
@php 

    $grandtotal +=$item->price;

@endphp
            <tr class="item" style='text-align:center!important;'>
                <td>   {{$item->name}}
                

                
                </td>

                <td>  {{$item->qty}}</td>
                 <td> {{__getPriceunit()}} {{number_format((float)$item->price,2)}}</td>
                  <td>   {{__getPriceunit()}} {{number_format((float)$item->qty *$item->price,2)}}</td>
                  
            </tr>
           @endforeach
        
            <tr class="total">
                
                <td colspan='4'>
                    
                <div class="padding">
                Sub-Total :{{__getPriceunit()}} {{ number_format($grandtotal,2)}}
              
                
                @if($coupon!=null)
                <br/>
                Discount : {{$coupon_value}}%
                @endif
                  <br/>Shipping Fee :{{__getPriceunit()}} {{number_format($shipping,2)}}<br/>
                               Total: {{__getPriceunit()}} {{number_format($total,2)}}
                </div>
                    </td>    
       
            </tr>
            
            
         
            
   @endsection
        