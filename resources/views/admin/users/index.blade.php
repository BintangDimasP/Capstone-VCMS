@extends('admin.layout')

@section('title', 'Kelola Pengguna')

@section('content')

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Akun</h2>
        <button onclick="openModal('addModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md flex items-center gap-2 transition">
            <i class="ph ph-plus-circle text-xl"></i> Tambah User
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4 flex justify-center gap-2">
                        <button onclick="editUser({{ $user }})" class="text-blue-500 hover:text-blue-700 bg-blue-50 p-2 rounded-lg transition">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-lg transition">
                                <i class="ph ph-trash text-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="userModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white w-full max-w-md rounded-xl shadow-2xl p-6 transform transition-all scale-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Tambah User Baru</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500"><i class="ph ph-x text-2xl"></i></button>
            </div>

            <form id="userForm" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST"> <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="inputName" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="inputEmail" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                        <select name="role" id="inputRole" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="redaktur">Redaktur</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="inputPassword" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Biarkan kosong jika tidak diubah">
                        <p class="text-xs text-gray-400 mt-1" id="passHelp">*Wajib diisi untuk user baru</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    const modal = document.getElementById('userModal');
    const form = document.getElementById('userForm');
    const title = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    const passHelp = document.getElementById('passHelp');

    // Buka Modal Tambah
    function openModal() {
        // Reset Form ke Mode Tambah
        form.action = "{{ route('admin.users.store') }}";
        methodField.value = "POST";
        title.innerText = "Tambah User Baru";
        passHelp.innerText = "*Wajib diisi";
        
        // Reset input
        document.getElementById('inputName').value = "";
        document.getElementById('inputEmail').value = "";
        document.getElementById('inputRole').value = "redaktur";
        document.getElementById('inputPassword').required = true; // Password wajib saat tambah baru

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // Buka Modal Edit (User dikirim lewat JSON dari Blade)
    function editUser(user) {
        // Ubah Form ke Mode Edit
        form.action = "/admin/users/" + user.id; // Manual set URL update
        methodField.value = "PUT"; // Spoofing PUT method
        title.innerText = "Edit User: " + user.name;
        passHelp.innerText = "*Isi hanya jika ingin mengganti password";

        // Isi input dengan data lama
        document.getElementById('inputName').value = user.name;
        document.getElementById('inputEmail').value = user.email;
        document.getElementById('inputRole').value = user.role;
        document.getElementById('inputPassword').required = false; // Password opsional saat edit

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush