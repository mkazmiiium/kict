@extends('layouts.app')

@section('title', 'Final Signed Proposal')

@section('content')
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-6">
    <h4 class="mb-0">DDSDCE Office / Student Proposal / Final Signed Document</h4>
    <a href="{{ route('ddsdce.student-proposal.index') }}" class="btn btn-outline-secondary">
      <i class="icon-base bx bx-arrow-back me-1"></i> Back to Inbox
    </a>
  </div>

  @if (session('status'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">{{ $proposal->name }}</h5>
      <p class="mb-0 text-body-secondary small">
        {{ $proposal->venue ?: '—' }} &middot; {{ $proposal->programme_date?->format('d M Y') ?? '—' }}
      </p>
    </div>
    <div class="card-body">
      @if ($proposal->final_document_path)
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 p-4 mb-6 border rounded">
          <div class="d-flex align-items-center gap-3">
            <i class="icon-base bx bxs-file-pdf text-danger" style="font-size: 2rem;"></i>
            <div>
              <div class="fw-medium">{{ $proposal->final_document_original_filename }}</div>
              <div class="text-body-secondary small">
                Uploaded by {{ $proposal->finalDocumentUploader->name ?? 'Unknown' }}
                on {{ $proposal->final_document_uploaded_at->format('d M Y, h:i A') }}
              </div>
            </div>
          </div>
          <a href="{{ route('ddsdce.student-proposal.final.view', $proposal) }}" target="_blank" rel="noopener" class="btn btn-outline-secondary">
            <i class="icon-base bx bx-show me-1"></i> View
          </a>
        </div>
        <p class="text-body-secondary">A final signed proposal is already on file. Uploading a new file below will replace it.</p>
      @else
        <p class="text-body-secondary">
          No final signed proposal uploaded yet. Once the physical/scanned copy with signatures and attachments is ready, upload it here as the authoritative record.
        </p>
      @endif

      <form action="{{ route('ddsdce.student-proposal.final.update', $proposal) }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-4">
          <label for="final_document" class="form-label">{{ $proposal->final_document_path ? 'Replace File (PDF only, max 20MB)' : 'Upload File (PDF only, max 20MB)' }}</label>
          <input type="file" id="final_document" name="final_document" accept="application/pdf" class="form-control @error('final_document') is-invalid @enderror" />
          @error('final_document')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="icon-base bx bx-upload me-1"></i> {{ $proposal->final_document_path ? 'Replace File' : 'Upload File' }}
        </button>
      </form>
    </div>
  </div>
@endsection
