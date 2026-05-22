<x-app-layout>
    <div class="p-4 lg:p-8 text-slate-800">
        <div class="max-w-7xl mx-auto space-y-6">
            
            {{-- Header Row --}}
            <div class="mb-2">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Admin Control Center</h1>
                <p class="text-sm text-slate-500">Overview account allocations, system configurations, and active matrix baselines.</p>
            </div>

            {{-- 1. ANALYTICS STATUS COUNTER BAR --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Employees</span>
                    <h3 class="text-xl font-black text-slate-900 mt-1">{{ $totalEmployees }} <span class="text-xs text-slate-400 font-normal">People</span></h3>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Active Managers</span>
                    <h3 class="text-xl font-black text-slate-900 mt-1">{{ $totalManagers }} <span class="text-xs text-slate-400 font-normal">People</span></h3>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Configured KPIs Weight</span>
                    <h3 class="text-xl font-black mt-1 {{ $totalWeight == 100 ? 'text-emerald-600' : 'text-amber-500' }}">
                        {{ $totalWeight }}% <span class="text-[10px] font-normal text-slate-400">/ 100%</span>
                    </h3>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Evaluation Status</span>
                    <div class="mt-1.5">
                        @if($totalWeight == 100)
                            <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold rounded-md text-[10px] uppercase">Active & Ready</span>
                        @else
                            <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-100 font-bold rounded-md text-[10px] uppercase">Pending Weight</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 2. QUICK MANAGEMENT SHORTCUTS AREA --}}
            <div class="space-y-3">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Quick Action Shortcuts</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('employees.create') }}" class="group bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:border-[#10b981] transition-all flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl bg-slate-50 text-slate-700 flex items-center justify-center group-hover:bg-emerald-50 group-hover:text-[#10b981] transition-colors">
                                <i class="fas fa-user-plus text-sm"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Add New Account Profile</h4>
                                <p class="text-[11px] text-slate-400">Register new staff attributes, roles, and functional divisions.</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-xs text-slate-300 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('criteria.index') }}" class="group bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-sm hover:bg-slate-950 transition-all flex items-center justify-between text-white">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl bg-slate-800 text-slate-300 flex items-center justify-center group-hover:bg-[#10b981] group-hover:text-white transition-colors">
                                <i class="fas fa-folder-plus text-sm"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold">Configure KPI Metrics Matrix</h4>
                                <p class="text-[11px] text-slate-400">Add assessment frameworks or assign percentage quotas.</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-xs text-slate-500 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            {{-- 3. LOWER BLOCK: ACTIVE COMPONENT LISTINGS --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                {{-- Left: Current Active KPIs Checklist Summary --}}
                <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active Evaluation Criteria</h3>
                        <a href="{{ route('criteria.index') }}" class="text-[11px] font-bold text-[#10b981] hover:underline">Manage Matrix</a>
                    </div>
                    <div class="p-4 divide-y divide-slate-50">
                        @forelse($criteria as $c)
                            <div class="py-3 flex items-center justify-between text-xs">
                                <div class="space-y-0.5">
                                    <p class="font-bold text-slate-800 flex items-center gap-1.5">
                                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $c->name }}
                                    </p>
                                    <p class="text-[10px] text-slate-400">Created on {{ $c->created_at->format('M d, Y') }}</p>
                                </div>
                                <span class="font-black text-xs text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">
                                    {{ $c->weight }}%
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-10 text-xs text-slate-400 italic">
                                <i class="fas fa-layer-group text-2xl text-slate-200 block mb-2"></i>
                                No custom criteria configurations found in the index system.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Right: New Registered Accounts (Added Value feature) --}}
                <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Recent Registrations</h3>
                        <a href="{{ route('employees.index') }}" class="text-[11px] font-bold text-slate-400 hover:underline">View All</a>
                    </div>
                    <div class="p-4 divide-y divide-slate-50">
                        @forelse($recentAccounts as $account)
                            <div class="py-3 flex items-center justify-between text-xs">
                                <div class="flex items-center gap-3">
                                    <div class="h-7 w-7 rounded-full bg-slate-50 border text-slate-500 font-bold text-[10px] flex items-center justify-center uppercase">
                                        {{ substr($account->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $account->name }}</p>
                                        <p class="text-[10px] text-slate-400 uppercase font-medium">{{ $account->division ?: 'Unassigned' }} • {{ $account->position ?: 'No Position' }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider 
                                    {{ $account->role == 'manager' ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $account->role }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-10 text-xs text-slate-400 italic">No registered user entries found.</div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>