 <!-- App Bottom Menu -->
 <div class="appBottomMenu">
    <a href="{{ url('dashboard') }}" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline" role="img" class="md hydrated"
                aria-label="home outline"></ion-icon>
            <strong>Beranda</strong>
        </div>
    </a>
    <a href="{{ url('presensi/histori') }}" class="item {{ request()->is('presensi/histori') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="file-tray-full-outline" role="img" class="md hydrated" aria-label="folder outline"></ion-icon>
            <strong>Riwayat</strong>
        </div>
    </a>
    <a href="{{ url('presensi/create') }}" class="item">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            </div>
        </div>
    </a>
    <a href="{{ url('presensi/izin') }}" class="item {{ request()->is('presensi/izin') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline" role="img" class="md hydrated"
                aria-label="document text outline"></ion-icon>
            <strong>Izin</strong>
        </div>
    </a>
    <a href="{{ url('editprofile') }}" class="item {{ request()->is('editprofile') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profil</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->
