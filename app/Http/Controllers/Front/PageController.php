<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\{FrontcmsPage, Holiday};
use App\Services\Customlib;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(private Customlib $customlib) {}

    public function home()
    {
        $pages = FrontcmsPage::where('is_active', 1)->latest()->limit(3)->get();
        $slides = FrontcmsPage::where('is_active', 1)->whereNotNull('image')->latest()->limit(5)->get();
        $events = Holiday::where('from_date', '>=', today())->limit(5)->get();
        $welcomeText = $this->customlib->getSchoolSettings()->school_name;
        return view('front.home', compact('pages', 'slides', 'events', 'welcomeText'));
    }

    public function read(string $slug)
    {
        $page = FrontcmsPage::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        return view('front.page', compact('page'));
    }

    public function index()
    {
        $records = FrontcmsPage::where('is_active', 1)->latest()->paginate(12);
        return view('front.page', compact('records'));
    }

    public function show(FrontcmsPage $record)
    {
        return view('front.page.show', compact('record'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $record = FrontcmsPage::create($data);
        return redirect()->back()->with('success', __('Saved.'));
    }
}
