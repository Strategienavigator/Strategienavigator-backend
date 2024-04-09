<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ExampleMail;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Email2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('emails.emailForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'subject' => 'required',
            'body' => 'required'
        ]);

       $email_data = [
            'subj' => $request->subject,
            'body' => $request->body
        ];

        if ($request->group == 'admin'){
            $adminUsers = User::whereHas('role', function ($query) {
                $query->where('name', 'admin');
            })->get();

            foreach ($adminUsers as $adminUser){
                Mail::to($adminUser->email)->send(new ExampleMail($email_data));
            }

        }elseif ($request->group == 'normal'){
            $normalUsers = User::whereHas('role', function ($query) {
                $query->where('name', 'normal');
            })->get();

            foreach ($normalUsers as $normalUser){
                Mail::to($normalUser->email)->send(new ExampleMail($email_data));
            }

        }elseif($request->group == 'anonym'){
            $anonymUsers = User::whereHas('role', function ($query) {
                $query->where('name', 'anonym');
            })->get();

            foreach ($anonymUsers as $anonymUser){
                Mail::to($anonymUser->email)->send(new ExampleMail($email_data));
            }
        }
        return redirect()->back()->with('success', 'Email sent!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
