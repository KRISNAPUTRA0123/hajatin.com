<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $invitation->title }} - Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-purple-50 via-white to-pink-50 text-slate-900">
    <main>
        <section class="min-h-screen flex items-center justify-center px-6 py-16">
            <div class="max-w-2xl w-full bg-white/90 backdrop-blur rounded-[2rem] shadow-xl border border-white p-8 text-center fade-up">

                <div class="inline-flex items-center justify-center px-4 py-2 rounded-full bg-purple-100 text-purple-700 text-sm font-semibold">
                    {{ $invitation->category->name }}
                </div>

                @if ($invitation->cover_image)
                    <img src="{{ asset('storage/' . $invitation->cover_image) }}"
                        class="w-full h-72 object-cover rounded-[1.5rem] mt-6 shadow-sm"
                        alt="Cover Undangan">
                @else
                    <div class="w-full h-72 rounded-[1.5rem] mt-6 bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center text-slate-500">
                        Cover Undangan
                    </div>
                @endif

                <h1 class="text-4xl md:text-5xl font-extrabold mt-8 tracking-tight text-slate-950">
                    {{ $invitation->title }}
                </h1>

                <p class="text-lg text-purple-600 font-semibold mt-3">
                    {{ $invitation->event_name }}
                </p>

                @if ($invitation->description)
                    <p class="text-slate-600 mt-6 leading-relaxed">
                        {{ $invitation->description }}
                    </p>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-10">
                    <div class="bg-purple-50 border border-purple-100 rounded-2xl p-5">
                        <p class="text-sm text-slate-500">Tanggal</p>

                        <p class="font-bold mt-1 text-slate-900">
                            @if ($invitation->event_date)
                                {{ $invitation->event_date->format('d M Y') }}
                            @else
                                Belum diatur
                            @endif
                        </p>
                    </div>

                    <div class="bg-purple-50 border border-purple-100 rounded-2xl p-5">
                        <p class="text-sm text-slate-500">Waktu</p>

                        <p class="font-bold mt-1 text-slate-900">
                            {{ $invitation->event_time ?: 'Belum diatur' }}
                        </p>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5 mt-6">
                    <p class="text-sm text-slate-500">Lokasi</p>

                    <p class="font-bold mt-1 text-slate-900">
                        {{ $invitation->location_name ?: 'Lokasi belum diatur' }}
                    </p>

                    @if ($invitation->address)
                        <p class="text-slate-600 mt-2">
                            {{ $invitation->address }}
                        </p>
                    @endif
                </div>

                <div class="mt-8 flex flex-col md:flex-row justify-center gap-4">
                    @if ($invitation->maps_url)
                        <a href="{{ $invitation->maps_url }}"
                        target="_blank"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-xl transition">
                            Buka Google Maps
                        </a>
                    @endif

                    <a href="https://wa.me/?text={{ urlencode('Saya mengundang Anda ke acara: ' . $invitation->title . ' ' . route('invitation.public', $invitation->slug)) }}"
                    target="_blank"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl transition">
                        Bagikan WhatsApp
                    </a>
                </div>
            </div>
        </section>

        @if ($invitation->photos->count())
            <section class="max-w-4xl mx-auto px-6 pb-16">
                <div class="bg-white rounded-3xl shadow p-8">
                    <h2 class="text-2xl font-bold text-center">
                        Galeri Foto
                    </h2>

                    <p class="text-gray-600 text-center mt-2">
                        Momen spesial dalam acara ini.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                        @foreach ($invitation->photos as $photo)
                            <img src="{{ asset('storage/' . $photo->image_path) }}"
                                class="w-full h-56 object-cover rounded-2xl"
                                alt="Galeri Foto">
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="max-w-3xl mx-auto px-6 pb-16">
            <div class="bg-white rounded-3xl shadow p-8">
                <h2 class="text-2xl font-bold text-center">
                    Buku Tamu & Ucapan
                </h2>

                <p class="text-gray-600 text-center mt-2">
                    Kirim doa, ucapan, atau konfirmasi kehadiran untuk acara ini.
                </p>

                @if (session('message_success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded-xl mt-6">
                        {{ session('message_success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded-xl mt-6">
                        <p class="font-bold">Mohon periksa kembali isian:</p>
                        <ul class="list-disc ml-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                    action="{{ route('guest-messages.store', $invitation) }}"
                    class="mt-8 space-y-4">
                    @csrf

                    <div>
                        <label class="uk-label">Nama Tamu</label>
                        <input type="text"
                            name="guest_name"
                            value="{{ old('guest_name') }}"
                            class="uk-input mt-1"
                            placeholder="Tulis nama kamu"
                            required>
                    </div>

                    <div>
                        <label class="uk-label">Status Kehadiran</label>
                        <select name="attendance_status"
                                class="uk-input mt-1">
                            <option value="">Pilih status kehadiran</option>
                            <option value="hadir" {{ old('attendance_status') === 'hadir' ? 'selected' : '' }}>
                                Hadir
                            </option>
                            <option value="tidak_hadir" {{ old('attendance_status') === 'tidak_hadir' ? 'selected' : '' }}>
                                Tidak Hadir
                            </option>
                            <option value="ragu" {{ old('attendance_status') === 'ragu' ? 'selected' : '' }}>
                                Masih Ragu
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="uk-label">Jumlah Tamu</label>
                        <input type="number"
                            name="guest_count"
                            value="{{ old('guest_count', 1) }}"
                            min="1"
                            max="10"
                            class="uk-input mt-1">
                    </div>

                    <div>
                        <label class="uk-label">Ucapan / Doa</label>
                        <textarea name="message"
                                rows="4"
                                class="uk-input mt-1"
                                placeholder="Tulis ucapan atau doa terbaik..."
                                required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-purple-600 text-white py-3 rounded-xl">
                        Kirim Ucapan
                    </button>
                </form>

                <div class="mt-10">
                    <h3 class="text-xl font-bold mb-4">
                        Ucapan Tamu
                    </h3>

                    <div class="space-y-4">
                        @forelse ($invitation->messages as $message)
                            <div class="bg-gray-50 rounded-2xl p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h4 class="font-bold">
                                            {{ $message->guest_name }}
                                        </h4>

                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="text-xs px-3 py-1 rounded-full
                                            @if ($message->attendance_status === 'hadir')
                                                bg-green-100 text-green-700
                                            @elseif ($message->attendance_status === 'tidak_hadir')
                                                bg-red-100 text-red-700
                                            @else
                                                bg-yellow-100 text-yellow-700
                                            @endif
                                        ">
                                            @if ($message->attendance_status === 'hadir')
                                                Hadir
                                            @elseif ($message->attendance_status === 'tidak_hadir')
                                                Tidak Hadir
                                            @else
                                                Ragu
                                            @endif
                                        </span>
                                    @endif
                                </div>

                                <p class="text-gray-700 mt-4">
                                    {{ $message->message }}
                                </p>

                                @if ($message->attendance_status === 'hadir')
                                    <p class="text-sm text-gray-500 mt-3">
                                        Jumlah tamu: {{ $message->guest_count }} orang
                                    </p>
                                @endif
                            </div>
                        @empty
                            <div class="bg-gray-50 rounded-2xl p-6 text-center">
                                <p class="text-gray-600">
                                    Belum ada ucapan. Jadilah yang pertama mengirim ucapan.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
