<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <!-- Sidebar -->
                        <aside class="w-full md:w-64 bg-gray-50 border border-gray-200 rounded p-4 shadow-sm">
                            <nav class="space-y-2">
                                <button type="button" onclick="window.location='{{ route('home') }}'" class="flex items-center w-full text-left px-4 py-2 rounded hover:bg-gray-100 text-gray-700 font-medium">Home</button>
                                <button type="button" onclick="window.location='{{ route('reseps.index') }}'" class="flex items-center w-full text-left px-4 py-2 rounded hover:bg-gray-100 text-gray-700">Resep</button>
                                <button type="button" onclick="window.location='{{ route('profile.edit') }}'" class="flex items-center w-full text-left px-4 py-2 rounded hover:bg-gray-100 text-gray-700">Profile</button>
                                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-gray-100 text-red-600">Logout</button>
                                </form>
                            </nav>
                        </aside>

                        <!-- Main content -->
                        <section class="flex-1 bg-white rounded p-6 border border-gray-100 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ __('Dashboard') }}</h3>
                                    <p class="text-sm text-gray-500">{{ __('Selamat datang! Berikut ringkasan akun dan navigasi cepat.') }}</p>
                                </div>
                                <div>
                                    <button type="button" onclick="window.location='{{ route('home') }}'" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Home</button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 rounded border border-gray-100">
                                    <h4 class="text-sm font-medium text-gray-700">Profil</h4>
                                    <p class="text-sm text-gray-600 mt-2">Perbarui profil dan informasi akun Anda di halaman profile.</p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded border border-gray-100">
                                    <h4 class="text-sm font-medium text-gray-700">Resep</h4>
                                    <p class="text-sm text-gray-600 mt-2">Kelola resep Anda — tambah, edit, atau hapus resep yang telah dibuat.</p>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
