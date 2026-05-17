<div class="grid grid-cols-1 lg:grid-cols-6 gap-3">
    <!-- Sidebar Tabs -->
    <div class="lg:col-span-1 flex flex-col space-y-3">
        @foreach($prinsipData as $key => $data)
            <button wire:click="switchTab('{{ $key }}')" 
                class="w-full text-left px-4 py-3 rounded-lg shadow-sm transition-all duration-200 flex items-center justify-between border
                @if($activeTab === $key) bg-green-700 text-white font-bold border-green-700
                @else bg-white text-gray-700 hover:bg-gray-50 border-gray-200 @endif">
                <span class="text-sm truncate mr-2">{{ $data['name'] }}</span>
                @if(in_array($key, $completedTabs))
                    <i class="fas fa-check-circle @if($activeTab === $key) text-white @else text-green-500 @endif"></i>
                @else
                    <i class="fas fa-circle @if($activeTab === $key) text-green-400 @else text-gray-300 @endif text-xs"></i>
                @endif
            </button>
        @endforeach
    </div>

    <!-- Content Area -->
    <div class="lg:col-span-5 bg-white p-6 rounded-xl shadow-md border border-gray-100">
        
        <div class="mb-6 border-b border-slate-200 pb-4">
            <h2 class="text-2xl font-bold text-gray-800">
                Kriteria untuk {{ $prinsipData[$activeTab]['name'] }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi matriks perbandingan berpasangan untuk kriteria di bawah ini.</p>
        </div>

        @php
            $cols = array_keys($prinsipData[$activeTab]['criteria']);
            $labels = $prinsipData[$activeTab]['criteria'];
        @endphp

        <!-- Tabel 4.1 -->
        <div class="overflow-x-auto">
            <h3 class="text-lg font-bold text-gray-800 mb-3">Input Matriks Perbandingan Berpasangan Kriteria</h3>
            
            @if(count($cols) == 1)
                <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-lg p-4 mb-4">
                    <p class="font-semibold"><i class="fas fa-info-circle mr-2"></i> Informasi</p>
                    <p class="text-sm mt-1">Prinsip ini hanya memiliki 1 kriteria ({{ $labels[$cols[0]] }}). Tidak diperlukan perbandingan berpasangan. Anda dapat langsung menyimpan dan meng-generate matriks.</p>
                </div>
            @endif

            <table class="w-full text-sm text-left text-gray-700 border-collapse border border-gray-300">
                <thead class="text-xs text-gray-900 bg-gray-200 border-b border-gray-300 uppercase">
                    <tr>
                        <th class="px-4 py-3 border border-gray-300 font-bold">Kriteria</th>
                        @foreach ($cols as $colKey)
                            <th class="px-4 py-3 border border-gray-300 text-center font-bold">{{ strtoupper($colKey) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($labels as $rowKey => $rowLabel)
                        <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                            <td class="px-4 py-3 border border-gray-300 font-bold text-gray-900 min-w-[250px] whitespace-nowrap">
                                {{ $rowLabel }}
                            </td>
                            @foreach ($cols as $colKey)
                                <td class="px-4 py-3 border border-gray-300 text-center min-w-[120px]">
                                    <input type="number" step="0.0001" min="0" 
                                        wire:model.live.debounce.500ms="matrix.{{ $rowKey }}.{{ $colKey }}"
                                        class="w-24 text-center bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2 mx-auto"
                                        placeholder="0.0000">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr class="bg-gray-200 font-bold text-gray-900">
                        <td class="px-4 py-3 border border-gray-300 font-bold text-right">Jumlah Kolom</td>
                        @foreach ($cols as $colKey)
                            <td class="px-4 py-3 border border-gray-300 text-center">
                                {{ number_format($jumlah[$colKey] ?? 0, 4, ',', '.') }}
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <div class="text-sm italic text-center sm:text-left">
                @if(!$isMatrixSavedAndComplete)
                    <span class="text-red-500">*</span> Simpan semua data pada tabel untuk dapat menggenerate matriks
                @else
                    <span class="text-green-500"><i class="fas fa-check-circle"></i></span> Matriks tersimpan, siap di{{ $isGenerated ? 'regenerate' : 'generate' }}!
                @endif
            </div>
            <div class="flex gap-3 justify-end w-full sm:w-auto">
                <button wire:click="generateMatrix" 
                    @if(!$isMatrixSavedAndComplete) disabled @endif
                    class="disabled:bg-gray-400 disabled:text-gray-200 disabled:cursor-not-allowed bg-green-800 hover:bg-green-950 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center justify-center w-full sm:w-auto">
                    <span wire:loading.remove wire:target="generateMatrix">
                        {{ $isGenerated ? 'Regenerate Matriks' : 'Generate Matriks' }}
                    </span>
                    <span wire:loading wire:target="generateMatrix"><i class="fas fa-spinner fa-spin mr-2"></i> Generating...</span>
                </button>
                <button wire:click="save" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center justify-center w-full sm:w-auto">
                    <span wire:loading.remove wire:target="save"><i class="fas fa-save mr-2"></i> Simpan</span>
                    <span wire:loading wire:target="save"><i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...</span>
                </button>
            </div>
        </div>

        @if ($isGenerated)
        <div wire:key="generated-tables-{{ $activeTab }}-{{ $generationId }}" class="mt-12 space-y-10" x-data="{ step: {{ $justGenerated ? 1 : 4 }} }" x-init="{{ $justGenerated ? 'setInterval(function(){ if(step != 4) step++; }, 1500)' : '' }}">
            
            <!-- Tabel 4.2 -->
            <div x-show="step >= 1" x-transition.opacity.duration.500ms>
                <h3 class="text-lg font-bold text-gray-800 mb-3">Normalisasi Matriks Perbandingan Berpasangan Kriteria</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700 border-collapse border border-gray-300">
                        <thead class="text-xs text-gray-900 bg-gray-200 border-b border-gray-300 uppercase">
                            <tr>
                                <th class="px-4 py-3 border border-gray-300 font-bold">Kriteria</th>
                                @foreach ($cols as $colKey)
                                    <th class="px-4 py-3 border border-gray-300 text-center font-bold">{{ strtoupper($colKey) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($labels as $rowKey => $rowLabel)
                                <tr class="bg-white border-b border-gray-300">
                                    <td class="px-4 py-3 border border-gray-300 font-bold text-gray-900">{{ strtoupper($rowKey) }}</td>
                                    @foreach ($cols as $colKey)
                                        <td class="px-4 py-3 border border-gray-300 text-center">{{ number_format($norm[$rowKey][$colKey] ?? 0, 4, ',', '.') }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr class="bg-gray-200 font-bold text-gray-900">
                                <td class="px-4 py-3 border border-gray-300 font-bold text-right">JUMLAH</td>
                                @foreach ($cols as $colKey)
                                    <td class="px-4 py-3 border border-gray-300 text-center font-bold">{{ number_format($norm_jumlah[$colKey] ?? 0, 0, ',', '.') }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel 4.3 -->
            <div x-show="step >= 2" x-transition.opacity.duration.500ms>
                <h3 class="text-lg font-bold text-gray-800 mb-3">Hasil Perhitungan Bobot Prioritas Kriteria</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700 border-collapse border border-gray-300">
                        <thead class="text-xs text-gray-900 bg-gray-200 border-b border-gray-300 uppercase">
                            <tr>
                                <th class="px-4 py-3 border border-gray-300 font-bold text-center w-20">Kode</th>
                                <th class="px-4 py-3 border border-gray-300 font-bold">Nama Kriteria</th>
                                <th class="px-4 py-3 border border-gray-300 font-bold text-center w-40">Bobot Prioritas</th>
                                <th class="px-4 py-3 border border-gray-300 font-bold text-center w-32">Bobot (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $sumBobot = 0; @endphp
                            @foreach ($labels as $rowKey => $rowLabel)
                                @php $sumBobot += $bobot[$rowKey] ?? 0; @endphp
                                <tr class="bg-white border-b border-gray-300">
                                    <td class="px-4 py-3 border border-gray-300 font-bold text-gray-900 text-center">{{ strtoupper($rowKey) }}</td>
                                    <td class="px-4 py-3 border border-gray-300">{{ explode(' - ', $rowLabel)[1] ?? $rowLabel }}</td>
                                    <td class="px-4 py-3 border border-gray-300 text-center font-bold">{{ number_format($bobot[$rowKey] ?? 0, 4, ',', '.') }}</td>
                                    <td class="px-4 py-3 border border-gray-300 text-center">{{ number_format(($bobot[$rowKey] ?? 0) * 100, 2, ',', '.') }}%</td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-200 font-bold text-gray-900">
                                <td colspan="2" class="px-4 py-3 border border-gray-300 text-center">Total</td>
                                <td class="px-4 py-3 border border-gray-300 text-center font-bold">{{ number_format($sumBobot, 4, ',', '.') }}</td>
                                <td class="px-4 py-3 border border-gray-300 text-center font-bold">~{{ number_format($sumBobot * 100, 0, ',', '.') }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel 4.4 -->
            <div x-show="step >= 3" x-transition.opacity.duration.500ms>
                <h3 class="text-lg font-bold text-gray-800 mb-3">Hasil Matriks Penjumlahan Tiap Baris</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700 border-collapse border border-gray-300">
                        <thead class="text-xs text-gray-900 bg-gray-200 border-b border-gray-300 uppercase">
                            <tr>
                                <th class="px-4 py-3 border border-gray-300 font-bold">KRITERIA</th>
                                @foreach ($cols as $colKey)
                                    <th class="px-4 py-3 border border-gray-300 text-center font-bold">{{ strtoupper($colKey) }}</th>
                                @endforeach
                                <th class="px-4 py-3 border border-gray-300 text-center font-bold bg-gray-100">JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($labels as $rowKey => $rowLabel)
                                <tr class="bg-white border-b border-gray-300">
                                    <td class="px-4 py-3 border border-gray-300 font-bold text-gray-900">{{ strtoupper($rowKey) }}</td>
                                    @foreach ($cols as $colKey)
                                        <td class="px-4 py-3 border border-gray-300 text-center">{{ number_format($matriks_penjumlahan[$rowKey][$colKey] ?? 0, 4, ',', '.') }}</td>
                                    @endforeach
                                    <td class="px-4 py-3 border border-gray-300 text-center font-bold bg-gray-50">{{ number_format($jumlah_baris[$rowKey] ?? 0, 4, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel 4.5 -->
            <div x-show="step >= 4" x-transition.opacity.duration.500ms>
                <h3 class="text-lg font-bold text-gray-800 mb-3">Hasil Perhitungan Consistency Vector</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700 border-collapse border border-gray-300">
                        <thead class="text-xs text-gray-900 bg-gray-200 border-b border-gray-300 uppercase">
                            <tr>
                                <th class="px-4 py-3 border border-gray-300 font-bold text-center">Kriteria</th>
                                <th class="px-4 py-3 border border-gray-300 text-center font-bold">Hasil (Jumlah Baris)</th>
                                <th class="px-4 py-3 border border-gray-300 text-center font-bold">Bobot Prioritas</th>
                                <th class="px-4 py-3 border border-gray-300 text-center font-bold">Nilai (Hasil / Bobot)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($labels as $rowKey => $rowLabel)
                                <tr class="bg-white border-b border-gray-300">
                                    <td class="px-4 py-3 border border-gray-300 font-bold text-gray-900 text-center">{{ strtoupper($rowKey) }}</td>
                                    <td class="px-4 py-3 border border-gray-300 text-center">{{ number_format($jumlah_baris[$rowKey] ?? 0, 4, ',', '.') }}</td>
                                    <td class="px-4 py-3 border border-gray-300 text-center">{{ number_format($bobot[$rowKey] ?? 0, 4, ',', '.') }}</td>
                                    <td class="px-4 py-3 border border-gray-300 text-center font-bold">{{ number_format($cv[$rowKey] ?? 0, 4, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
