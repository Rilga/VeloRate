<x-app-layout>
    <div class="p-4 lg:p-8 flex items-center justify-center min-h-[80vh]">
        <div class="max-w-md w-full">
            <a href="{{ route('criteria.index') }}" class="inline-flex items-center text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 hover:text-[#10b981] transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke List
            </a>
            
            <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Buat Kriteria</h2>
                <p class="text-sm text-slate-500 mb-8">Tambahkan parameter penilaian baru untuk sistem.</p>

                <form action="{{ route('criteria.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Nama</label>
                        <input type="text" name="name" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-4 focus:border-[#10b981] focus:ring-emerald-500/5 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Bobot (%)</label>
                        <input type="number" name="weight" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-4 focus:border-[#10b981] focus:ring-emerald-500/5 transition-all">
                    </div>
                    <button type="submit" class="w-full bg-[#10b981] hover:bg-[#0da371] text-white py-4 rounded-2xl font-bold shadow-xl shadow-emerald-500/20 transition-all">
                        Simpan Kriteria
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>