<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FrontcmsPage;
use App\Models\FrontcmsMenu;
use App\Models\Holiday;
use App\Services\Customlib;

/**
 * Welcome controller — handles the public-facing front-CMS.
 *
 * Replaces CI3 controllers/Welcome.php + controllers/Site.php::readPage().
 */
class WelcomeController extends Controller
{
    public function __construct(private Customlib $customlib) {}

    public function index()
    {
        $pages = FrontcmsPage::where('is_active', 1)->latest()->limit(3)->get();
        $slides = FrontcmsPage::where('is_active', 1)->whereNotNull('image')->latest()->limit(5)->get();
        $events = Holiday::where('from_date', '>=', today())->limit(5)->get();

        return view('front.home', compact('pages', 'slides', 'events'));
    }

    public function readPage(string $slug)
    {
        $page = FrontcmsPage::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        return view('front.page', compact('page'));
    }

    public function annualCalendar()
    {
        $holidays = Holiday::where('is_active', 1)->orderBy('from_date')->get();
        return view('front.calendar', compact('holidays'));
    }

    public function admissionForm()
    {
        return view('front.admission');
    }

    public function submitAdmission(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:100',
            'middlename' => 'nullable|string|max:100',
            'lastname' => 'required|string|max:100',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'class_id' => 'required|integer',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'father_name' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:100',
            'address' => 'nullable|string',
        ]);

        // Save as a pending admission record (status: pending)
        \App\Models\Content::create(array_merge($validated, [
            'title'       => $validated['firstname'] . ' ' . ($validated['middlename'] ?? '') . ' ' . $validated['lastname'],
            'description' => json_encode($validated),
            'content_type_id' => 1, // Admission enquiry
            'page_type' => 'admission',
            'is_active' => 0,
        ]));

        return redirect()->route('home')->with('success', __('Admission application submitted. We will contact you soon.'));
    }

    public function onlineAdmissionList()
    {
        $admissions = \App\Models\Content::where('page_type', 'admission')->latest()->paginate(10);
        return view('front.admission-list', compact('admissions'));
    }

    public function examResult()
    {
        return view('front.exam-result');
    }
}
