<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.contact');
    }

    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $sent = Mail::to($request->input('email'), $request->input('name'))
        ->send(new Contact([
            'fromName' => $admin->name,
            'fromEmail' => $admin->email,
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]));

        return back()->with('success', 'E-mail enviado com sucesso!'); // Preciso arrumar aqui
    }
}
