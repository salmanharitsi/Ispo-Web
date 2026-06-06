<div>
    @if (!$canGenerate)
        <div class="mb-6 p-4 rounded-lg border bg-yellow-50 border-yellow-400 text-yellow-800 flex items-start shadow-sm">
            <div class="mr-3 mt-0.5">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
            </div>
            <div class="flex-1">
                <p class="font-bold mb-1">Prasyarat Belum Terpenuhi:</p>
                <div class="text-sm">
                    <p>Untuk dapat melakukan generate pembobotan final, Anda harus menyelesaikan tahapan sebelumnya secara berurutan:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>
                            Pembobotan Prinsip 
                            @if($prinsipGenerated) 
                                <span class="text-green-600 font-bold ml-1">(&check; Selesai)</span> 
                            @else 
                                <span class="text-red-600 font-bold ml-1">(&times; Belum)</span> 
                                <a href="{{ url('/admin/ahp/prinsip') }}" class="underline font-semibold ml-2 hover:text-yellow-900">Lengkapi Sekarang &rarr;</a> 
                            @endif
                        </li>
                        <li>
                            Pembobotan Kriteria (semua 5 prinsip) 
                            @if($kriteriaGenerated) 
                                <span class="text-green-600 font-bold ml-1">(&check; Selesai)</span> 
                            @else 
                                <span class="text-red-600 font-bold ml-1">(&times; {{ $kriteriaGeneratedCount }}/5 Selesai)</span> 
                                <a href="{{ url('/admin/ahp/kriteria') }}" class="underline font-semibold ml-2 hover:text-yellow-900">Lengkapi Sekarang &rarr;</a> 
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center bg-gray-50/50">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Tabel Pembobotan Final</h2>
                <p class="text-sm text-gray-500 mt-1 font-mono bg-white p-1.5 px-3 rounded border border-gray-200 inline-block">Bobot Soal = w_P &times; w_K / n</p>
            </div>
            
            <button 
                wire:click="generateFinalWeights" 
                @if(!$canGenerate) disabled @endif
                class="mt-4 sm:mt-0 disabled:bg-gray-400 disabled:text-gray-200 disabled:cursor-not-allowed bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center justify-center w-full sm:w-auto min-w-[160px]">
                
                <span wire:loading.remove wire:target="generateFinalWeights">
                    <i class="fas fa-sync-alt mr-2"></i> {{ $isGenerated ? 'Regenerate Bobot' : 'Generate Bobot' }}
                </span>
                <span wire:loading wire:target="generateFinalWeights"><i class="fas fa-spinner fa-spin mr-2"></i> Generating...</span>
            </button>
        </div>
        
        @if($isGenerated)
        <div class="p-6">
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm text-left text-gray-700 border-collapse">
                    <thead class="text-xs text-gray-900 bg-gray-100 border-b border-gray-200 uppercase">
                        <tr>
                            <th class="px-4 py-3 border-r border-gray-200 text-center w-12">No</th>
                            <th class="px-4 py-3 border-r border-gray-200">Pertanyaan Singkat</th>
                            <th class="px-4 py-3 border-r border-gray-200 text-center w-16" title="Kode Prinsip">P</th>
                            <th class="px-4 py-3 border-r border-gray-200 text-center w-20" title="Kode Kriteria">K</th>
                            <th class="px-4 py-3 border-r border-gray-200 text-center w-24" title="Bobot Prioritas Prinsip">w_P</th>
                            <th class="px-4 py-3 border-r border-gray-200 text-center w-24" title="Bobot Prioritas Kriteria">w_K</th>
                            <th class="px-4 py-3 border-r border-gray-200 text-center w-16" title="Jumlah Soal dalam Kriteria">n</th>
                            <th class="px-4 py-3 text-center w-32">Bobot Soal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalBobot = 0;
                            $groups = [
                                'p1' => ['name' => 'PRINSIP 1 — Legalitas', 'q_start' => 1, 'q_end' => 7],
                                'p2' => ['name' => 'PRINSIP 2 — Praktik Budidaya', 'q_start' => 8, 'q_end' => 24],
                                'p3' => ['name' => 'PRINSIP 3 — Lingkungan', 'q_start' => 25, 'q_end' => 28],
                                'p4' => ['name' => 'PRINSIP 4 — Transparansi', 'q_start' => 29, 'q_end' => 32],
                                'p5' => ['name' => 'PRINSIP 5 — Keberlanjutan', 'q_start' => 33, 'q_end' => 33],
                            ];
                        @endphp

                        @foreach($groups as $pCode => $group)
                            @php
                                $wP = $prinsipBobots[$pCode] ?? 0;
                            @endphp
                            <!-- Group Header -->
                            <tr class="bg-blue-50/50 border-b border-gray-200">
                                <td colspan="8" class="px-4 py-2 text-sm font-bold text-blue-900">
                                    {{ $group['name'] }} (w={{ number_format($wP, 4, ',', '.') }})
                                </td>
                            </tr>
                            
                            @php
                                $subTotal = 0;
                            @endphp

                            @for($i = $group['q_start']; $i <= $group['q_end']; $i++)
                                @php
                                    $qId = 'q'.$i;
                                    $qData = $questions[$qId];
                                    $wK = $kriteriaBobots[$qData['p']][$qData['k']] ?? 0;
                                    $bobotSoal = round($finalBobots[$qId] ?? 0, 4);
                                    $subTotal += $bobotSoal;
                                    $totalBobot += $bobotSoal;
                                @endphp
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-2 border-r border-gray-200 text-center font-medium">Q{{ $i }}</td>
                                    <td class="px-4 py-2 border-r border-gray-200 text-gray-800">{{ $qData['text'] }}</td>
                                    <td class="px-4 py-2 border-r border-gray-200 text-center font-mono text-xs">{{ strtoupper($qData['p']) }}</td>
                                    <td class="px-4 py-2 border-r border-gray-200 text-center font-mono text-xs">K{{ substr($qData['p'], 1) }}.{{ substr($qData['k'], 1) }}</td>
                                    <td class="px-4 py-2 border-r border-gray-200 text-center">{{ number_format($wP, 4, ',', '.') }}</td>
                                    <td class="px-4 py-2 border-r border-gray-200 text-center">{{ number_format($wK, 4, ',', '.') }}</td>
                                    <td class="px-4 py-2 border-r border-gray-200 text-center">{{ $qData['n'] }}</td>
                                    <td class="px-4 py-2 text-center font-bold text-blue-700 bg-blue-50/30">{{ number_format($bobotSoal, 4, ',', '.') }}</td>
                                </tr>
                            @endfor

                            <!-- Subtotal -->
                            <tr class="bg-gray-50 border-b border-gray-300 font-semibold">
                                <td colspan="7" class="px-4 py-2 text-right text-gray-700">Sub-total {{ strtoupper($pCode) }}</td>
                                <td class="px-4 py-2 text-center text-gray-900 bg-gray-100/50">{{ number_format($subTotal, 4, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        <!-- Grand Total -->
                        <tr class="bg-gray-200 border-b border-gray-300 font-bold text-gray-900">
                            <td colspan="7" class="px-4 py-3 text-right text-sm uppercase">Total Semua 33 Soal</td>
                            <td class="px-4 py-3 text-center text-sm flex items-center justify-center gap-1">
                                {{ number_format($totalBobot, 4, ',', '.') }} 
                                @if(abs($totalBobot - 1.0) < 0.001)
                                    <i class="fas fa-check-circle text-green-600 ml-1" title="Valid"></i>
                                @else
                                    <i class="fas fa-exclamation-circle text-yellow-600 ml-1" title="Total tidak persis 1.0"></i>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="p-12 flex flex-col items-center justify-center text-center">
            <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-table text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Data Pembobotan Final</h3>
            <p class="text-gray-500 max-w-sm">Klik tombol "Generate Bobot" di atas untuk mulai menghitung bobot final per pertanyaan berdasarkan data AHP Prinsip dan Kriteria.</p>
        </div>
        @endif
    </div>
</div>
