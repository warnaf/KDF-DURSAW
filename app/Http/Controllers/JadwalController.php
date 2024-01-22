<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;

class JadwalController extends Controller
{
    public function viewGenerate() : View {
        return view('generateView');
    }

    //fungsi untuk mencari index dari value yang ingin dicari
    static function findIndexInArray(array $dataArray, int $wannaFound) : int {
        foreach ($dataArray as $key => $value) {
            if($value['id'] == $wannaFound){
                return $key;
            }
        }
    }

    //fungsi untuk mencari data mengajar yang masih memiliki jam mengajar
    static function peelingIdFromArray($arrayData, $maksimalJam = 0) : array | bool  {
        $hasil = [];

        foreach ($arrayData as $key => $value) {
            if($value == null){
                Log::critical("ada yang null", $value);
            }

            if($maksimalJam != 0){
                if($value['max_jam'] == $maksimalJam &&  $value['jumlah_jam'] > 0 ){
                    $hasil[] = $value['id'];
                }
            }
            // else{
            //     if($value['jumlah_jam'] > 0){
            //         $hasil[] = $value['id'];
            //     }
            // }
        }
        return count($hasil) > 0 ? $hasil : false;
    }

    //fungsi untuk mengelompokan data berdasarkan jenjangnya
    static function cleanData($data) : array {
        $tmp = [
            '7' => [
                // '1' => [],
                // '2' => [],
            ], '8' => [
                // '1' => [],
                // '2' => [],
            ],'9' => [
                // '1' => [],
                // '2' => [],
            ],'10' => [
                // '1' => [],
                // '2' => [],
            ],'11' => [
                // '1' => [],
                // '2' => [],
            ],'12' => [
                // '1' => [],
                // '2' => [],
            ]
        ];

        foreach ($data as $key => $value) {
            switch ($value['jenjang']) {
                case '7':
                    if($value['semester'] == 1){
                        array_push($tmp['7'], $value);
                    }
                    // else{
                    //     array_push($tmp['7']['2'], $value);
                    // }
                    break;
                case '8':
                    if($value['semester'] == 1){
                        array_push($tmp['8'], $value);
                    }
                    // else{
                    //     array_push($tmp['8']['2'], $value);
                    // }
                    break;
                case '9':
                    if($value['semester'] == 1){
                        array_push($tmp['9'], $value);
                    }
                    // else{
                    //     array_push($tmp['9']['2'], $value);
                    // }
                    break;
                case '10':
                    if($value['semester'] == 1){
                        array_push($tmp['10'], $value);
                    }
                    // else{
                    //     array_push($tmp['10']['2'], $value);
                    // }
                    break;
                case '11':
                    if($value['semester'] == 1){
                        array_push($tmp['11'], $value);
                    }
                    // else{
                    //     array_push($tmp['11']['2'], $value);
                    // }
                    break;
                case '12':
                    if($value['semester'] == 1){
                        array_push($tmp['12'], $value);
                    }
                    // else{
                    //     array_push($tmp['12']['2'], $value);
                    // }
                    break;
            }
        }
        ksort($tmp, SORT_NUMERIC);
        return $tmp;
    }

    //fungsi untuk memeriksa apakah pada jadwal per hari masih memiliki kolom yang belum di isi
    static function checkIsCompleted($jadwal) : bool | array{
        $isCompleted = true;
        $indexThatNotCompleted = [];
        for ($i=0; $i < count($jadwal); $i++) {  // vertical
            for ($j=0; $j < count($jadwal[$i]); $j++) {  // horizontal
                if($jadwal[$i][$j] === 'BELAJAR'){
                    $indexThatNotCompleted[] = ['Y' => $i, 'X' => $j];
                }
            }
        }

        if(count($indexThatNotCompleted) > 0){
            $isCompleted = false;
        }
        return $isCompleted ? $isCompleted : $indexThatNotCompleted;
    }

