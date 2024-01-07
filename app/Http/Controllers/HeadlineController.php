<?php

namespace App\Http\Controllers;

use App\Articles\SearchRepository;
use App\Models\Headline;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HeadlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, SearchRepository $searchRepository)
    {
        $searchQuery = $request->has('q');
        $categories = Headline::getDistinctCategories();

        // http://127.0.0.1/headline?q=abcd&category=PARENTING&start_date=2024-01-04&end_date=2024-01-17
        $validatedData = $request->validate([
            'q' => 'nullable|string',
            'category' => ['sometimes', Rule::in($categories)],
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        // dd($validatedData);

        if($searchQuery) {
            $headlines = $searchRepository->search($validatedData);

        } else {
            $headlines = Headline::paginate(10);
        }

        return view('headline.index', compact('headlines', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Headline $headline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Headline $headline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Headline $headline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Headline $headline)
    {
        //
    }
}
