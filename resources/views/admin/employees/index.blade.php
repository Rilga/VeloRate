<x-app-layout>
    <div class="p-4 lg:p-8" x-data="{ activeTab: 'user' }">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Account Management</h1>
                    <p class="text-sm text-slate-500 mt-1">Manage company employee and manager profiles.</p>
                </div>
                <a href="{{ route('employees.create') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-[#10b981] hover:bg-[#0da371] text-white px-6 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-plus text-sm"></i>
                    <span>Add Account</span>
                </a>
            </div>

            {{-- Role Switcher Tabs --}}
            <div class="flex gap-2 mb-6 p-1 bg-slate-200/50 w-fit rounded-2xl">
                <button @click="activeTab = 'user'" 
                        :class="activeTab === 'user' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-200">
                    <i class="fas fa-users mr-2"></i> Employee Role
                </button>
                <button @click="activeTab = 'manager'" 
                        :class="activeTab === 'manager' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-200">
                    <i class="fas fa-user-tie mr-2"></i> Manager Role
                </button>
            </div>

            {{-- Tables Container --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
                <div class="overflow-x-auto">
                    
                    {{-- Employee Table --}}
                    <table class="w-full text-left border-collapse" x-show="activeTab === 'user'">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest w-16">No</th>
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Name</th>
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Division</th>
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Position</th>
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Last Score</th>
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Status</th>
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($employees as $index => $emp)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-900">{{ $emp->name }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $emp->email }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $emp->division }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $emp->position }}</td>
                                <td class="px-6 py-4 text-center">
                                    {{-- Mengambil data Last Score asli dari query database --}}
                                    @if($emp->last_score !== null)
                                        <span class="text-sm font-black text-slate-800">{{ $emp->last_score }}</span>
                                    @else
                                        <span class="text-xs font-semibold text-slate-300">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('employees.edit', $emp->id) }}" class="p-2 text-slate-400 hover:text-emerald-500 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                            @csrf @method('DELETE')
                                            <button class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-slate-400 text-sm">No employee data available.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Manager Table --}}
                    <table class="w-full text-left border-collapse" x-show="activeTab === 'manager'" x-cloak>
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest w-16">No</th>
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Manager Name</th>
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Division</th>
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Position</th>
                                <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($managers as $index => $mgr)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-900">{{ $mgr->name }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $mgr->email }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $mgr->division }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $mgr->position }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('employees.edit', $mgr->id) }}" class="p-2 text-slate-400 hover:text-emerald-500 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('employees.destroy', $mgr->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this manager?')">
                                            @csrf @method('DELETE')
                                            <button class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm">No manager data available.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>