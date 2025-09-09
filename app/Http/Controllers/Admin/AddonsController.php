<?php

namespace App\Http\Controllers\Admin;

use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AddonsController extends Controller
{
    public function index()
    {
        $services = Addon::paginate(9);
        return view('admin.addon.index', compact('services'));
    }

    public function create()
    {
        return view('admin.addon.create');
    }

    public function store(Request $request)
    {
        // Create validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required',
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {

            $data = $request->except('image', '_token', '_method');
            if ($request->hasFile('image')) {
                $data['image'] = uploadPublicImage($request->file('image'), 'addons');
            }
            $data['active'] = (int) $request->active;
            Addon::create($data);
            DB::commit();

            return redirect()->route('admin.addons.index')->with('success', 'Addons created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.addons.create')->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $service = Addon::find($id);
        return view('admin.addon.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required'
        ]);
        // Handle validation failure
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $service = Addon::find($id);
            $data = $request->except('image', '_token', '_method');
            $data['active'] = (int) $request->active;
            if ($request->hasFile('image')) {
                $data['image'] = uploadPublicImage($request->file('image'), 'addons');
            }

            $service->update($data);
            DB::commit();

            return redirect()->route('admin.addons.index')->with('success', 'Addons updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.addons.edit')->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Addon $addon)
    {
        DB::beginTransaction();
        try {
            $addon->delete();
            DB::commit();

            return redirect()->route('admin.addons.index')->with('success', 'Addons deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.addons.index')->with(['error' => $e->getMessage()]);
        }
    }
}
