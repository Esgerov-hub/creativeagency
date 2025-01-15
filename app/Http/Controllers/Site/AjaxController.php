<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CareerContact;
use App\Models\Contact;
use App\Models\ServiceContact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AjaxController extends Controller
{
    protected $currentLang;

    public function __construct()
    {
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }
    public function sendContact(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^\+994[0-9]{9}$/',
            'email' => 'required|email',
            'note' => 'required',
        ], [
            'name.required' => Lang::get('site.name_required'),
            'surname.required' => Lang::get('site.surname_required'),
            'phone.required' => Lang::get('site.number_required'),
            'phone.regex' => Lang::get('site.number_regex'),
            'email.required' => Lang::get('site.email_required'),
            'note.required' => Lang::get('site.note_required'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        Contact::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'note' => $request->note,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Müraciət uğurla göndərildi!',
        ]);
    }
}
