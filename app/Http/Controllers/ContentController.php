<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentPurchase;
use App\Models\Subject;
use App\Services\CoinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $query = Content::published()->with(['tutor', 'subject']);

        if ($request->subject) {
            $query->where('subject_id', $request->subject);
        }

        if ($request->type) {
            $query->where('content_type', $request->type);
        }

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $sort = $request->sort ?? 'newest';
        match ($sort) {
            'popular' => $query->orderBy('download_count', 'desc'),
            'cheapest' => $query->orderBy('price_coins', 'asc'),
            'priciest' => $query->orderBy('price_coins', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $contents = $query->paginate(12);
        $subjects = Subject::orderBy('name')->get();

        return view('marketplace.index', compact('contents', 'subjects'));
    }

    public function show(Content $content)
    {
        if (!$content->is_published) {
            abort(404);
        }

        $content->load(['tutor', 'subject']);
        $hasPurchased = false;

        if (Auth::check()) {
            $hasPurchased = ContentPurchase::where('content_id', $content->id)
                ->where('student_id', Auth::id())
                ->exists();
        }

        $similar = Content::published()
            ->where('id', '!=', $content->id)
            ->where(function ($q) use ($content) {
                $q->where('subject_id', $content->subject_id)
                  ->orWhere('tutor_id', $content->tutor_id);
            })
            ->with(['tutor', 'subject'])
            ->take(4)
            ->get();

        return view('marketplace.show', compact('content', 'hasPurchased', 'similar'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->get();
        return view('marketplace.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'subject_id' => 'nullable|exists:subjects,id',
            'content_type' => 'required|in:pdf,video,article,quiz,other',
            'price_coins' => 'required|integer|min:0|max:10000',
            'file_url' => 'nullable|string|max:500',
            'thumbnail_url' => 'nullable|string|max:500',
        ]);

        Content::create([
            'tutor_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'content_type' => $request->content_type,
            'price_coins' => $request->price_coins,
            'file_url' => $request->file_url,
            'thumbnail_url' => $request->thumbnail_url,
        ]);

        return redirect()->route('marketplace.my')->with('success', 'Content uploaded successfully!');
    }

    public function my()
    {
        if (Auth::user()->isTutor()) {
            $contents = Content::where('tutor_id', Auth::id())
                ->with(['subject'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } else {
            $purchasedIds = ContentPurchase::where('student_id', Auth::id())
                ->pluck('content_id');
            $contents = Content::whereIn('id', $purchasedIds)
                ->with(['tutor', 'subject'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        return view('marketplace.my', compact('contents'));
    }

    public function purchase(Request $request, Content $content)
    {
        if (!Auth::user()->isStudent()) {
            return back()->with('error', 'Only students can purchase content.');
        }

        $already = ContentPurchase::where('content_id', $content->id)
            ->where('student_id', Auth::id())
            ->exists();

        if ($already) {
            return back()->with('error', 'You already own this content.');
        }

        if (!CoinService::hasSufficient(Auth::id(), $content->price_coins)) {
            return back()->with('error', 'Insufficient coins. You need ' . $content->price_coins . ' coins.');
        }

        CoinService::debit(Auth::id(), $content->price_coins, 'content_purchase', 'Purchased: ' . $content->title, 'content', $content->id);

        ContentPurchase::create([
            'content_id' => $content->id,
            'student_id' => Auth::id(),
            'coins_spent' => $content->price_coins,
        ]);

        $content->increment('download_count');

        return redirect()->route('marketplace.show', $content->id)->with('success', 'Content purchased! You can now download it.');
    }
}
