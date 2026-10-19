@extends('layouts.app')
@section('title','Kelola Akun GT & PJGT')
@section('breadcrumb','Kelola Akun')
@section('content')
<div class="p-3 p-md-4 rounded-4 mb-3 position-relative overflow-hidden" style="background:linear-gradient(135deg,#0a3d1f 0%,#0f5a2e 60%,#083d1e 100%);color:#fdf6e3;border:1px solid rgba(212,175,55,.4);box-shadow:0 12px 32px rgba(6,43,21,.3)">
  <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#d4af37,#f4e2a0,#d4af37)"></div>
  <div class="position-relative d-flex justify-content-between align-items-start flex-wrap gap-2">
    <div>
      <div class="arab small" style="color:#d4af37">Akun</div>
      <h4 class="fw-bold mb-1" style="color:#fff;font-size:clamp(18px,5vw,22px)"><i class="bi bi-person-gear" style="color:#d4af37"></i> Kelola Akun GT & PJGT</h4>
      <div class="small" style="opacity:.8">Buat, edit, reset kata sandi, dan hapus akun Guru Tugas & PJGT</div>
    </div>
    <a href="{{ route('users.create') }}" class="btn" style="background:#d4af37;color:#0a3d1f;border-radius:10px;font-weight:800;white-space:nowrap"><i class="bi bi-plus-circle-fill"></i> Buat Akun</a>
  </div>
</div>

<div class="row g-2 g-md-3 mb-3">
  <div class="col-6">
    <div class="card h-100 overflow-hidden" style="border:none;border-radius:16px;background:linear-gradient(135deg,#0e5a30,#14924a);color:#fff;box-shadow:0 8px 24px rgba(20,90,50,.25)">
      <div class="card-body p-3 d-flex align-items-center gap-2">
        <div style="width:52px;height:52px;border-radius:14px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.4);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0"><i class="bi bi-mortarboard-fill"></i></div>
        <div>
          <div class="small fw-bold" style="opacity:.8;letter-spacing:1px;font-size:11px">GURU TUGAS</div>
          <div class="fw-bold" style="font-size:28px;line-height:1">{{ $countGt }}</div>
        </div>
        <a href="{{ route('users.index', ['role' => 'gt']) }}" class="btn btn-sm ms-auto" style="background:#fff;color:#0e5a30;border-radius:20px;font-size:11px;font-weight:800">Filter →</a>
      </div>
    </div>
  </div>
  <div class="col-6">
    <div class="card h-100 overflow-hidden" style="border:1.5px solid var(--gold);border-radius:16px;background:linear-gradient(135deg,#fffdf0,#fdf0c7);box-shadow:0 8px 24px rgba(184,148,31,.15)">
      <div class="card-body p-3 d-flex align-items-center gap-2">
        <div style="width:52px;height:52px;border-radius:14px;background:var(--green);color:var(--gold);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0"><i class="bi bi-person-video3"></i></div>
        <div>
          <div class="small fw-bold" style="color:#8a7a3a;letter-spacing:1px;font-size:11px">PJGT</div>
          <div class="fw-bold" style="font-size:28px;line-height:1;color:var(--green)">{{ $countPjgt }}</div>
        </div>
        <a href="{{ route('users.index', ['role' => 'pjgt']) }}" class="btn btn-sm ms-auto" style="background:var(--green);color:var(--gold);border-radius:20px;font-size:11px;font-weight:800">Filter →</a>
      </div>
    </div>
  </div>
</div>

<div class="card-form mb-3">
  <form method="GET" action="{{ route('users.index') }}" class="p-3">
    <div class="row g-2">
      <div class="col-6 col-md-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select">
          <option value="">Semua</option>
          <option value="gt" @selected($role === 'gt')>Guru Tugas</option>
          <option value="pjgt" @selected($role === 'pjgt')>PJGT</option>
        </select>
      </div>
      <div class="col-12 col-md-6">
        <label class="form-label">Cari</label>
        <input name="search" value="{{ $search }}" class="form-control" placeholder="Nama / username / email...">
      </div>
      <div class="col-12 col-md-3 d-flex align-items-end gap-1">
        <button class="btn-green flex-fill" style="min-height:44px"><i class="bi bi-search"></i> Filter</button>
        <a href="{{ route('users.index') }}" class="btn btn-sm" style="background:#fff;border:1.5px solid var(--gold);color:var(--green);border-radius:10px;min-height:44px;display:flex;align-items:center">Reset</a>
      </div>
    </div>
  </form>
