<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use App\Mail\RegistrationRegisteredMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::latest();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('registration_no', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");

            });

        }

        if ($request->filled('status') || $request->status === '0') {
            $query->where('status', $request->status);
        }

        $registrations = $query->paginate(10)->withQueryString();

        return view('registrations.index', compact('registrations'));
    }

    public function getCreate()
    {
        return view('registrations.create');
    }

    public function postCreate(Request $request)
    {
        $validated = $request->validate([
            'email'                     => 'required|email|unique:registrations,email',
            'title'                     => 'required',
            'first_name'                => 'required|string|max:100',
            'last_name'                 => 'nullable|string|max:100',
            'gender'                    => 'nullable|string|max:100',
            'job_title'                 => 'required',
            'job_function'              => 'required',
            'phone'                     => 'required|max:10|unique:registrations,phone',
            'company_name'              => 'required',
            'address'                   => 'required',
            'country'                   => 'required',
            'pincode'                   => 'required',
            'state'                     => 'required',
            'city'                      => 'required',
            'website'                   => 'nullable',
            'industry_segment'          => 'required',
            'business_nature'           => 'required',
            'primary_product_group'     => 'required',
            'additional_product_group'  => 'nullable',
            'terms'                     => 'accepted',
        ]);

        $validated['registration_no'] = 'REG'.date('Y').str_pad((Registration::count()+1),5,'0',STR_PAD_LEFT);

        $validated['full_name'] = trim(
            $validated['first_name'].' '.($validated['last_name'] ?? '')
        );

        $validated['terms'] = $request->boolean('terms');
        $validated['status'] = true;

        $registration = Registration::create($validated);

        $qrData = implode(PHP_EOL, [
            "Registration No : {$registration->registration_no}",
            "Visitor Name : {$registration->full_name}",
            "Company : {$registration->company_name}",
            "Email : {$registration->email}",
            "Phone : {$registration->phone}",
            "Country : {$registration->country}",

        ]);

        // echo "<pre>";
        // echo $qrData;
        // die;

        $result = new Builder(
            writer: new PngWriter(),
            data: $qrData,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: 500,
            margin: 20,
        );

        $qrImage = $result->build()->getString();

        $fileName = $registration->registration_no . '.png';

        file_put_contents(
            public_path('storage/registration-qrcode/' . $fileName),
            $qrImage
        );

        try {

            Mail::to($registration->email)
                ->send(new RegistrationRegisteredMail($registration));

        } catch (\Exception $e) {

            Log::error($e->getMessage());

        }

        return redirect()
            ->route('registrations.index')
            ->with('success','Registration created successfully. Email sent.');
    }

    public function getUpdate($id)
    {
        $registration = Registration::findOrFail($id);

        return view('registrations.update',compact('registration'));
    }

    public function postUpdate(Request $request,$id)
    {
        $registration = Registration::findOrFail($id);

        $validated = $request->validate([
            'email'                     => 'required|email|unique:registrations,email,'.$id,
            'title'                     => 'required',
            'first_name'                => 'required',
            'last_name'                 => 'nullable',
            'gender'                    => 'nullable',
            'job_title'                 => 'required',
            'job_function'              => 'required',
            'phone'                     => 'required|max:10|unique:registrations,phone,'.$id,
            'company_name'              => 'required',
            'address'                   => 'required',
            'country'                   => 'required',
            'pincode'                   => 'required',
            'state'                     => 'required',
            'city'                      => 'required',
            'website'                   => 'nullable',
            'industry_segment'          => 'required',
            'business_nature'           => 'required',
            'primary_product_group'     => 'required',
            'additional_product_group'  => 'nullable',
            'terms'                     => 'accepted',
        ]);

        $validated['full_name'] = trim(
            $validated['first_name'].' '.($validated['last_name'] ?? '')
        );

        $validated['terms'] = $request->boolean('terms');
        $validated['status'] = $request->boolean('status');

        $registration->update($validated);

        return redirect()->route('registrations.index')
            ->with('success','Registration updated successfully.');
    }

    public function getFindBadge()
    {
        return view('registrations.find');
    }

    public function postFindBadge(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $search = $request->search;

        $registration = Registration::where('registration_no', $search)
            ->orWhere('email', $search)
            ->first();

        if (!$registration) {
            return back()
                ->withInput()
                ->with('error', 'Registration Number Or Email Not Found. Please try again.');
        }

        return redirect()->route('registration.view', $registration->id);
    }

    public function view($id)
    {
        $registration = Registration::findOrFail($id);

        return view('registrations.view',compact('registration'));
    }

    public function delete($id)
    {
        $registration = Registration::findOrFail($id);

        $registration->delete();

        return redirect()->route('registrations.index')
            ->with('success','Registration deleted successfully.');
    }
}