    //fungsi untuk membuat jadwal
    static function createJadwal() : array {
        $model = new Jadwal();
        $data = $model->data_mengajar;
        $cleanData = self::cleanData($data);
        $totalJam = 14;
        $kelas = $model->data_kelas;
        $kelasKey = array_keys($kelas);
        $totalKelas = 0;
        $fullJadwal = [
            'Senin' => [],
            'Selasa' => [],
            'Rabu' => [],
            'Kamis' => [],
            'Jumat' => [],
        ];
        $fullJadwalKeys = array_keys($fullJadwal);
        for ($i=0; $i < count($kelas); $i++) { 
            $totalKelas += count($kelas[$kelasKey[$i]]);
        }
        for ($a=0; $a < count($fullJadwal); $a++) { 
            $jadwalReady = [];
            for ($i=0; $i < $totalJam; $i++) { 
                $tmp = [];
                for ($j=0; $j < $totalKelas; $j++) { 
                    if ($i == 0) {
                        array_push($tmp, 'MP');
                    }else if($i == 5){
                        array_push($tmp, 'RECESS');
                    }else if($i == 9){
                        array_push($tmp, 'LUNCH');
                    }else if($i == 13){
                        array_push($tmp, 'HR');
                    }else {
                        array_push($tmp, 'BELAJAR');
                    }
                }
                array_push($jadwalReady, $tmp);
            }
            for ($u=0; $u < $totalJam; $u++) {
                $incrementKelas = 0;
                for ($i=0; $i < count($kelas); $i++) { 
                    for ($j=0; $j < count($kelas[$kelasKey[$i]]); $j++) {
                        $currentIdArray = self::peelingIdFromArray($cleanData[$kelasKey[$i]]);
                        if($currentIdArray == false){
                            continue;
                        }
                        $randomId = Jadwal::getRandomId($currentIdArray, $jadwalReady, $u);

                        if($randomId == false){
                            continue;
                        }
                        $randomKey = self::findIndexInArray($cleanData[$kelasKey[$i]], $randomId);
                        $currentArray = &$cleanData[$kelasKey[$i]][$randomKey];
                        $penguranganJamKerja = min($currentArray['jumlah_jam'], $currentArray['max_jam']);
                        $tambahanStep = 0;
                        $tambahanNextStep = 0;
                        for ($k=$u; $k < $penguranganJamKerja + $u + $tambahanNextStep; $k++) {
                            if($k > $totalKelas - 1){
                                break;
                            }

                            if($k === 0){
                                $tambahanNextStep;
                                continue;
                            }else if($k === 5){
                                $tambahanNextStep;
                                continue;
                            }else if($k === 9){
                                $tambahanNextStep;
                                continue;
                            }

                            if($penguranganJamKerja > 1){
                                if($jadwalReady[$k + $tambahanStep][$incrementKelas] !== "BELAJAR"){
                                    $tambahanStep;
                                    $tambahanNextStep;
                                    continue;
                                }
                                $jadwalReady[$k + $tambahanStep][$incrementKelas] = $currentArray['id'];
                                $currentArray['jumlah_jam'] -= 1;
                            }else{
                                if($jadwalReady[$k + $tambahanStep][$incrementKelas] !== "BELAJAR"){
                                    $tambahanStep;
                                    $tambahanNextStep;
                                    continue;
                                }
                                $jadwalReady[$k + $tambahanStep][$incrementKelas] = $currentArray['id'];
                                $currentArray['jumlah_jam'] -= 1;
                                $tambahanStep++;
                                if($jadwalReady[$k + $tambahanStep][$incrementKelas] !== "BELAJAR"){
                                    $tambahanStep;
                                    $tambahanNextStep;
                                    continue;
                                }
                                $sekarangIdArray = self::peelingIdFromArray($cleanData[$kelasKey[$i]], 1);
                                if($sekarangIdArray == false){
                                    continue;
                                }
                                $randomIds = Jadwal::getRandomId($sekarangIdArray, $jadwalReady, $k);

                                if($randomIds == false){
                                    continue;
                                }
                                $randomKeys = self::findIndexInArray($cleanData[$kelasKey[$i]], $randomIds);
                                $differntArr = &$cleanData[$kelasKey[$i]][$randomKeys];
                                $jadwalReady[$k + $tambahanStep][$incrementKelas] = $differntArr['id'];
                                $differntArr['jumlah_jam'] -= 1;
                            }
                        }
                        $incrementKelas++;
                    }
                }
            }
            $isCompleted = self::checkIsCompleted($jadwalReady);
            if($isCompleted !== true){
                $kelasKeyBasis = [];
                for ($i=0; $i < count($kelas); $i++) { 
                    for ($j=0; $j < count($kelas[$kelasKey[$i]]); $j++) {
                        $kelasKeyBasis[] = $kelasKey[$i];
                    }
                }

                for ($i=0; $i < count($isCompleted); $i++) { 
                    $currentY = $isCompleted[$i]['Y'];
                    $currentX = $isCompleted[$i]['X'];
                    $sekarangIdArray = self::peelingIdFromArray($cleanData[$kelasKeyBasis[$currentX]], 1);
                    if($sekarangIdArray == false){
                        continue;
                    }
                    $randomIds = Jadwal::getRandomId($sekarangIdArray, $jadwalReady, $currentY);

                    if($randomIds == false){
                        continue;
                    }
                    $randomKeys = self::findIndexInArray($cleanData[$kelasKeyBasis[$currentX]], $randomIds);
                    $differntArr = &$cleanData[$kelasKeyBasis[$currentX]][$randomKeys];

                    $jadwalReady[$currentY][$currentX] = $differntArr['id'];
                }
            }
            $fullJadwal[$fullJadwalKeys[$a]] = $jadwalReady;
        }
        return $fullJadwal;
        // return ['jadwal' => $fullJadwal, 'sisa' => $cleanData];
    }

    //mengembalikan view dari hasil dari jadwal
    public function generateJadwal() : View {
        $jadwal = self::createJadwal();
        $model = new Jadwal();
        $dataKelas = $model->data_kelas;
        $dataJam = $model->data_jam;
        $kelasKey = array_keys($dataKelas);
        $kelas = [];
        // $hari = [
        //     'Senin',
        //     'Selasa',
        //     'Rabu',
        //     'Kamis',
        //     'Jumat',
        // ];
        for ($i=0; $i < count($dataKelas); $i++) { 
            for ($j=0; $j < count($dataKelas[$kelasKey[$i]]); $j++) {
                $kelas[] = $dataKelas[$kelasKey[$i]][$j];
            }
        }
        return view('createJadwal')->with('data', [
            'jam' => $dataJam,
            'kelas' => $kelas,
            // 'hari' => $hari,
            'jadwal' => $jadwal
        ]);
    }
}
