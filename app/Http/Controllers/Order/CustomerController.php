<?php

namespace App\Http\Controllers\Order;

use Exception;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Helper\Traits\Filter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\Customer\StoreRequest;
use App\Http\Requests\Order\Customer\UpdateRequest;
use App\Http\Resources\Order\CustomerResource;

class CustomerController extends Controller
{
    use Filter;
    public function index(){
      $customers = CustomerResource::collection($this->getFilterData(Customer::class, [
        'like' => ["name", "address", "phone", "email"]
      ])->withQueryString());
      $params = $this->getParams();
      return inertia('Order/Customer', compact('customers', 'params'));
    }
    
    public function store(StoreRequest $req){
      try{
        Customer::create($req->validated());
        $toast = [
          'message' => 'Customer has <kbd>created</kbd> successful!', 
          'type' => 'success'
        ];
      } catch (Exception $e) {
        $toast = [
          'message' => $e->getMessage(), 
          'type' => 'error'
        ];
      }
      return redirect()->route('order.customer.index')->with('toast', $toast);
    }
    
    public function update($id, UpdateRequest $req){
      try{
        $customer = Customer::find($id);
        $customer->update($req->validated());
        $toast = [
          'message' => 'Customer <strong>'.$customer->name.'</strong> has <kbd>updated</kbd> successful!', 
          'type' => 'success'
        ];
      } catch (Exception $e) {
        $toast = [
          'message' => exception_message($e), 
          'type' => 'error'
        ];
      }
      return redirect()->back()->with('toast', $toast);
    }
    
    public function destroy($id){
      //sleep(5);
      try{
        $customer = Customer::findOrFail($id);
        $customer->delete();
        $toast = [
          'message' => 'Customer <strong>'.$customer->name.'</strong> has <kbd>deleted</kbd> successfull!', 
          'type' => 'success'
        ];
      }catch(\Exception $e){
        $toast = [
          'message' => exception_message($e), 
          'type' => 'error'
        ];
      }
      return redirect()->back()->with('toast', $toast);
    }
}
