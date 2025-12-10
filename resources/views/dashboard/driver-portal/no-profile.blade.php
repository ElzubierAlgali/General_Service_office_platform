@extends('layouts.master')

@section('title', 'لم يتم العثور على ملف السائق')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 60vh;">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-5">
                    <div class="avatar bg-danger bg-opacity-10 rounded-circle mx-auto mb-4" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-slash fa-3x text-danger"></i>
                    </div>
                    
                    <h3 class="text-danger mb-3">لم يتم العثور على ملف السائق</h3>
                    
                    <p class="text-muted mb-4">
                        حسابك مسجل كسائق، لكن لم يتم ربطه بملف سائق في النظام.
                        <br>
                        يرجى التواصل مع مسؤول النظام لربط حسابك بملف السائق الخاص بك.
                    </p>

                    <div class="alert alert-warning text-start">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>معلومات حسابك:</h6>
                        <ul class="mb-0">
                            <li><strong>الاسم:</strong> {{ auth()->user()->name }}</li>
                            <li><strong>البريد الإلكتروني:</strong> {{ auth()->user()->email }}</li>
                        </ul>
                    </div>

                    <p class="small text-muted">
                        يجب أن يتطابق البريد الإلكتروني في ملف السائق مع البريد الإلكتروني لحسابك.
                    </p>

                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-1"></i> الصفحة الرئيسية
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-sign-out-alt me-1"></i> تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

