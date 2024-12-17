<?php

namespace App\Http\Controllers;

use App\Models\ResearchGrant;
use App\Models\Academician;
use Illuminate\Http\Request;

class ResearchGrantController extends Controller
{
    public function index()
    {
        $grants = ResearchGrant::with('projectLeader')->latest()->paginate(10);
        return view('grants.index', compact('grants'));
    }

    public function create()
    {
        $academicians = Academician::all();
        return view('grants.create', compact('academicians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'grant_amount' => 'required|numeric|min:0',
            'grant_provider' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'academician_id' => 'required|exists:academicians,id'
        ]);

        ResearchGrant::create($validated);
        return redirect()->route('grants.index')->with('success', 'Research grant created successfully.');
    }

    public function show(ResearchGrant $grant)
    {
        $grant->load(['projectLeader', 'teamMembers', 'milestones']);
        $availableAcademicians = Academician::whereNotIn('id', $grant->teamMembers->pluck('id'))
            ->where('id', '!=', $grant->academician_id)
            ->get();
        return view('grants.show', compact('grant', 'availableAcademicians'));
    }

    public function edit(ResearchGrant $grant)
    {
        $academicians = Academician::all();
        return view('grants.edit', compact('grant', 'academicians'));
    }

    public function update(Request $request, ResearchGrant $grant)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'grant_amount' => 'required|numeric|min:0',
            'grant_provider' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'academician_id' => 'required|exists:academicians,id'
        ]);

        $grant->update($validated);
        return redirect()->route('grants.index')->with('success', 'Research grant updated successfully.');
    }

    public function updateMembers(Request $request, ResearchGrant $grant)
    {
        $validated = $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:academicians,id'
        ]);

        $grant->teamMembers()->sync($validated['member_ids']);
        return redirect()->route('grants.show', $grant)
            ->with('success', 'Team members updated successfully.');
    }

    public function destroy(ResearchGrant $grant)
    {
        $grant->delete();
        return redirect()->route('grants.index')->with('success', 'Research grant deleted successfully.');
    }
}
