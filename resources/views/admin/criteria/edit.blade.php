<x-app-layout>
    <div class="p-4 lg:p-8 flex items-center justify-center min-h-[80vh]">
        <div class="max-w-md w-full">
            <a href="{{ route('criteria.index') }}" class="inline-flex items-center text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 hover:text-[#10b981] transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Cancel Changes
            </a>
            
            <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100 relative overflow-hidden">
                {{-- Decorative element --}}
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <i class="fas fa-pen-nib text-8xl"></i>
                </div>

                <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Edit Criterion</h2>
                <p class="text-sm text-slate-500 mb-8">Adjust the label or percentage weight for this assessment criterion.</p>

                <form action="{{ route('criteria.update', $criterion->id) }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Change Name</label>
                        <input type="text" name="name" value="{{ $criterion->name }}" required class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-4 focus:border-[#10b981] focus:ring-emerald-500/5 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Change Weight (%)</label>
                        <input type="number" name="weight" value="{{ $criterion->weight }}" required class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-4 focus:border-[#10b981] focus:ring-emerald-500/5 transition-all">
                    </div>
                    {{-- Penyesuaian: Menambahkan Field Deskripsi --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Change Description</label>
                        <textarea name="description" rows="3" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-4 focus:border-[#10b981] focus:ring-emerald-500/5 transition-all outline-none resize-none" placeholder="Adjust criterion description...">{{ old('description', $criterion->description) }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#1e293b] hover:bg-[#10b981] text-white py-4 rounded-2xl font-bold shadow-xl shadow-slate-900/10 transition-all">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>