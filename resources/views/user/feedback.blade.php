<x-app-layout>
    <div class="p-4 lg:p-8 text-slate-800">
        <div class="max-w-7xl mx-auto space-y-6">
            
            {{-- Main Top Header --}}
            <div class="mb-2">
                <h1 class="text-xl font-bold text-slate-900">Feedback & Recommendations</h1>
                <p class="text-xs text-slate-400">Manager notes and improvement suggestions</p>
            </div>

            {{-- TOP FULL-WIDTH CYCLE ALERT BANNER --}}
            @if($latestEval)
                <div class="w-full bg-[#e8f8f2] border border-[#a7f3d0] rounded-xl px-5 py-3 text-xs font-semibold text-[#065f46]">
                    Latest feedback from {{ $latestEval->period }} evaluation cycle
                </div>
            @endif

            {{-- MAIN SPLIT CONTENT GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                {{-- LEFT COLUMN: CHRONOLOGICAL MANAGER FEEDBACK CARDS --}}
                <div class="lg:col-span-6 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                    <div class="mb-2">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Manager Feedback</h3>
                    </div>

                    <div class="space-y-4">
                        @forelse($feedbacks as $fb)
                            <div class="bg-slate-50/50 p-4 rounded-xl border border-slate-100 relative">
                                <span class="text-[10px] font-bold text-slate-400 block mb-1">
                                    From: Manager — {{ $fb->period }}
                                </span>
                                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                    {{ $fb->notes }}
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-10 text-xs text-slate-400 italic">
                                No written feedback notes uploaded yet.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- RIGHT COLUMN: CONTEXTUAL RECOMMENDATION LIST ITEMS --}}
                <div class="lg:col-span-6 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                    <div class="mb-2">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Improvement Recommendations</h3>
                    </div>

                    <div class="space-y-3">
                        @forelse(array_slice($recommendations, 0, 3) as $rec) {{-- Shows top 3 metrics layers like the picture --}}
                            <div class="p-3.5 rounded-xl border flex gap-3.5 items-start transition-all {{ $rec['style'] }}">
                                {{-- Left Vector Icon Element --}}
                                <div class="mt-0.5 flex-shrink-0 w-4 text-center">
                                    <i class="fas {{ $rec['icon'] }} text-sm"></i>
                                </div>
                                
                                {{-- Right Content Context Block --}}
                                <div class="space-y-0.5 text-left">
                                    <h4 class="text-xs font-bold text-slate-700">
                                        <span class="{{ $rec['badge'] ? 'text-emerald-600' : 'text-slate-800' }}">{{ $rec['category'] }}</span> 
                                        <span class="text-slate-400 font-medium">({{ $rec['score'] }}/100)</span><span class="text-emerald-600 font-bold text-[11px]">{{ $rec['badge'] }}</span>
                                    </h4>
                                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                                        {{ $rec['suggestion'] }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-xs text-slate-400 italic">
                                Complete your initial performance review card to view recommended goals.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>