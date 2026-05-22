<x-app-layout>
    <div class="p-4 lg:p-8">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header & Progress Section --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div class="flex-1">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Assessment Criteria</h1>
                    <p class="text-sm text-slate-500 mt-1">Total weight must reach exactly 100% to activate the evaluation system.</p>
                </div>
                
                <div class="w-full md:w-80 bg-white p-5 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Current Total Weight</span>
                        <span class="text-lg font-black {{ $totalWeight > 100 ? 'text-red-500' : 'text-[#10b981]' }}">
                            {{ $totalWeight }}%
                        </span>
                    </div>
                    <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden border border-slate-50">
                        <div class="h-full transition-all duration-700 ease-out {{ $totalWeight > 100 ? 'bg-red-500' : 'bg-[#10b981]' }}" 
                             style="width: {{ $totalWeight }}%"></div>
                    </div>
                    @if($totalWeight < 100)
                        <p class="text-[9px] text-amber-600 font-bold mt-2 uppercase italic"><i class="fas fa-exclamation-triangle mr-1"></i> {{ 100 - $totalWeight }}% remaining</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Table Section (Mobile Friendly) --}}
                <div class="lg:col-span-8 order-2 lg:order-1">
                    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-slate-50/50 border-b border-slate-100">
                                        <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Criteria Name</th>
                                        <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Weight</th>
                                        <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($criteria as $c)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-6 py-5">
                                            <p class="text-sm font-bold text-slate-900">{{ $c->name }}</p>
                                            <p class="text-[10px] text-slate-400 font-medium">Created: {{ $c->created_at->format('M d, Y') }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <div class="inline-flex items-center justify-center bg-emerald-50 text-[#10b981] h-10 w-16 rounded-2xl font-black text-sm border border-emerald-100">
                                                {{ $c->weight }}%
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <div class="flex justify-end gap-1">
                                                <a href="{{ route('criteria.edit', $c->id) }}" class="p-3 text-slate-300 hover:text-[#10b981] transition-all transform hover:scale-110">
                                                    <i class="fas fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('criteria.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this criterion?')">
                                                    @csrf @method('DELETE')
                                                    <button class="p-3 text-slate-300 hover:text-red-500 transition-all transform hover:scale-110">
                                                        <i class="fas fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-slate-400 font-medium italic">No assessment criteria found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Quick Add Section (Desktop Sidebar) --}}
                <div class="lg:col-span-4 order-1 lg:order-2">
                    <div class="bg-[#1e293b] p-8 rounded-[2.5rem] shadow-2xl shadow-slate-900/20 sticky top-24">
                        <div class="mb-6">
                            <h3 class="text-white font-bold text-xl">Add New</h3>
                            <p class="text-slate-400 text-xs mt-1">Remaining weight quota: {{ 100 - $totalWeight }}%</p>
                        </div>

                        <form action="{{ route('criteria.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Criteria Label</label>
                                <input type="text" name="name" placeholder="e.g., Teamwork" required
                                       class="w-full bg-slate-800/50 border-slate-700 text-white rounded-2xl px-5 py-4 focus:border-[#10b981] focus:ring-0 transition-all placeholder:text-slate-600">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Percentage Weight (%)</label>
                                <input type="number" name="weight" placeholder="1 - 100" required
                                       class="w-full bg-slate-800/50 border-slate-700 text-white rounded-2xl px-5 py-4 focus:border-[#10b981] focus:ring-0 transition-all">
                            </div>
                            <button type="submit" 
                                    class="w-full bg-[#10b981] hover:bg-[#0da371] text-white py-4 rounded-2xl font-bold shadow-lg shadow-emerald-500/20 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                                <i class="fas fa-plus-circle text-sm"></i>
                                <span>Save Criterion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>