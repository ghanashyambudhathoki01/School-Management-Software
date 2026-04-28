@extends('layouts.app')
@section('title', 'View Certificate')
@section('page-title', 'Certificate Preview')
@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl border-8 border-double border-indigo-100 p-12 relative overflow-hidden print-full shadow-lg"
            id="certificate">
            {{-- Decorative Elements --}}
            <div class="absolute top-0 left-0 w-32 h-32 bg-indigo-50 rounded-br-full -z-10"></div>
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-indigo-50 rounded-tl-full -z-10"></div>

            <div class="text-center mb-12">
                <h1 class="text-4xl font-serif font-bold text-indigo-900 mb-2">
                    {{ \App\Models\Setting::get('school_name', 'Gorkhabyte Academy Academy') }}</h1>
                <p class="text-gray-500 italic">Certificate of Excellence & Recognition</p>
                <div class="w-24 h-1 bg-indigo-600 mx-auto mt-4"></div>
            </div>

            <div class="text-center mb-12">
                <h2 class="text-2xl font-medium text-gray-700 mb-8 uppercase tracking-widest">
                    @if($certificate->type == 'transfer') Transfer Certificate
                    @elseif($certificate->type == 'character') Character Certificate
                    @else Completion Certificate @endif
                </h2>

                <p class="text-lg text-gray-600 mb-8">This is to certify that</p>
                <h3
                    class="text-4xl font-serif font-bold text-gray-900 mb-8 border-b-2 border-gray-100 inline-block px-12 pb-2">
                    {{ $certificate->student->full_name }}</h3>

                <div class="max-w-2xl mx-auto text-gray-600 leading-relaxed text-lg">
                    @if($certificate->content)
                        {!! nl2br(e($certificate->content)) !!}
                    @else
                        @if($certificate->type == 'transfer')
                            has been a student of this institution in Class <span
                                class="font-bold">{{ $certificate->student->schoolClass->name ?? 'N/A' }}</span>.
                            They have successfully completed their term and are being transferred to their next educational venture
                            with our best wishes.
                        @elseif($certificate->type == 'character')
                            has maintained an exemplary record of conduct and character during their tenure at our institution.
                            Their dedication to learning and positive influence on peers have been highly commendable.
                        @else
                            has successfully completed the prescribed course of study and requirements for graduation from
                            Class <span class="font-bold">{{ $certificate->student->schoolClass->name ?? 'N/A' }}</span> at
                            Gorkhabyte Academy Academy.
                        @endif
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 gap-12 mt-20 text-center">
                <div>
                    <div class="w-48 border-b border-gray-400 mx-auto mb-2"></div>
                    <p class="text-sm font-bold text-gray-700">Issued Date</p>
                    <p class="text-xs text-gray-400">{{ $certificate->issue_date->format('F d, Y') }}</p>
                </div>
                <div>
                    <div class="w-48 border-b border-gray-400 mx-auto mb-2"></div>
                    <p class="text-sm font-bold text-gray-700">Principal Signature</p>
                    <p class="text-xs text-gray-400">Gorkhabyte Academy Academy</p>
                </div>
            </div>

            <div class="absolute bottom-4 left-0 right-0 text-center">
                <p class="text-[10px] text-gray-300 font-mono">Certificate No: {{ $certificate->certificate_no }} | Verified
                    by: {{ $certificate->issuer->name ?? 'Admin' }}</p>
            </div>
        </div>

        <div class="mt-8 flex justify-between items-center no-print">
            <a href="{{ route('certificates.index') }}" class="text-sm text-gray-500 hover:text-gray-700"><i
                    class="fas fa-arrow-left mr-1"></i> Back to List</a>
            <button onclick="window.print()"
                class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg transition"><i
                    class="fas fa-print mr-2"></i> Print Certificate</button>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #certificate,
            #certificate * {
                visibility: visible;
            }

            #certificate {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none;
                box-shadow: none;
            }
        }
    </style>
@endsection