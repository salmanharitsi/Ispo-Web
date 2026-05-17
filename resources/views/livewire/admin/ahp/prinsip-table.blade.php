<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

    <div class="overflow-x-auto">
        <h3 class="text-lg font-bold text-gray-800 mb-3">Input Matriks Perbandingan Berpasangan Prinsip</h3>
        <table class="w-full text-sm text-left text-gray-700 border-collapse border border-gray-300">
            <thead class="text-xs text-gray-900 bg-gray-200 border-b border-gray-300 uppercase">
                <tr>
                    <th scope="col" class="px-4 py-3 border border-gray-300 font-bold">Prinsip</th>
                    <th scope="col" class="px-4 py-3 border border-gray-300 text-center font-bold">P1</th>
                    <th scope="col" class="px-4 py-3 border border-gray-300 text-center font-bold">P2</th>
                    <th scope="col" class="px-4 py-3 border border-gray-300 text-center font-bold">P3</th>
                    <th scope="col" class="px-4 py-3 border border-gray-300 text-center font-bold">P4</th>
                    <th scope="col" class="px-4 py-3 border border-gray-300 text-center font-bold">P5</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $labels = [
                        'p1' => 'P1 - Kepatuhan & Legalitas',
                        'p2' => 'P2 - Praktik Budidaya',
                        'p3' => 'P3 - Pengelolaan Lingkungan',
                        'p4' => 'P4 - Transparansi',
                        'p5' => 'P5 - Keberlanjutan Usaha',
                    ];
                    $cols = ['p1', 'p2', 'p3', 'p4', 'p5'];
                @endphp
                @foreach ($labels as $rowKey => $rowLabel)
                    <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                        <td class="px-4 py-3 border border-gray-300 font-bold text-gray-900 whitespace-nowrap">
                            {{ $rowLabel }}
                        </td>
                        @foreach ($cols as $colKey)
                            <td class="px-4 py-3 border border-gray-300 text-center min-w-[120px]">
                                <input type="number" step="0.0001" min="0" wire:model.live.debounce.500ms="matrix.{{ $rowKey }}.{{ $colKey }}" 
                                    class="w-24 text-center bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2 mx-auto"
                                    placeholder="0.0000">
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                
                <!-- Jumlah Row -->
                <tr class="bg-gray-200 font-bold text-gray-900">
                    <td class="px-4 py-3 border border-gray-300 font-bold text-right">
                        Jumlah Kolom
                    </td>
                    @foreach ($cols as $colKey)
                        <td class="px-4 py-3 border border-gray-300 text-center">
                            {{ number_format($jumlah[$colKey], 4, ',', '.') }}
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-between items-center">
        <div class="text-sm italic">
            @if(!$isMatrixSavedAndComplete)
                <span class="text-red-500">*</span> Simpan semua data pada tabel untuk dapat menggenerate matriks
            @else
                <span class="text-green-500"><i class="fas fa-check-circle"></i></span> Matriks tersimpan, siap di{{ $isGenerated ? 'regenerate' : 'generate' }}!
            @endif
        </div>
        <div class="flex gap-3 justify-end">
            <button wire:click="generateMatrix" 
                @if(!$isMatrixSavedAndComplete) disabled @endif
                class="disabled:bg-gray-400 disabled:text-gray-200 disabled:cursor-not-allowed bg-green-800 hover:bg-green-950 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 flex items-center">
                <span wire:loading.remove wire:target="generateMatrix">
                    {{ $isGenerated ? 'Regenerate Matriks' : 'Generate Matriks' }}
                </span>
                <span wire:loading wire:target="generateMatrix"><i class="fas fa-spinner fa-spin mr-2"></i> Generating...</span>
            </button>
            <button wire:click="save" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 flex items-center">
                <span wire:loading.remove wire:target="save"><i class="fas fa-save mr-2"></i> Simpan</span>
                <span wire:loading wire:target="save"><i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...</span>
            </button>
        </div>
    </div>

    @if ($isGenerated)
    <div wire:key="generated-tables-{{ $generationId }}" class="mt-12 space-y-10" x-data="{ step: {{ $justGenerated ? 1 : 4 }} }" x-init="{{ $justGenerated ? 'setInterval(function(){ if(step != 4) step++; }, 1500)' : '' }}">
        
        <!-- Tabel 4.2 -->
        <div x-show="step >= 1" x-transition.opacity.duration.500ms>
            <h3 class="text-lg font-bold text-gray-800 mb-3">Normalisasi Matriks Perbandingan Berpasangan Prinsip</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700 border-collapse border border-gray-300">
                    <thead class="text-xs text-gray-900 bg-gray-200 border-b border-gray-300 uppercase">
                        <tr>
                            <th class="px-4 py-3 border border-gray-300 font-bold">Prinsip</th>
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
                                    <td class="px-4 py-3 border border-gray-300 text-center">{{ number_format($norm[$rowKey][$colKey], 4, ',', '.') }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr class="bg-gray-200 font-bold text-gray-900">
                            <td class="px-4 py-3 border border-gray-300 font-bold text-right">JUMLAH</td>
                            @foreach ($cols as $colKey)
                                <td class="px-4 py-3 border border-gray-300 text-center font-bold">{{ number_format($norm_jumlah[$colKey], 0, ',', '.') }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel 4.3 -->
        <div x-show="step >= 2" x-transition.opacity.duration.500ms>
            <h3 class="text-lg font-bold text-gray-800 mb-3">Hasil Perhitungan Bobot Prioritas Prinsip ISPO</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700 border-collapse border border-gray-300">
                    <thead class="text-xs text-gray-900 bg-gray-200 border-b border-gray-300 uppercase">
                        <tr>
                            <th class="px-4 py-3 border border-gray-300 font-bold text-center">Kode</th>
                            <th class="px-4 py-3 border border-gray-300 font-bold">Nama Prinsip</th>
                            <th class="px-4 py-3 border border-gray-300 font-bold text-center">Bobot Prioritas</th>
                            <th class="px-4 py-3 border border-gray-300 font-bold text-center">Bobot (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sumBobot = 0; @endphp
                        @foreach ($labels as $rowKey => $rowLabel)
                            @php $sumBobot += $bobot[$rowKey]; @endphp
                            <tr class="bg-white border-b border-gray-300">
                                <td class="px-4 py-3 border border-gray-300 font-bold text-gray-900 text-center">{{ strtoupper($rowKey) }}</td>
                                <td class="px-4 py-3 border border-gray-300">{{ explode(' - ', $rowLabel)[1] }}</td>
                                <td class="px-4 py-3 border border-gray-300 text-center font-bold">{{ number_format($bobot[$rowKey], 4, ',', '.') }}</td>
                                <td class="px-4 py-3 border border-gray-300 text-center">{{ number_format($bobot[$rowKey] * 100, 2, ',', '.') }}%</td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-200 font-bold text-gray-900">
                            <td colspan="2" class="px-4 py-3 border border-gray-300 text-center">Total</td>
                            <td class="px-4 py-3 border border-gray-300 text-center font-bold">{{ number_format($sumBobot, 4, ',', '.') }}</td>
                            <td class="px-4 py-3 border border-gray-300 text-center font-bold">{{ number_format($sumBobot * 100, 0, ',', '.') }}%</td>
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
                            <th class="px-4 py-3 border border-gray-300 font-bold">PRINSIP</th>
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
                                    <td class="px-4 py-3 border border-gray-300 text-center">{{ number_format($matriks_penjumlahan[$rowKey][$colKey], 4, ',', '.') }}</td>
                                @endforeach
                                <td class="px-4 py-3 border border-gray-300 text-center font-bold bg-gray-50">{{ number_format($jumlah_baris[$rowKey], 4, ',', '.') }}</td>
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
                            <th class="px-4 py-3 border border-gray-300 font-bold text-center">Prinsip</th>
                            <th class="px-4 py-3 border border-gray-300 text-center font-bold">Jumlah Baris</th>
                            <th class="px-4 py-3 border border-gray-300 text-center font-bold">Bobot Prioritas</th>
                            <th class="px-4 py-3 border border-gray-300 text-center font-bold">Nilai (Hasil / Bobot)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($labels as $rowKey => $rowLabel)
                            <tr class="bg-white border-b border-gray-300">
                                <td class="px-4 py-3 border border-gray-300 font-bold text-gray-900 text-center">{{ strtoupper($rowKey) }}</td>
                                <td class="px-4 py-3 border border-gray-300 text-center">{{ number_format($jumlah_baris[$rowKey], 4, ',', '.') }}</td>
                                <td class="px-4 py-3 border border-gray-300 text-center">{{ number_format($bobot[$rowKey], 4, ',', '.') }}</td>
                                <td class="px-4 py-3 border border-gray-300 text-center font-bold">{{ number_format($cv[$rowKey], 3, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