</div>

<div class="card-form">
  <div class="card-form-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span><i class="bi bi-table" style="color:var(--gold)"></i> Daftar Akun ({{ $users->total() }})</span>
    <span class="small" style="color:#8a7a3a">Hal {{ $users->currentPage() }} / {{ $users->lastPage() }}</span>
  </div>
  <div class="table-responsive d-none d-md-block">
    <table class="table table-hover mb-0 small align-middle">
      <thead style="background:var(--cream2);color:var(--green);position:sticky;top:0">
        <tr><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        @forelse($users as $u)
        <tr>
          <td style="color:var(--green);font-weight:700">{{ $u->name }}</td>
          <td><span class="badge" style="background:var(--cream2);border:1px solid var(--gold);color:var(--green)">{{ $u->username }}</span></td>
          <td style="font-size:12px;color:#5d4037">{{ $u->email }}</td>
          <td>
            @if($u->role === 'gt')
            <span class="badge" style="background:#198754;color:#fff"><i class="bi bi-mortarboard-fill"></i> GT</span>
            @else
            <span class="badge" style="background:var(--gold);color:var(--green)"><i class="bi bi-person-video3"></i> PJGT</span>
            @endif
          </td>
          <td>
            <div class="d-flex gap-1 flex-wrap">
              <a href="{{ route('users.edit', $u) }}" class="btn btn-sm" style="background:var(--cream);border:1px solid var(--gold);color:var(--green);border-radius:20px;font-size:11px">Edit</a>
              <a href="{{ route('users.reset', $u) }}" class="btn btn-sm" style="background:var(--green);color:var(--gold);border-radius:20px;font-size:11px;font-weight:700">Reset Sandi</a>
              <form method="POST" action="{{ route('users.destroy', $u) }}" onsubmit="return confirm('Hapus akun {{ $u->name }} beserta biodata & absensinya?')">@csrf @method('DELETE')<button class="btn btn-sm" style="background:#ffe9e9;border:1px solid #ffb3b3;color:#7a0a0a;border-radius:20px;font-size:11px">Hapus</button></form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center py-4" style="color:var(--brown)">Belum ada akun GT/PJGT.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="d-md-none p-2">
    @forelse($users as $u)
    <div class="p-3 mb-2 rounded-3" style="background:#fff;border:1.5px solid #e8d9a0;border-left:4px solid var(--gold)">
      <div class="d-flex gap-2 align-items-center">
        <div style="min-width:0;flex:1">
          <div class="fw-bold" style="color:var(--green);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $u->name }}</div>
          <div class="small" style="color:#8a7a3a">{{ $u->username }} • {{ $u->email }}</div>
        </div>
        @if($u->role === 'gt')
        <span class="badge" style="background:#198754;color:#fff;font-size:10px;flex-shrink:0">GT</span>
        @else
        <span class="badge" style="background:var(--gold);color:var(--green);font-size:10px;flex-shrink:0">PJGT</span>
        @endif
      </div>
      <div class="d-flex gap-1 mt-2">
        <a href="{{ route('users.edit', $u) }}" class="btn btn-sm flex-fill" style="background:#fff;border:1.5px solid var(--gold);color:var(--green);border-radius:10px">Edit</a>
        <a href="{{ route('users.reset', $u) }}" class="btn btn-sm flex-fill" style="background:var(--green);color:var(--gold);border-radius:10px">Reset Sandi</a>
      </div>
    </div>
    @empty
    <div class="text-center py-4 small" style="color:var(--brown)">Belum ada akun GT/PJGT.</div>
    @endforelse
  </div>
  <div class="p-3">{{ $users->links() }}</div>
</div>
@endsection
