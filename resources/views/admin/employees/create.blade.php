<x-app-layout>
    <div class="p-4 lg:p-8">
        <div class="max-w-2xl mx-auto">
            <a href="{{ route('employees.index') }}" class="inline-flex items-center text-sm font-bold text-[#10b981] mb-6">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
            </a>

            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="p-8 md:p-10">
                    <h2 class="text-2xl font-black text-slate-900 mb-2">New Registration</h2>
                    <p class="text-sm text-slate-500 mb-8">Create an access account for a new Manager or Employee.</p>

                    <form action="{{ route('employees.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1">Full Name</label>
                                <input type="text" name="name" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981] focus:ring-emerald-500/10 transition-all" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1">Email Address</label>
                                <input type="email" name="email" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981]" required>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase ml-1">Password</label>
                            <input type="password" name="password" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981]" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1">Role</label>
                                <select name="role" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981]" required>
                                    <option value="user">User / Employee</option>
                                    <option value="manager">Manager</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1">Division</label>
                                <input type="text" name="division" placeholder="e.g., IT, HR" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981]" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1">Position</label>
                                <input type="text" name="position" placeholder="e.g., Staff, Lead" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981]" required>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#10b981] hover:bg-[#0da371] text-white py-4 rounded-2xl font-bold shadow-lg shadow-emerald-500/20 transition-all mt-4">
                            Save Account Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>