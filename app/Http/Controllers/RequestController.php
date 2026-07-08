<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TutoringRequest;
use App\Models\TutorProposal;
use App\Services\CoinService;

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
        $input = $request->all();
        foreach (['title', 'budget_egp', 'lesson_mode', 'preferred_schedule'] as $f) {
            if (isset($input[$f]) && $input[$f] === '') { $input[$f] = null; }
        }
        $request->replace($input);

        $data = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'nullable|string|max:255',
            'description' => 'required|string|max:2000',
            'budget_egp' => 'nullable|numeric|min:0',
            'lesson_mode' => 'nullable|in:online,in_person',
            'preferred_schedule' => 'nullable|string|max:500',
        ]);

        $studentId = auth()->id();

        if (!CoinService::hasSufficient($studentId, 10)) {
            return back()->withInput()->with('error', __('messages.insufficient_coins_request'));
        }

        $data['student_id'] = $studentId;
        $data['status'] = 'open';
        $data['title'] = $data['title'] ?? mb_substr($data['description'], 0, 100);
        if (empty($data['lesson_mode'])) { unset($data['lesson_mode']); }

        $tutoringRequest = TutoringRequest::create($data);

        CoinService::debit($studentId, 10, 'request_post', 'Post tutoring request #' . $tutoringRequest->id, 'tutoring_request', $tutoringRequest->id);

        return redirect()->route('student.requests')
            ->with('success', __('messages.request_posted'));
    }

    public function acceptProposal($proposal)
    {
        $proposal = TutorProposal::findOrFail($proposal);
        $tutoringRequest = $proposal->request;

        if ($tutoringRequest->student_id !== auth()->id()) {
            abort(403);
        }

        if ($proposal->status !== 'pending') {
            return back()->with('error', __('messages.proposal_not_pending'));
        }

        $proposal->update(['status' => 'accepted']);
        $tutoringRequest->update(['status' => 'fulfilled']);

        TutorProposal::where('request_id', $tutoringRequest->id)
            ->where('id', '!=', $proposal->id)
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);

        return back()->with('success', __('messages.proposal_accepted'));
    }

    public function tutorProposals()
    {
        return view('tutor.proposals');
    }

    public function storeProposal(Request $request)
    {
        $data = $request->validate([
            'request_id' => 'required|exists:tutoring_requests,id',
            'message' => 'required|string|max:1000',
            'proposed_rate' => 'nullable|numeric|min:0',
        ]);

        $tutoringRequest = TutoringRequest::findOrFail($data['request_id']);

        if ($tutoringRequest->status !== 'open') {
            return back()->with('error', __('messages.request_not_open'));
        }

        if ($tutoringRequest->student_id === auth()->id()) {
            return back()->with('error', __('messages.cannot_propose_own'));
        }

        $existing = TutorProposal::where('request_id', $data['request_id'])
            ->where('tutor_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('error', __('messages.already_proposed'));
        }

        TutorProposal::create([
            'request_id' => $data['request_id'],
            'tutor_id' => auth()->id(),
            'proposed_rate' => $data['proposed_rate'] ?? null,
            'message' => $data['message'],
            'status' => 'pending',
        ]);

        return back()->with('success', __('messages.proposal_submitted'));
    }
}
