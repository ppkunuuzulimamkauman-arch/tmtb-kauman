@extends('layouts.app')
@section('title','Edit Akun')
@section('breadcrumb','Kelola Akun')
@section('content')
<div class="mb-3 d-flex gap-2 flex-wrap">
  <a href="{{ route('users.index') }}" class="btn btn-sm" style="background:#fff;border:1.5px solid var(--gold);color:var(--green);border-radius:20px;font-weight:700">← Kembali</a>
  <span class="badge align-self-center" style="background:var(--cream2);border:1px solid var(--gold);color:var(--green)">Edit akun • {{ strtoupper($user->role) }}</span>
</div>

<div class="card-form" style="max-width:720px;margin:0 auto">
  <div class="card-form-header"><i class="bi bi-pencil-square" style="color:var(--gold)"></i> Edit Akun — {{ $user->name }}</div>
  <form method="POST" action="{{ route('users.update', $user) }}" class="p-4">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-12 col-md-6">
        <label class="form-label">Nama Lengkap <span style="color:#dc3545">*</span></label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
      </div>
      <div class="col-12 col-md-6">
        <label class="form-label">Role <span style="color:#dc3545">*</span></label>
        <select name="role" class="form-select" required>
          <option value="gt" @selected(old('role', $user->role) === 'gt')>Guru Tugas (GT)</option>
          <option value="pjgt" @selected(old('role', $user->role) === 'pjgt')>PJGT</option>
        </select>
      </div>
      <div class="col-12 col-md-6">
        <label class="form-label">Username <span style="color:#dc3545">*</span></label>
        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" required>
        <div class="small text-muted mt-1">Mengubah username akan menyinkronkan data permohonan terkait.</div>
      </div>
      <div class="col-12 col-md-6">
        <label class="form-label">Email <span style="color:#dc3545">*</span></label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
      </div>
      <div class="col-12"><hr style="border-color:var(--gold)"><h6 class="fw-bold" style="color:var(--green)"><i class="bi bi-key-fill" style="color:var(--gold)"></i> Ganti Kata Sandi (opsional)</h6><div class="small text-muted mb-2">Kosongkan jika tidak ingin mengganti kata sandi {{ $user->username }}.</div></div>
      <div class="col-12 col-md-6">
        <label class="form-label">Kata Sandi Baru (min 6)</label>
        <input type="password" name="password" class="form-control" placeholder="Kosongkan = tidak ganti" autocomplete="new-password">
      </div>
      <div class="col-12 col-md-6">
        <label class="form-label">Konfirmasi Kata Sandi Baru</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru" autocomplete="new-password">
      </div>
    </div>
    <div class="d-flex gap-2 mt-4">
      <button class="btn-green flex-fill" style="justify-content:center"><i class="bi bi-check-circle"></i> Simpan Perubahan</button>
      <a href="{{ route('users.index') }}" class="btn-yellow flex-fill" style="justify-content:center">Batal</a>
    </div>
  </form>
</div>
@endsection
