<?php

namespace App\Http\Controllers\Product;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\Discount\CreateDiscountRequest;
use App\Http\Requests\Discount\UpdateDiscountRequest;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::paginate(10);
        return view('discount.listDiscount')->with([
            'discounts' => $discounts,
            'title' => 'List Discounts',
            'heading' => 'List Discounts',
        ]);
    }

    public function create()
    {
        return view('discount.addDiscount')->with([
            'title' => 'Create Discount',
            'heading' => 'Create Discount',
        ]);
    }

    public function store(CreateDiscountRequest $request)
    {
        try {
            $validated = $request->validated();

            // Format dates if provided
            if ($validated['start_at']) {
                $validated['start_at'] = Carbon::parse($validated['start_at']);
            }
            if ($validated['end_at']) {
                $validated['end_at'] = Carbon::parse($validated['end_at']);
            }

            // Create discount
            $discount = Discount::create($validated);

            return redirect()   
                ->route('discounts.index')
                ->with('toastr', [
                    'status' => 'success',
                    'message' => 'Discount created successfully',
                ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('toastr', [
                'status' => 'error',
                'message' => 'Failed to create discount: ' . $e->getMessage(),
            ]);
        }
    }

    public function show(Discount $discount)
    {
        //
    }

    public function edit($id)
    {
        $discount = Discount::find($id);
        return view('discount.editDiscount')->with([
            'title' => 'Edit Discount',
            'heading' => 'Edit Discount',
            'discount' => $discount,
        ]);
    }

    public function update(UpdateDiscountRequest $request, $id)
    {
        try {
            $validated = $request->validated();

            // Format dates if provided
            if ($validated['start_at']) {
                $validated['start_at'] = Carbon::parse($validated['start_at']);
            }
            if ($validated['end_at']) {
                $validated['end_at'] = Carbon::parse($validated['end_at']);
            }

            // Update discount
            $discount = Discount::find($id);
            if ($discount) {
                $discount->update($validated);
                return redirect()->route('discounts.index')->with('toastr', [
                    'status' => 'success',
                    'message' => 'Discount updated successfully',
                ]);
            } else {
                return redirect()->back()->with('toastr', [
                    'status' => 'error',
                    'message' => 'Discount not found',
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('toastr', [
                'status' => 'error',
                'message' => 'Failed to update discount: ' . $e->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        $discount = Discount::find($id);
        if ($discount) {
            $discount->delete();
            return redirect()->back()->with('toastr', [
                    'status' => 'success',
                    'message' => 'Discount deleted successfully',
                ]);
        } else {
            return redirect()->back()->with('toastr', [
                'status' => 'error',
                'message' => 'Discount not found',
            ]);
        }
    }
}
