<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Contact;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function ContactPage()
    {
        $subCategories = SubCategory::with('category')->get();
        $categories = Category::all();
        $contact = Contact::first();
        // dd($contact);
        return view('frontend.pages.contact-page', compact('subCategories', 'contact', 'categories'));
    }


    public function contactMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        $notification = ['message' => 'Request Successfully!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }
}
