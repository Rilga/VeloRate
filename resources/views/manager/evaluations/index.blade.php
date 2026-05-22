<x-app-layout>
    <div class="p-4 lg:p-8" x-data="{ 
        search: '', 
        selectedDivision: '',
        selectedStatus: '',
        currentPage: 1,
        perPage: 10,
        get employees() {
            return [
                @foreach($employees as $emp)
                @php
                    $currentEvaluation = $emp->evaluations->first(); 
                    $isEvaluated = $currentEvaluation ? true : false;
                    $finalScore = $currentEvaluation ? $currentEvaluation->final_score : 0;
                @endphp
                {
                    id: '{{ $emp->id }}',
                    name: '{{ flex_string($emp->name) }}',
                    position: '{{ flex_string($emp->position) }}',
                    division: '{{ flex_string($emp->division) }}',
                    isEvaluated: {{ $isEvaluated ? 'true' : 'false' }},
                    finalScore: {{ $finalScore }},
                    route: '{{ route('evaluations.create', $emp->id) }}'
                },
                @endforeach
            ];
        },
        get filteredEmployees() {
            return this.employees.filter(emp => {
                const matchSearch = emp.name.toLowerCase().includes(this.search.toLowerCase()) || 
                                    emp.position.toLowerCase().includes(this.search.toLowerCase());
                const matchDivision = this.selectedDivision === '' || emp.division === this.selectedDivision;
                
                let matchStatus = true;
                if (this.selectedStatus === 'done') matchStatus = emp.isEvaluated;
                if (this.selectedStatus === 'pending') matchStatus = !emp.isEvaluated;

                return matchSearch && matchDivision && matchStatus;
            });
        },
        get pagedEmployees() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredEmployees.slice(start, start + this.perPage);
        },
        get totalPages() {
            return Math.ceil(this.filteredEmployees.length / this.perPage);
        }
    }">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header Utama --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-black text-slate-900">Employee Evaluation — <span class="text-[#10b981]">{{ $selectedPeriod }}</span></h1>
                    <p class="text-sm text-slate-500">monitor the status of value achievement and provide feedback on current quarter performance.</p>
                </div>
                
                <div class="bg-white px-5 py-3 rounded-2xl border border-slate-100 shadow-sm w-fit flex gap-4 text-xs font-bold">
                    <div>
                        <span class="text-slate-400 uppercase tracking-wider">Not Evaluated Yet:</span>
                        <span class="text-amber-500 font-black ml-1" x-text="employees.filter(e => !e.isEvaluated).length"></span>
                    </div>
                    <div class="border-l border-slate-200 pl-4">
                        <span class="text-slate-400 uppercase tracking-wider">Evaluated:</span>
                        <span class="text-emerald-500 font-black ml-1" x-text="employees.filter(e => e.isEvaluated).length"></span>
                    </div>
                </div>
            </div>

            {{-- Filter & Search Bar --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-6">
                <div class="md:col-span-3">
                    <form method="GET" action="{{ route('evaluations.index') }}" id="periodForm">
                        <select name="period" onchange="document.getElementById('periodForm').submit()"
                                class="w-full px-4 py-3.5 bg-slate-900 text-white rounded-2xl focus:border-[#10b981] text-sm shadow-sm font-bold cursor-pointer">
                            
                            @php 
                                // Mengambil tahun aktif saat ini secara real-time dari server
                                $y = date('Y'); 
                            @endphp
                            
                            <option value="{{ $y }}-Q1" {{ $selectedPeriod == "$y-Q1" ? 'selected' : '' }}>{{ $y }} — Quarter 1</option>
                            <option value="{{ $y }}-Q2" {{ $selectedPeriod == "$y-Q2" ? 'selected' : '' }}>{{ $y }} — Quarter 2</option>
                            <option value="{{ $y }}-Q3" {{ $selectedPeriod == "$y-Q3" ? 'selected' : '' }}>{{ $y }} — Quarter 3</option>
                            <option value="{{ $y }}-Q4" {{ $selectedPeriod == "$y-Q4" ? 'selected' : '' }}>{{ $y }} — Quarter 4</option>
                        </select>
                    </form>
                </div>

                <div class="relative md:col-span-4">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" x-model="search" @input="currentPage = 1" placeholder="Search for employees..." 
                           class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl focus:border-[#10b981] text-sm shadow-sm">
                </div>

                <div class="md:col-span-3">
                    <select x-model="selectedDivision" @change="currentPage = 1"
                            class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-2xl focus:border-[#10b981] text-sm shadow-sm font-medium text-slate-600">
                        <option value="">All Divisions</option>
                        @foreach($employees->pluck('division')->unique() as $div)
                            <option value="{{ $div }}">{{ $div }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <select x-model="selectedStatus" @change="currentPage = 1"
                            class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-2xl focus:border-[#10b981] text-sm shadow-sm font-medium text-slate-600">
                        <option value="">All Status</option>
                        <option value="pending">⚠️ Not Evaluated Yet</option>
                        <option value="done">✅ Evaluated</option>
                    </select>
                </div>
            </div>

            {{-- Tabel Utama --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Name</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Division</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Status / Score ({{ $selectedPeriod }})</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <template x-for="(emp, index) in pagedEmployees" :key="emp.id">
                                <tr class="hover:bg-slate-50/40 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-xl flex items-center justify-center font-black text-sm uppercase shadow-sm"
                                                 :class="emp.isEvaluated ? 'bg-emerald-50 border border-emerald-100 text-[#10b981]' : 'bg-slate-100 border border-slate-200 text-slate-400'"
                                                 x-text="emp.name.substring(0, 2)">
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-900 group-hover:text-[#10b981] transition-colors" x-text="emp.name"></p>
                                                <p class="text-[11px] text-slate-400 font-medium" x-text="emp.position"></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-slate-100 border border-slate-200/60 rounded-full text-xs font-bold text-slate-600 uppercase tracking-wide" x-text="emp.division"></span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <template x-if="emp.isEvaluated">
                                            <span class="px-4 py-1.5 bg-emerald-50 text-emerald-700 rounded-full text-xs font-extrabold border border-emerald-100" x-text="'Skor: ' + emp.finalScore"></span>
                                        </template>
                                        <template x-if="!emp.isEvaluated">
                                            <span class="px-4 py-1.5 bg-amber-50 text-amber-700 rounded-full text-xs font-bold border border-amber-100/70">
                                                Not Evaluated Yet
                                            </span>
                                        </template>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a :href="emp.route + '?period={{ $selectedPeriod }}'" 
                                           :class="emp.isEvaluated ? 'bg-slate-100 hover:bg-emerald-50 text-slate-700 border border-slate-200' : 'bg-[#1e293b] hover:bg-[#10b981] text-white'"
                                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-sm active:scale-95">
                                            <i class="fas" :class="emp.isEvaluated ? 'fa-pen-to-square text-[11px]' : 'fa-star text-[10px]'"></i>
                                            <span x-text="emp.isEvaluated ? 'Edit Score' : 'Start Evaluation'"></span>
                                        </a>
                                    </td>
                                </tr>
                            </template>

                            <tr x-show="filteredEmployees.length === 0">
                                <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fas fa-user-slash text-3xl text-slate-200"></i>
                                        <p class="text-sm font-semibold mt-2">Karyawan tidak ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Controls --}}
                <div class="bg-slate-50/50 border-t border-slate-100 px-6 py-4 flex items-center justify-between gap-4" x-show="totalPages > 1">
                    <span class="text-xs font-semibold text-slate-500">
                        Menampilkan halaman <span class="text-slate-900 font-bold" x-text="currentPage"></span> dari <span class="text-slate-900 font-bold" x-text="totalPages"></span>
                    </span>
                    <div class="flex gap-2">
                        <button @click="currentPage--" :disabled="currentPage === 1" class="p-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 disabled:opacity-40 transition-all text-xs font-bold shadow-sm">Previous</button>
                        <button @click="currentPage++" :disabled="currentPage === totalPages" class="p-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 disabled:opacity-40 transition-all text-xs font-bold shadow-sm">Next</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

@php
function flex_string($str) {
    return str_replace(["'", '"', "\r", "\n"], ["\'", '\"', '', ''], $str);
}
@endphp