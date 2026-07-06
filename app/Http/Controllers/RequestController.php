<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function myRequests()
    {
        return view('student.requests');
    }

    public function create()
    {
        return view('student.requests_create');
    }

    public function store(Request $request)
    {
        return redirect()->route('student.requests')->with('success', 'Request created');
    }

    public function acceptProposal($proposal)
    {
        return back()->with('success', 'Proposal accepted');
    }

    public function tutorProposals()
    {
        return view('tutor.proposals');
    }

    public function storeProposal(Request $request)
    {
        return back()->with('success', 'Proposal submitted');
    }
}