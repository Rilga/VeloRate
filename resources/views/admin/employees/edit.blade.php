<x-app-layout>
    <div class="p-4 lg:p-8">
        <div class="max-w-2xl mx-auto">
            <a href="{{ route('employees.index') }}" class="inline-flex items-center text-sm font-bold text-slate-400 mb-6 hover:text-slate-600 transition-colors">
                <i class="fas fa-chevron-left mr-2"></i> Back to List
            </a>

            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="p-8 md:p-10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="h-14 w-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-black border border-emerald-100">
                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-slate-900 leading-none">Edit Profile</h2>
                            <p class="text-sm text-slate-500 mt-1">Update profile information for {{ $employee->name }}</p>
                        </div>
                    </div>

                    <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="space-y-6">
                        @csrf @method('PUT')
                        
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ $employee->name }}" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981] transition-all" required>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ $employee->email }}" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981]" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1">Role</label>
                                <select name="role" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981]">
                                    <option value="user" {{ $employee->role == 'user' ? 'selected' : '' }}>User / Employee</option>
                                    <option value="manager" {{ $employee->role == 'manager' ? 'selected' : '' }}>Manager</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1">Division</label>
                                <input type="text" name="division" value="{{ $employee->division }}" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981]" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1">Position</label>
                                <input type="text" name="position" value="{{ $employee->position }}" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981]" required>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-4">Leave the password blank if you do not wish to change it</p>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1">New Password (Optional)</label>
                                <input type="password" name="password" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:border-[#10b981]">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#1e293b] hover:bg-[#10b981] text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-slate-200/50 mt-4">
                            Update Account Details
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>