<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm text-slate-500 font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
                        @if($product)
                            <a href="{{ route('umkms.show', $product->umkm) }}" class="hover:text-indigo-600 transition-colors">{{ $product->umkm->name }}</a>
                        @elseif($umkm)
                            <a href="{{ route('umkms.show', $umkm) }}" class="hover:text-indigo-600 transition-colors">{{ $umkm->name }}</a>
                        @endif
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
                        <span class="text-slate-800">Laporkan</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-slate-100 bg-red-50 flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-flag"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-800">Laporkan Konten</h1>
                    <p class="text-sm text-slate-500 mt-0.5">
                        @if($product)
                            Produk: <span class="font-semibold text-slate-700">{{ $product->name }}</span> — {{ $product->umkm->name }}
                        @elseif($umkm)
                            UMKM: <span class="font-semibold text-slate-700">{{ $umkm->name }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('reports.store') }}" class="p-6 space-y-6">
                @csrf
                @if($product)
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="umkm_id" value="{{ $product->umkm_id }}">
                @elseif($umkm)
                    <input type="hidden" name="umkm_id" value="{{ $umkm->id }}">
                @endif

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Kategori Laporan <span class="text-red-500">*</span>
                    </label>
                    <select id="category" name="category" required
                        class="block w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-red-200 focus:border-red-400 transition-colors {{ $errors->has('category') ? 'border-red-400' : '' }}">
                        <option value="">Pilih kategori...</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Deskripsi Laporan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="5" required minlength="20" maxlength="1000"
                        placeholder="Jelaskan secara detail mengapa konten ini melanggar. Semakin detail, semakin mudah bagi tim kami untuk menindaklanjuti laporan Anda."
                        class="block w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-red-200 focus:border-red-400 transition-colors resize-none {{ $errors->has('description') ? 'border-red-400' : '' }}">{{ old('description') }}</textarea>
                    <div class="flex justify-between items-center mt-1">
                        @error('description')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @else
                            <p class="text-slate-400 text-xs">Minimal 20 karakter.</p>
                        @enderror
                        <p class="text-slate-400 text-xs ml-auto" id="char-count">0 / 1000</p>
                    </div>
                </div>

                <!-- Warning Notice -->
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5 shrink-0"></i>
                    <p class="text-xs text-amber-700 leading-relaxed">
                        Laporan palsu atau penyalahgunaan fitur ini dapat mengakibatkan pemblokiran akun Anda. Pastikan laporan yang Anda ajukan memiliki alasan yang valid.
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-2">
                    @if($product)
                        <a href="{{ route('products.show', $product) }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                            <i class="fa-solid fa-arrow-left mr-1"></i> Batal
                        </a>
                    @elseif($umkm)
                        <a href="{{ route('umkms.show', $umkm) }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                            <i class="fa-solid fa-arrow-left mr-1"></i> Batal
                        </a>
                    @endif
                    <button type="submit" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-sm shadow-red-200">
                        <i class="fa-solid fa-flag"></i> Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const textarea = document.getElementById('description');
        const counter = document.getElementById('char-count');
        textarea.addEventListener('input', () => {
            counter.textContent = `${textarea.value.length} / 1000`;
        });
    </script>
</x-app-layout>
