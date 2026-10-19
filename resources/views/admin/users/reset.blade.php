@extends('layouts.app')
@section('title','Reset Kata Sandi')
@section('breadcrumb','Kelola Akun')
@section('content')
<div class="mb-3 d-flex gap-2 flex-wrap">
  <a href="{{ route('users.index') }}" class="btn btn-sm" style="background:#fff;border:1.5px solid var(--gold);color:var(--green);border-radius:20px;font-weight:700">← Kembali</a>
  <span class="badge align-self-center" style="background:var(--cream2);border:1px solid var(--gold);color:var(--green)">Reset kata sandi • {{ strtoupper($user->role) }}</span>
</div>

<div class="card-form" style="max-width:560px;margin:0 auto">
  <div class="card-form-header"><i class="bi bi-key-fill" style="color:var(--gold)"></i> Reset Kata Sandi</div>
  <form method="POST" action="{{ route('users.reset.update', $user) }}" class="p-4">
    @csrf @method('PUT')
    <div class="p-3 mb-3 rounded-3" style="background:var(--cream2);border:1px solid var(--gold)">
      <div class="fw-bold" style="color:var(--green)">{{ $user->name }}</div>
      <div class="small" style="color:#8a7a3a">{{ $user->username }} • {{ $user->email }}</div>
    </div>
    <div class="row g-3">
      <div class="col-12">
        <label class="form-label">Kata Sandi Baru (min 6) <span style="color:#dc3545">*</span></label>
        <input type="password" name="password" class="form-control" autocomplete="new-password" required autofocus>
      </div>
      <div class="col-12">
        <label class="form-label">Konfirmasi Kata Sandi Baru <span style="color:#dc3545">*</span></label>
        <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required>
      </div>
    </div>
    <div class="d-flex gap-2 mt-4">
      <button class="btn-green flex-fill" style="justify-content:center" onclick="return confirm('Reset kata sandi {{ $user->username }}?')"><i class="bi bi-arrow-repeat"></i> Reset Kata Sandi</button>
      <a href="{{ route('users.index') }}" class="btn-yellow flex-fill" style="justify-content:center">Batal</a>
    </div>
  </form>
</div>
@endsection
