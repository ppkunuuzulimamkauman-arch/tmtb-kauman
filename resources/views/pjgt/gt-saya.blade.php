@extends('layouts.app')
@section('title','GT di Lembaga Saya | TMTB KIK')
@section('breadcrumb','GT di Lembaga Saya')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3" style="background:linear-gradient(135deg,#0a3d1f 0%, #0f5a2e 100%);color:#fdf6e3;border:2px solid #d4af37">
    <div>
        <div class="small" style="color:#d4af37">Pemberitahuan Penempatan</div>
        <h5 class="mb-0 fw-bold" style="color:#fff"><i class="bi bi-people-fill" style="color:#d4af37"></i> Guru Tugas di Lembaga Saya</h5>
        <div class="small" style="color:#fdf6e3;opacity:.8">GT yang ditugaskan admin ke lembaga Anda</div>
    </div>
    <span class="badge" style="background:#d4af37;color:#0a3d1f;font-size:14px;border-radius:20px;padding:6px 14px">{{ $items->total() }} GT</span>
</div>

@if($items->isEmpty())
<div class="card-form mt-0">
    <div class="p-3">
        <div class="alert small py-2 mb-0" style="background:#fdf6e3;border:1px solid #d4af37;color:#0a3d1f"><i class="bi bi-info-circle-fill" style="color:#d4af37"></i> Belum ada Guru Tugas yang ditempatkan di lembaga Anda. Jika admin menugaskan GT baru, biodatanya akan langsung tampil di sini.</div>
    </div>
</div>
@else
<div class="d-flex flex-column gap-2">
@foreach($items as $p)
@php
  $gt = $p->gt;
  $b = $gt->biodata ?? null;
  $foto = ($b->foto_path ?? null) ? asset('storage/' . $b->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($gt->name ?? 'GT') . '&background=d4af37&color=0a3d1f&size=200';
  $cid = 'bio-' . $p->id;
@endphp
<div class="rounded-3 overflow-hidden mb-3" style="border:2px solid var(--gold);background:#fff;box-shadow:0 4px 16px rgba(10,61,31,.08)">
    <div style="height:80px;background:linear-gradient(135deg,#0a3d1f,#1d7a3d);position:relative">
        <div style="position:absolute;bottom:-28px;left:16px">
            <img src="{{ $foto }}" alt="" style="width:64px;height:64px;border-radius:16px;object-fit:cover;border:3px solid var(--gold);box-shadow:0 4px 12px rgba(0,0,0,.15)">
        </div>
    </div>
    <div class="p-3 pt-4">
        <div class="d-flex align-items-start gap-3">
            <div class="flex-fill" style="min-width:0">
                <div class="fw-bold" style="color:#0a3d1f;font-size:16px">{{ $gt->name ?? '-' }}</div>
                <div class="small" style="color:#8a7a3a">{{ $p->permohonan->nama_madrasah ?? '-' }}</div>
                <div class="small mt-1"><span class="badge" style="background:var(--cream);color:var(--green);border:1px solid var(--gold)">{{ $p->updated_at?->locale('id')->isoFormat('D MMM YYYY') ?? '-' }}</span></div>
            </div>
            <button class="btn btn-sm flex-shrink-0" data-bs-toggle="collapse" data-bs-target="#{{ $cid }}" aria-expanded="false" aria-controls="{{ $cid }}" style="background:var(--green);color:var(--gold);border-radius:10px;padding:8px 16px;font-weight:700"><i class="bi bi-person-vcard"></i> Lihat Profil</button>
        </div>
        <div class="collapse mt-3" id="{{ $cid }}">
            <div class="p-3 rounded-3" style="background:linear-gradient(135deg,#fdf6e3,#fffdf0);border:1.5px solid #e8d9a0">
                <div class="row g-2 small">
                    <div class="col-6"><div class="bio-label">Tempat / Tgl Lahir</div><div class="fw-bold" style="color:#0a3d1f">{{ $b->tempat_lahir ?? '-' }} / {{ $b?->tanggal_lahir ? $b->tanggal_lahir->locale('id')->isoFormat('D MMM YYYY') : '-' }}</div></div>
                    <div class="col-6"><div class="bio-label">NIK / NISN</div><div class="fw-bold" style="color:#0a3d1f">{{ $b->nik ?? '-' }} / {{ $b->nisn ?? '-' }}</div></div>
                    <div class="col-6"><div class="bio-label">Jenis Kelamin</div><div class="fw-bold" style="color:#0a3d1f">{{ $b->jenis_kelamin ?? '-' }}</div></div>
                    <div class="col-6"><div class="bio-label">Agama</div><div class="fw-bold" style="color:#0a3d1f">{{ $b->agama ?? '-' }}</div></div>
                    <div class="col-6"><div class="bio-label">Telepon</div><div class="fw-bold" style="color:#0a3d1f">{{ $b->telepon ?? '-' }}</div></div>
                    <div class="col-6"><div class="bio-label">HP / WA</div><div class="fw-bold" style="color:#0a3d1f">{{ $b->hp ?? '-' }}</div></div>
                    <div class="col-12"><div class="bio-label">Alamat</div><div class="fw-bold" style="color:#0a3d1f">{{ $b->alamat ?? '-' }}</div></div>
                    @if($p->catatan)
                    <div class="col-12 mt-2 pt-2" style="border-top:1px solid #e8d9a0">
                        <div class="bio-label">Catatan Admin</div>
                        <div class="fw-bold" style="color:#0a3d1f">{{ $p->catatan }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="mt-3">{{ $items->links() }}</div>
@endif
@endsection
