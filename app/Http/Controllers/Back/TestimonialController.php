<?php

namespace App\Http\Controllers\Back;

use App\Models\Testimonial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Constructor Method.
     * Setting Authentication
     */
    public function __construct()
    {
        $this->middleware("auth:admin");
        $this->middleware("adminlocalize");
        $this->middleware("permissions:Add Testimonials")->only([
            "create",
            "store",
        ]);
        $this->middleware("permissions:Update Testimonials")->only([
            "edit",
            "update",
        ]);
        $this->middleware("permissions:Delete Testimonials")->only(["destroy"]);
    }

    /**
     * Display a listing of testimonials.
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy("id", "desc")->get();
        return view("back.testimonial.index", compact("testimonials"));
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function create()
    {
        return view("back.testimonial.create");
    }

    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "client_name" => "required|max:255",
            "client_title" => "required|max:255",
            "testimonial_text" => "required",
            "rating" => "required|integer|min:1|max:5",
            "status" => "required|in:0,1",
        ]);

        Testimonial::create([
            "client_name" => $request->client_name,
            "client_title" => $request->client_title,
            "testimonial_text" => $request->testimonial_text,
            "rating" => $request->rating,
            "status" => $request->status,
        ]);

        return redirect()
            ->route("back.testimonial.index")
            ->withSuccess(__("Testimonial Added Successfully."));
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function edit(Testimonial $testimonial)
    {
        return view("back.testimonial.edit", compact("testimonial"));
    }

    /**
     * Update the specified testimonial in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            "client_name" => "required|max:255",
            "client_title" => "required|max:255",
            "testimonial_text" => "required",
            "rating" => "required|integer|min:1|max:5",
            "status" => "required|in:0,1",
        ]);

        $testimonial->update([
            "client_name" => $request->client_name,
            "client_title" => $request->client_title,
            "testimonial_text" => $request->testimonial_text,
            "rating" => $request->rating,
            "status" => $request->status,
        ]);

        return redirect()
            ->route("back.testimonial.index")
            ->withSuccess(__("Testimonial Updated Successfully."));
    }

    /**
     * Remove the specified testimonial from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()
            ->route("back.testimonial.index")
            ->withSuccess(__("Testimonial Deleted Successfully."));
    }
}
