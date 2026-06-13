<x-app-layout>
    <div class="p-4 lg:p-8 flex items-center justify-center min-h-[80vh]">
        <div class="max-w-3xl w-full">
            <a href="{{ route('evaluations.index', ['period' => $chosenPeriod]) }}" class="inline-flex items-center text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 hover:text-[#10b981] transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
            </a>

            <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-2xl border border-slate-100">
                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Evaluation Input Form</h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Evaluate: <span class="font-bold text-slate-900">{{ $employee->name }}</span> ({{ $employee->position }})
                    </p>
                </div>

                <form action="{{ route('evaluations.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Evaluation Period</label>
                            <input type="text" name="period" value="{{ $chosenPeriod }}" readonly 
                                   class="w-full bg-slate-100 border-slate-200 text-slate-800 font-extrabold rounded-2xl px-5 py-4 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Parameters</h4>
                        
                        @foreach($criteria as $c)
                            @php
                                $oldScore = 0;
                                if (isset($existingEvaluation) && is_array($existingEvaluation->scores)) {
                                    foreach ($existingEvaluation->scores as $detail) {
                                        if ($detail['criteria_id'] == $c->id) {
                                            $oldScore = $detail['score'];
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            
                            <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-100 group hover:border-emerald-200 transition-all">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="space-y-0.5 text-left">
                                        {{-- Nama Kriteria Penilaian --}}
                                        <label class="font-bold text-slate-800 block">{{ $c->name }}</label>
                                        {{-- Penyesuaian: Menampilkan deskripsi panduan kriteria --}}
                                        <p class="text-xs text-slate-400 font-medium leading-relaxed max-w-xl">
                                            {{ $c->description ?? 'No specific guidelines provided for this metric.' }}
                                        </p>
                                    </div>
                                    <span class="text-[10px] font-black bg-white border border-slate-100 px-3 py-1 rounded-full text-slate-400 uppercase shrink-0">
                                        Weight {{ $c->weight }}%
                                    </span>
                                </div>
                                <input type="number" name="scores[{{ $c->id }}]" min="0" max="100" 
                                       value="{{ old('scores.'.$c->id, $oldScore > 0 ? $oldScore : '') }}" 
                                       placeholder="Masukkan Nilai (0 - 100)" required
                                       class="w-full bg-white border-slate-200 rounded-xl px-5 py-3.5 focus:border-[#10b981] group-hover:shadow-md transition-all font-semibold mt-3">
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Manager Notes</label>
                        <textarea name="notes" rows="4" placeholder="Add any qualitative observations..." 
                                  class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-4 focus:border-[#10b981] outline-none">{{ old('notes', $existingEvaluation->notes ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-[#10b981] hover:bg-[#0da371] text-white py-5 rounded-2xl font-bold shadow-xl shadow-emerald-500/20 transition-all transform active:scale-95 text-center">
                        {{ isset($existingEvaluation) ? 'Update Evaluation' : 'Submit Evaluation' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>