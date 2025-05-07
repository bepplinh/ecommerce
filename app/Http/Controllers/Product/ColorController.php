<?php

namespace App\Http\Controllers\Product;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'asc');
        $colors = Color::orderBy('name', $sort)->get();

        return view('product.addColor', [
            'colors' => $colors,
            'title' => 'Manage Colors',
            'heading' => 'Color Management'
        ]);
    }

    

    public function store(Request $request)
    {
        $request = request();
        $request->validate([
            'name' => ['required', 'string', 'max:10'],
            'hex_code' => ['required', 'string', 'max:10'],
        ]);

        $color = new Color;
        $color->name = $request->name;
        $color->hex_code = $request->hex_code;
        $color->save();

        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'color added successfully',
        ]);
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('product.editColor', [
            'color' => $color,
            'title' => 'Edit Color',
            'heading' => 'Edit Color'
        ]);
    }

    public function update($id)
    {
        $color = Color::findOrFail($id);
        $request = request();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:10'],
            'hex_code' => ['required', 'string', 'max:10'],
        ]);
    
        $color->name = $validatedData['name'];
        $color->hex_code = $validatedData['hex_code'];

        $color->save();
    
        return redirect()->route('colors.index')->with('toastr', [
            'status' => 'success',  
            'message' => 'color updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $color = Color::find($id);
        $color->delete();
        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'color deleted successfully',
        ]);
    }
}
