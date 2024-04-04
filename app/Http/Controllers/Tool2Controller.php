<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;

class Tool2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tools = Tool::all();
        return view('tools.index', ['tools' => $tools]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $max_id= Tool::max('id');
        $counter = $max_id +1;

        $tools = Tool::all();


        return view('tools.create', ['counter' =>$counter, 'tools' => $tools]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'tutorial' => 'required'
        ]);

        $tool = new Tool();
        $tool->name = $request->name;
        $tool->status = $request->status;
        $tool->tutorial = $request->tutorial;
        $tool->save();
        return redirect()->route('tools.index')
            ->with('success', 'Tool created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $tool = Tool::find($id);
        return view('tools.show', ['tool' => $tool]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $tool = Tool::find($id);
        return view('tools.edit', ['tool' => $tool]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'tutorial' => 'required'
        ]);


        $tool = Tool::find($id);
        $tool->name = $request->name;
        $tool->status = $request->status;
        $tool->tutorial = $request->tutorial;
        $tool->save();
        return redirect()->route('tools.index')
            ->with('success', 'Tool updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Tool::destroy($id);
        return redirect()->route('tools.index')
            ->with('success', 'Tool deleted successfully.');
    }
}
