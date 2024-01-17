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
    static function peelingIdFromArray($arrayData) : array | bool  {
        $hasil = [];

        foreach ($arrayData as $key => $value) {
            if($value == null){
                Log::critical("ada yang null", $value);
            }
            
            if($value['jumlah_jam'] > 0 ){
                $hasil[] = $value['id'];
            }
        }
        return count($hasil) > 0 ? $hasil : false;
    }

    //fungsi untuk mengelompokan data berdasarkan jenjangnya
    static function cleanDataOld($data) : array {
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

    //clean data new version
    static function cleanData($data) : array {
        $model = new Jadwal();
        $readyData = [];
        $jenjangKelas = $model->data_kelas;
        foreach ($jenjangKelas as $keyJenjang => $valueJenjang) {
            foreach ($valueJenjang as $valueKelas) {
                $readyData[$valueKelas] = [];
            }
        }
        foreach ($data as $value) {
            if($value['is_penjuruan'] == 0){
                foreach ($value['kelas'] as $valueKelas) {
                    $currentKelas = $valueKelas;
                    $readyData[$currentKelas][] = $value;
                }
            }
        }
        ksort($readyData, SORT_NUMERIC);
        return $readyData;
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
    // static function createJadwalOld() : array {
    //     $model = new Jadwal();
    //     $data = $model->data_mengajar;
    //     $cleanData = self::cleanData($data);
    //     $totalJam = 14;
    //     $kelas = $model->data_kelas;
    //     $kelasKey = array_keys($kelas);
    //     $totalKelas = 0;
    //     $fullJadwal = [
    //         'Senin' => [],
    //         'Selasa' => [],
    //         'Rabu' => [],
    //         'Kamis' => [],
    //         'Jumat' => [],
    //     ];
    //     $fullJadwalKeys = array_keys($fullJadwal);
    //     for ($i=0; $i < count($kelas); $i++) { 
    //         $totalKelas += count($kelas[$kelasKey[$i]]);
    //     }
    //     for ($a=0; $a < count($fullJadwal); $a++) { 
    //         $jadwalReady = [];
    //         for ($i=0; $i < $totalJam; $i++) { 
    //             $tmp = [];
    //             for ($j=0; $j < $totalKelas; $j++) { 
    //                 if($a == 4 && $i == 8){
    //                     array_push($tmp, 'PRAY');
    //                 }

    //                 if ($i == 0) {
    //                     array_push($tmp, 'MP');
    //                 }else if($i == 5){
    //                     array_push($tmp, 'RECESS');
    //                 }else if($i == 9){
    //                     array_push($tmp, 'LUNCH');
    //                 }else if($i == 13){
    //                     array_push($tmp, 'DISMISSAL');
    //                 }else {
    //                     array_push($tmp, 'BELAJAR');
    //                 }
    //             }
    //             array_push($jadwalReady, $tmp);
    //         }
    //         for ($u=0; $u < $totalJam; $u++) {
    //             $incrementKelas = 0;
    //             for ($i=0; $i < count($kelas); $i++) { 
    //                 for ($j=0; $j < count($kelas[$kelasKey[$i]]); $j++) {
    //                     $currentIdArray = self::peelingIdFromArray($cleanData[$kelasKey[$i]]);
    //                     if($currentIdArray == false){
    //                         continue;
    //                     }
    //                     $randomId = Jadwal::getRandomId($currentIdArray, $jadwalReady, $u);

    //                     if($randomId == false){
    //                         continue;
    //                     }
    //                     $randomKey = self::findIndexInArray($cleanData[$kelasKey[$i]], $randomId);
    //                     $currentArray = &$cleanData[$kelasKey[$i]][$randomKey];
    //                     $penguranganJamKerja = min($currentArray['jumlah_jam'], $currentArray['max_jam']);
    //                     $tambahanStep = 0;
    //                     $tambahanNextStep = 0;
    //                     for ($k=$u; $k < $penguranganJamKerja + $u + $tambahanNextStep; $k++) {
    //                         if($k > $totalKelas - 1){
    //                             break;
    //                         }

    //                         if($k === 0){
    //                             $tambahanNextStep;
    //                             continue;
    //                         }else if($k === 5){
    //                             $tambahanNextStep;
    //                             continue;
    //                         }else if($k === 9){
    //                             $tambahanNextStep;
    //                             continue;
    //                         }

    //                         if($penguranganJamKerja > 1){
    //                             if($jadwalReady[$k + $tambahanStep][$incrementKelas] !== "BELAJAR"){
    //                                 $tambahanStep;
    //                                 $tambahanNextStep;
    //                                 continue;
    //                             }
    //                             $jadwalReady[$k + $tambahanStep][$incrementKelas] = $currentArray['id'];
    //                             $currentArray['jumlah_jam'] -= 1;
    //                         }else{
    //                             if($jadwalReady[$k + $tambahanStep][$incrementKelas] !== "BELAJAR"){
    //                                 $tambahanStep;
    //                                 $tambahanNextStep;
    //                                 continue;
    //                             }
    //                             $jadwalReady[$k + $tambahanStep][$incrementKelas] = $currentArray['id'];
    //                             $currentArray['jumlah_jam'] -= 1;
    //                             $tambahanStep++;
    //                             if($jadwalReady[$k + $tambahanStep][$incrementKelas] !== "BELAJAR"){
    //                                 $tambahanStep;
    //                                 $tambahanNextStep;
    //                                 continue;
    //                             }
    //                             $sekarangIdArray = self::peelingIdFromArray($cleanData[$kelasKey[$i]], 1);
    //                             if($sekarangIdArray == false){
    //                                 continue;
    //                             }
    //                             $randomIds = Jadwal::getRandomId($sekarangIdArray, $jadwalReady, $k);

    //                             if($randomIds == false){
    //                                 continue;
    //                             }
    //                             $randomKeys = self::findIndexInArray($cleanData[$kelasKey[$i]], $randomIds);
    //                             $differntArr = &$cleanData[$kelasKey[$i]][$randomKeys];
    //                             $jadwalReady[$k + $tambahanStep][$incrementKelas] = $differntArr['id'];
    //                             $differntArr['jumlah_jam'] -= 1;
    //                         }
    //                     }
    //                     $incrementKelas++;
    //                 }
    //             }
    //         }
    //         $isCompleted = self::checkIsCompleted($jadwalReady);
    //         if($isCompleted !== true){
    //             $kelasKeyBasis = [];
    //             for ($i=0; $i < count($kelas); $i++) { 
    //                 for ($j=0; $j < count($kelas[$kelasKey[$i]]); $j++) {
    //                     $kelasKeyBasis[] = $kelasKey[$i];
    //                 }
    //             }

    //             for ($i=0; $i < count($isCompleted); $i++) { 
    //                 $currentY = $isCompleted[$i]['Y'];
    //                 $currentX = $isCompleted[$i]['X'];
    //                 $sekarangIdArray = self::peelingIdFromArray($cleanData[$kelasKeyBasis[$currentX]], 1);
    //                 if($sekarangIdArray == false){
    //                     continue;
    //                 }
    //                 $randomIds = Jadwal::getRandomId($sekarangIdArray, $jadwalReady, $currentY);

    //                 if($randomIds == false){
    //                     continue;
    //                 }
    //                 $randomKeys = self::findIndexInArray($cleanData[$kelasKeyBasis[$currentX]], $randomIds);
    //                 $differntArr = &$cleanData[$kelasKeyBasis[$currentX]][$randomKeys];

    //                 $jadwalReady[$currentY][$currentX] = $differntArr['id'];
    //             }
    //         }
    //         $fullJadwal[$fullJadwalKeys[$a]] = $jadwalReady;
    //     }
    //     return $fullJadwal;
    //     // return ['jadwal' => $fullJadwal, 'sisa' => $cleanData];
    // }

    // static function createJadwal() {
    //     $model = new Jadwal();
    //     $data = $model->data_mengajar;
    //     $cleanData = self::cleanData($data);
    //     $totalJam = 14;
    //     $MAX_JAM = 2;
    //     $kelas = $model->data_kelas;
    //     $kelasKey = array_keys($kelas);
    //     $totalKelas = 0;
    //     $fullJadwal = [
    //         'Senin' => [],
    //         'Selasa' => [],
    //         'Rabu' => [],
    //         'Kamis' => [],
    //         'Jumat' => [],
    //     ];
    //     $fullJadwalKeys = array_keys($fullJadwal);
    //     for ($i=0; $i < count($kelas); $i++) { 
    //         $totalKelas += count($kelas[$kelasKey[$i]]);
    //     }
    //     for ($hari=0; $hari < count($fullJadwal); $hari++) { 
    //         $jadwalReady = [];
    //         for ($i=0; $i < $totalJam; $i++) { 
    //             $tmp = [];
    //             for ($j=0; $j < $totalKelas; $j++) { 
    //                 if($hari == 4 && $i == 8){
    //                     array_push($tmp, 'PRAY');
    //                 }else if ($i == 0) {
    //                     array_push($tmp, 'MP');
    //                 }else if($i == 5){
    //                     array_push($tmp, 'RECESS');
    //                 }else if($i == 9){
    //                     array_push($tmp, 'LUNCH');
    //                 }else if($i == 13){
    //                     array_push($tmp, 'DISMISSAL');
    //                 }else {
    //                     array_push($tmp, 'BELAJAR');
    //                 }
    //             }
    //             array_push($jadwalReady, $tmp);
    //         }
    //         for ($jamBelajar=0; $jamBelajar < $totalJam; $jamBelajar++) {
    //             $incrementKelas = 0;
    //             for ($jenjang=0; $jenjang < count($kelas); $jenjang++) { 
    //                 $kelasAtJenjang = $kelas[$kelasKey[$jenjang]];
    //                 for ($perKelas=0; $perKelas < count($kelas[$kelasKey[$jenjang]]); $perKelas++) {
    //                     $currentIdArray = self::peelingIdFromArray($cleanData[$kelasKey[$jenjang]][$kelasAtJenjang[$perKelas]]);
    //                     if($currentIdArray == false){
    //                         continue;
    //                     }
    //                     $randomId = Jadwal::getRandomId($currentIdArray, $jadwalReady, $jamBelajar);
    //                     if($randomId === false){
    //                         continue;
    //                     }
    //                     $randomKey = self::findIndexInArray($cleanData[$kelasKey[$jenjang]][$kelasAtJenjang[$perKelas]], $randomId);
    //                     $currentMapelGuru = &$cleanData[$kelasKey[$jenjang]][$kelasAtJenjang[$perKelas]][$randomKey];
    //                     $penguranganJamKerja = min($currentMapelGuru['jumlah_jam'], $MAX_JAM);
    //                     $tambahanNextStep = 0;
    //                     for ($k=$jamBelajar; $k < $penguranganJamKerja + $jamBelajar + $tambahanNextStep ; $k++) {
    //                         if($k > $totalKelas - 1){
    //                             break;
    //                         }

    //                         if($jadwalReady[$k + $tambahanNextStep][$incrementKelas] !== "BELAJAR"){
    //                             $tambahanNextStep;
    //                             $tambahanNextStep;
    //                             continue;
    //                         }

    //                         $jadwalReady[$k + $tambahanNextStep][$incrementKelas] = $currentMapelGuru['id'];
    //                         $currentMapelGuru['jumlah_jam'] -= 1;
    //                     }
    //                     $incrementKelas++;
    //                 }
    //             }
    //         }
    //         $fullJadwal[$fullJadwalKeys[$hari]] = $jadwalReady;
    //     }
    //     return $fullJadwal;
    //     // return ['jadwal' => $fullJadwal, 'sisa' => $cleanData];
    // }

    static function createJadwalTest() : array {
        $model = new Jadwal();
        $data = $model->data_mengajar;
        $cleanData = self::cleanData($data);
        $totalJam = 14;
        $kelas = $model->data_kelas;
        $kelasKey = [];
        $kelasData = array_keys($cleanData);
        $totalKelas = 0;
        $fullJadwal = [
            'Senin' => [],
            'Selasa' => [],
            'Rabu' => [],
            'Kamis' => [],
            'Jumat' => [],
        ];
        $fullJadwalKeys = array_keys($fullJadwal);
            foreach ($kelas as $value) {
                foreach ($value as $isi) {
                    $kelasKey[] = $isi;
                    $totalKelas++;
                }
            }
        for ($a=0; $a < count($fullJadwal); $a++) { 
            $jadwalReady = [];
            for ($i=0; $i < $totalJam; $i++) { 
                $tmp = [];
                for ($j=0; $j < $totalKelas; $j++) { 
                    if($a == 4 && $i == 8){
                        array_push($tmp, 'PRAY');
                    }else if ($i == 0) {
                        array_push($tmp, 'MP');
                    }else if($i == 5){
                        array_push($tmp, 'RECESS');
                    }else if($i == 9){
                        array_push($tmp, 'LUNCH');
                    }else if($i == 13){
                        array_push($tmp, 'DISMISSAL');
                    }else {
                        array_push($tmp, 'BELAJAR');
                    }
                }
                array_push($jadwalReady, $tmp);
            }
            for ($u=0; $u < $totalJam; $u++) {
                $incrementKelas = 0;
                if($u === 0){
                    continue;
                }else if($u === 5){
                    continue;
                }else if($u === 9){
                    continue;
                }
                for ($j=0; $j < count($kelasKey); $j++) {
                    $tambahCheckStep = 0;
                    $currentIdArray = self::peelingIdFromArray($cleanData[$kelasData[$j]]);
                    if($currentIdArray === false){
                        $incrementKelas++;
                        continue;
                    }
                    if($jadwalReady[$u][$incrementKelas] !== "BELAJAR"){
                        $tambahCheckStep++;
                    }
                    if($u + $tambahCheckStep >= $totalKelas) $tambahCheckStep = 0;
                    $randomId = Jadwal::getRandomId($currentIdArray, $jadwalReady, ($u + $tambahCheckStep), $incrementKelas);
                    Log::info([
                        "randomId" => $randomId,
                        "currentIdArray" => $currentIdArray,
                        "u" => $u,
                        "tambahCheckStep" => $tambahCheckStep,
                        "u + tambahCheckStep" => $u + $tambahCheckStep,
                        "incrementKelas" => $incrementKelas,
                    ]);
                    if($randomId === false){
                        $incrementKelas++;
                        continue;
                    }
                    $randomKey = self::findIndexInArray($cleanData[$kelasData[$j]], $randomId);
                    $currentArray = &$cleanData[$kelasData[$j]][$randomKey];
                    $penguranganJamKerja = min($currentArray['jumlah_jam'], 2);
                    for ($k=$u; $k < ($penguranganJamKerja + $u + $tambahCheckStep); $k++) {
                        if($k >= $totalKelas){
                            break;
                        }
                        if($jadwalReady[$k][$incrementKelas] !== "BELAJAR"){
                            continue;
                        }
                        $jadwalReady[$k][$incrementKelas] = $currentArray['id'];
                        $currentArray['jumlah_jam'] -= 1;
                    }
                    $incrementKelas++;
                }
            }
            // $isCompleted = self::checkIsCompleted($jadwalReady);
            // if($isCompleted !== true){
            //     $kelasKeyBasis = [];
            //     for ($j=0; $j < count($kelasKey); $j++) {
            //         $kelasKeyBasis[] = $kelasKey[$j];
            //     }

            //     for ($i=0; $i < count($isCompleted); $i++) { 
            //         $currentY = $isCompleted[$i]['Y'];
            //         $currentX = $isCompleted[$i]['X'];
            //         $sekarangIdArray = self::peelingIdFromArray($cleanData[$kelasKeyBasis[$currentX]]);
            //         if($sekarangIdArray == false){
            //             continue;
            //         }
            //         $randomIds = Jadwal::getRandomId($sekarangIdArray, $jadwalReady, $currentY, $currentX);

            //         if($randomIds == false){
            //             continue;
            //         }
            //         $randomKeys = self::findIndexInArray($cleanData[$kelasKeyBasis[$currentX]], $randomIds);
            //         $differntArr = &$cleanData[$kelasKeyBasis[$currentX]][$randomKeys];

            //         $jadwalReady[$currentY][$currentX] = $differntArr['id'];
            //     }
            // }
            $fullJadwal[$fullJadwalKeys[$a]] = $jadwalReady;
        }
        return $fullJadwal;
        // return ['jadwal' => $fullJadwal, 'sisa' => $cleanData];
    }

    //mengembalikan view dari hasil dari jadwal
    public function generateJadwal() {
        $jadwal = self::createJadwalTest();
        // return $jadwal;
        $model = new Jadwal();
        $dataKelas = $model->data_kelas;
        $dataJam = $model->data_jam;
        $kelasKey = array_keys($dataKelas);
        $kelas = [];
        for ($i=0; $i < count($dataKelas); $i++) { 
            for ($j=0; $j < count($dataKelas[$kelasKey[$i]]); $j++) {
                $kelas[] = $dataKelas[$kelasKey[$i]][$j];
            }
        }
        // return json_encode($jadwal);
        return view('createJadwal')->with('data', [
            'jam' => $dataJam,
            'kelas' => $kelas,
            'jadwal' => $jadwal
        ]);
    }
}
