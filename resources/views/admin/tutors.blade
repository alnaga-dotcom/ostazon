@extends('layouts.main')

@section('title', 'Tutor Verifications - Admin - OstazON')

@section('content')
<style>
    .admin-container { max-width: 1400px; margin: 0 auto; padding: 40px 24px; }
    .admin-header { margin-bottom: 32px; }
    .admin-header h1 { font-size: 32px; font-weight: 800; }
    .tabs { display: flex; gap: 8px; margin-bottom: 24px; background: white; padding: 6px; border-radius: 12px; box-shadow: var(--shadow); width: fit-content; }
    .tab { padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; border: none; background: transparent; color: var(--text-light); transition: all 0.3s; }
    .tab.active { background: var(--primary); color: white; }
    .tutor-card { background: white; border-radius: 20px; padding: 28px; box-shadow: var(--shadow); margin-bottom: 20px; }
    .tutor-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px; }
    .tutor-info { display: flex; align-items: center; gap: 16px; }
    .tutor-avatar { width: 64px; height: 64px; border-radius: 50%; background: var(--primary-light); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--primary); font-size: 24px; }
    .tutor-details h3 { font-size: 18px; font-weight: 700; }
    .tutor-details p { font-size: 14px; color: var(--text-light); }
    .documents-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px; }
    .document-box { background: var(--bg); border-radius: 12px; padding: 16px; text-align: center; }
    .document-box h4 { font-size: 14px; font-weight: 600; margin-bottom: 8px; }
    .document-box .status { font-size: 12px; padding: 4px 10px; border-radius: 50px; font-weight: 600; display: inline-block; }
    .status-present { background: #d4edda; color: #155724; }
    .status-missing { background: #f8d7da; color: #721c24; }
    .document-box a { font-size: 13px; color: var(--primary); text-decoration: none; font-weight: 600; }
    .verification-actions { display: flex; gap: 12px; padding-top: 16px; border-top: 1px solid var(--bg); }
    .verification-actions .btn { padding: 10px 24px; font-size: 14px; }
    .level-select { padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; font-family: inherit; outline: none; }
    .level-select:focus { border-color: var(--primary); }
    .verified-tutor-card { background: white; border-radius: 16px; padding: 20px 24px; box-shadow: var(--shadow); margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; }
    .verified-tutor-info h4 { font-size: 15px; font-weight: 600; }
    .verified-tutor-info p { font-size: 13px; color: var(--text-light); }
    .badge-verified { background: var(--primary-light); color: var(--primary); padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; }
    .badge-certified { background: var(--secondary-light); color: var(--secondary); padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; }
    .badge-top { background: linear-gradient(135deg, var(--secondary), #e6951a); color: white; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; }
    .empty-state { text-align: center; padding: 60px; color: var(--text-light); }
</style>

<div class="admin-container">
    <div class="admin-header">
        <h1>🎓 Tutor Verifications</h1>
    </div>

    <div class="tabs">
        <button class="tab active" onclick="showTab('pending')">Pending ({{ $pendingTutors->count() }})</button>
        <button class="tab" onclick="showTab('verified')">All Tutors</button>
    </div>

    <div id="pending-tab">
        @forelse($pendingTutors as $tutor)
            <div class="tutor-card">
                <div class="tutor-header">
                    <div class="tutor-info">
                        <div class="tutor-avatar">{{ strtoupper(substr($tutor->user->name, 0, 1)) }}</div>
                        <div class="tutor-details">
                            <h3>{{ $tutor->user->name }}</h3>
                            <p>{{ $tutor->user->email }} • {{ $tutor->user->phone }} • {{ $tutor->country }}</p>
                            <p>Registered {{ $tutor->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="documents-grid">
                    <div class="document-box">
                        <h4>💬 Bio</h4>
                        <span class="status {{ $tutor->bio ? 'status-present' : 'status-missing' }}">
                            {{ $tutor->bio ? 'Present' : 'Missing' }}
                        </span>
                    </div>
                    <div class="document-box">
                        <h4>🎥 Video Intro</h4>
                        @if($tutor->video_intro_url)
                            <a href="{{ Storage::disk('public')->url($tutor->video_intro_url) }}" target="_blank">View Video</a>
                        @else
                            <span class="status status-missing">Missing</span>
                        @endif
                    </div>
                    <div class="document-box">
                        <h4>📂 ID Document</h4>
                        @if($tutor->id_document_url)
                            <a href="{{ Storage::disk('public')->url($tutor->id_document_url) }}" target="_blank">View ID</a>
                        @else
                            <span class="status status-missing">Missing</span>
                        @endif
                    </div>
                    <div class="document-box">
                        <h4>🎓 Certificate</h4>
                        @if($tutor->certificate_url)
                            <a href="{{ Storage::disk('public')->url($tutor->certificate_url) }}" target="_blank">View Cert</a>
                        @else
                            <span class="status status-missing">Optional</span>
                        @endif
                    </div>
                    <div class="document-box">
                        <h4>📚 Subjects</h4>
                        <span class="status {{ $tutor->subjects->count() > 0 ? 'status-present' : 'status-missing' }}">
                            {{ $tutor->subjects->count() }} Selected
                        </span>
                    </div>
                    <div class="document-box">
                        <h4>👤 Rate</h4>
                        <span class="status status-present">{{ $tutor->hourly_rate }} EGP/hr</span>
                    </div>
                </div>

                <div class="verification-actions">
                    <form method="POST" action="{{ route('admin.tutors.verify', $tutor->id) }}" style="display: flex; gap: 12px; align-items: center;">
                        @csrf
                        <select class="level-select" name="level">
                            <option value="verified">Verified</option>
                            <option value="certified">Certified</option>
                        </select>
                        <button type="submit" class="btn btn-primary">✅ Approve</button>
                    </form>
                    <form method="POST" action="{{ route('admin.tutors.reject', $tutor->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline" style="border-color: var(--accent); color: var(--accent);">❌ Reject</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div style="font-size: 48px; margin-bottom: 16px;">✅</div>
                <h3>No pending verifications</h3>
                <p>All tutors have been reviewed!</p>
            </div>
        @endforelse

        <div style="margin-top: 20px;">
            {{ $pendingTutors->links() }}
        </div>
    </div>

    <div id="verified-tab" style="display: none;">
        @forelse($allTutors as $tutor)
            <div class="verified-tutor-card">
                <div class="verified-tutor-info">
                    <h4>{{ $tutor->user->name }}</h4>
                    <p>{{ $tutor->user->email }} • {{ $tutor->subjects->count() }} subjects • {{ $tutor->total_lessons }} lessons</p>
                </div>
                <span class="badge-{{ $tutor->verification_status }}">
                    {{ ucfirst($tutor->verification_status) }}
                </span>
            </div>
        @empty
            <div class="empty-state">
                <p>No verified tutors yet.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    function showTab(tab) {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        event.target.classList.add('active');
        document.getElementById('pending-tab').style.display = tab === 'pending' ? 'block' : 'none';
        document.getElementById('verified-tab').style.display = tab === 'verified' ? 'block' : 'none';
    }
</script>
@endsection