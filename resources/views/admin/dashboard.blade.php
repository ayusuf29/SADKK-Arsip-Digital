@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <style>
        .card-stats {
            border-radius: 12px;
            border: none;
            transition: transform 0.2s;
        }
        .card-stats:hover {
            transform: translateY(-5px);
        }
        .stats-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 600;
        }
        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            color: #343a40;
            line-height: 1.2;
        }
        .stats-change {
            font-size: 0.8rem;
            font-weight: 600;
        }
        .sparkline-mock {
            height: 30px;
            width: 80px;
            opacity: 0.7;
        }
    </style>

    <div class="row pt-3">
        <!-- Surat Masuk -->
        <div class="col-lg-3 col-6">
            <div class="card card-stats shadow-sm bg-white">
                <div class="card-body p-3">
                    <p class="stats-label mb-1">Surat Masuk</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <h3 class="stats-value mb-0">{{ $suratMasuk['total'] }}</h3>
                    </div>
                    <a href="{{ route('admin.surat.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Surat Keluar -->
        <div class="col-lg-3 col-6">
            <div class="card card-stats shadow-sm bg-white">
                <div class="card-body p-3">
                    <p class="stats-label mb-1">Surat Keluar</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <h3 class="stats-value mb-0">{{ $suratKeluar['total'] }}</h3>
                    </div>
                    <a href="{{ route('admin.surat.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Invoice Masuk -->
        <div class="col-lg-3 col-6">
            <div class="card card-stats shadow-sm bg-white">
                <div class="card-body p-3">
                    <p class="stats-label mb-1">Invoice Masuk</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <h3 class="stats-value mb-0">{{ $invoiceMasuk['total'] }}</h3>
                    </div>
                    <a href="{{ route('admin.invoice.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Invoice Keluar -->
        <div class="col-lg-3 col-6">
            <div class="card card-stats shadow-sm bg-white">
                <div class="card-body p-3">
                    <p class="stats-label mb-1">Invoice Keluar</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <h3 class="stats-value mb-0">{{ $invoiceKeluar['total'] }}</h3>
                    </div>
                    <a href="{{ route('admin.invoice.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Perjanjian Kredit -->
        <div class="col-lg-3 col-6">
            <div class="card card-stats shadow-sm bg-white">
                <div class="card-body p-3">
                    <p class="stats-label mb-1">Perjanjian Kredit</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <h3 class="stats-value mb-0">{{ $kredit['total'] }}</h3>
                    </div>
                    <a href="{{ route('admin.perjanjian-kredit.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
@stop
