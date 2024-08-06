<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Customers',
        ];
        return view('admin.customers.index', $data);
    }
    public function getCustomersDataTable()
    {
        $customers = Customer::select(['id', 'name', 'phone', 'address', 'created_at', 'updated_at'])->orderByDesc('id');

        return Datatables::of($customers)
            ->addColumn('action', function ($customer) {
                return view('admin.customers.components.actions', compact('customer'));
            })
            ->addColumn('phone', function ($customer) {
                return '<a href="https://wa.me/' . $customer->phone . '" target="__blank">' . $customer->phone . '</a>';
            })
            ->rawColumns(['action', 'phone'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $customerData = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ];

        if ($request->filled('id')) {
            $customer = Customer::find($request->input('id'));
            if (!$customer) {
                return response()->json(['message' => 'customer not found'], 404);
            }

            $customer->update($customerData);
            $message = 'customer updated successfully';
        } else {
            Customer::create($customerData);
            $message = 'customer created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $customers = Customer::find($id);

        if (!$customers) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customers->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
    public function edit($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'customer not found'], 404);
        }

        return response()->json($customer);
    }
}
