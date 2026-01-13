<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

    <div class="profile-wrapper">
        <div class="container">
            <!-- Header -->
            <div class="profile-header">
                <h1><i class="fas fa-user-circle"></i> Profil Saya</h1>
                <p>Kelola informasi akun dan pengaturan keamanan Anda</p>
            </div>

            <!-- Cards Container -->
            <div class="profile-cards">
                <!-- Update Profile -->
                <div class="profile-card">
                    <div class="card-header">
                        <i class="fas fa-user-edit"></i>
                        <h2>Informasi Profil</h2>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="profile-card">
                    <div class="card-header">
                        <i class="fas fa-lock"></i>
                        <h2>Perbarui Sandi</h2>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="profile-card danger">
                    <div class="card-header danger">
                        <i class="fas fa-trash-alt"></i>
                        <h2>Hapus Akun</h2>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
