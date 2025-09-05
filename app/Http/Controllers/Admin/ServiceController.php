<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::paginate(9);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        // Create validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required',
            'duration_minutes' => 'required'
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
                $data['image'] = $request->file('image')->store('services', 'public');
            }
            $data['active'] = (int) $request->active;
            Service::create($data);
            DB::commit();

            return redirect()->route('admin.services.index')->with('success', 'Service created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.services.create')->with(['error' => $e->getMessage()]);
        }
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required',
            'duration_minutes' => 'required',
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
            $data['active'] = (int) $request->active;
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('services', 'public');
            }

            $service->update($data);
            DB::commit();

            return redirect()->route('admin.services.index')->with('success', 'Service updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.services.edit')->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Service $service)
    {
        DB::beginTransaction();
        try {
            $service->delete();
            DB::commit();

            return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.services.index')->with(['error' => $e->getMessage()]);
        }
    }
}
