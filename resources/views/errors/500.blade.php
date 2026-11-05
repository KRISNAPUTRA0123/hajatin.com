@include('errors.layout', [
    'code' => '500',
    'icon' => '!',
    'badge' => 'Server Error',
    'title' => 'Terjadi Kesalahan Server',
    'message' => 'Maaf, sistem sedang mengalami gangguan. Silakan coba beberapa saat lagi atau hubungi admin jika masalah terus terjadi.'
])
