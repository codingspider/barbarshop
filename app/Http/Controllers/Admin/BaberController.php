<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BaberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('user_type', 'barber')->get();
        return view('admin.barber.index', compact('users'));
    }

    public function create()
    {
        return view('admin.barber.create');
    }

    public function store(Request $request)
    {
        // Create validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required',
            'password' => 'required'
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('barbers', 'public');
            }
            $data['user_type'] = 'barber';
            User::create($data);
            DB::commit();

            return redirect()->route('admin.barbers.index')->with('success', 'Barber created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.barbers.create')->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.barber.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required',
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $user = User::find($id);
            $data = $request->except('password', '_token', '_method', 'image');
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('barbers', 'public');
            }
            if($request->password){
                $data['password'] = Hash::make($request->password);
            }
            $user->update($data);
            DB::commit();

            return redirect()->route('admin.barbers.index')->with('success', 'Barber updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.barbers.edit')->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->delete();
            DB::commit();

            return redirect()->route('admin.barbers.index')->with('success', 'Barber deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.barbers.index')->with(['error' => $e->getMessage()]);
        }
    }
}
