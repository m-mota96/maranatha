<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function createModifyCustomers(Request $request) {
        if (empty($request->customerId)) {
            $txt = 'guardo';
            $customer = Customer::create([
                'name' => !empty($request->customerName) ? trim($request->customerName) : null,
                'email' => !empty($request->customerEmail) ? trim($request->customerEmail) : null,
                'phone' => !empty($request->customerPhone) ? trim($request->customerPhone) : null,
            ]);
        } else {
            $txt = 'modifico';
            $customer = Customer::where('id', $request->customerId)->first();
            $customer->name = !empty($request->customerName) ? trim($request->customerName) : null;
            $customer->email = !empty($request->customerEmail) ? trim($request->customerEmail) : null;
            $customer->phone = !empty($request->customerPhone) ? trim($request->customerPhone) : null;
            $customer->save();
        }

        return response()->json([
            'error' => false,
            'msj'   => 'El cliente se '.$txt.' correctamente',
            'data' => $customer
        ], 200);
    }

    public function getCustomers(Request $request) {
        $customers = Customer::select(DB::raw('name as label'), DB::raw('name as value'), 'id')->where('name', 'LIKE', '%'.$request->search.'%')->get();
        return response()->json([
            'data' => $customers
        ], 200);
    }
}
