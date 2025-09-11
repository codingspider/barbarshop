<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::all();
        return view('admin.currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('admin.currencies.create');
    }

    public function store(Request $request)
    {
        // Create validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies,code',
            'symbol' => 'nullable|string|max:10',
            'is_default' => 'nullable',
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            
            if ($request->is_default) {
                Currency::query()->update(['is_default' => false]);
            }

            $data = $request->all();
            $data['is_default'] = (int) $request->is_default;

            Currency::create($data);
            DB::commit();

            return redirect()->route('admin.currencies.index')->with('success', 'Currency created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.currencies.create')->with(['error' => $e->getMessage()]);
        }
    }

    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies,code,' . $currency->id,
            'symbol' => 'nullable|string|max:10',
            'is_default' => 'nullable',
        ]);
        // Handle validation failure
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            if ($request->is_default) {
                Currency::query()->update(['is_default' => false]);
            }

            $data = $request->all();
            if($request->is_default == 'on'){
                $data['is_default'] = true;
            }else{
                $data['is_default'] = false;
            }
            

            $currency->update($data);
            DB::commit();

            return redirect()->route('admin.currencies.index')->with('success', 'Currency updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.currencies.edit')->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Currency $currency)
    {
        DB::beginTransaction();
        try {
            $currency->delete();
            DB::commit();

            return redirect()->route('admin.currencies.index')->with('success', 'Currency deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.currencies.index')->with(['error' => $e->getMessage()]);
        }
    }
}
