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
            foreach ($value['kelas'] as $valueKelas) {
                $currentKelas = $valueKelas;
                $readyData[$currentKelas][] = $value;
            }
        }
        ksort($readyData, SORT_NUMERIC);
        return $readyData;
    }

    //fungsi untuk memeriksa apakah pada jadwal per hari masih memiliki kolom yang belum di isi
    static function checkIsCompleted($jadwal) : bool | array{
        $isCompleted = true;
        $indexThatNotCompleted = [];
        // dd(count($jadwal), count($jadwal[0]));
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

    static function getKelas($arrKelas, $numberToFind){
        $result = 0;
        $arrReturn = [
            'back' => '',
            'forward' => '',
            'current' => '',
            'family' => []
        ];
        $tmp=[];
        $currentKelas = '';
        foreach ($arrKelas as $key => $value) {
            foreach ($value as $key => $hasil) {
                if($numberToFind === $result){
                    $tmp = $value;
                    $currentKelas = $hasil;
                    $arrReturn['current'] = $hasil;
                }
                $result++;
            }
        }
        $arrReturn['family'] = $tmp;
        foreach ($tmp as $key => $value) {
            if($value === $currentKelas){
                $arrReturn['forward'] = ((count($tmp) - 1) - $key) +  1;
                $arrReturn['back'] = $key + 1;
            }
        }
        return $arrReturn;
    }

    static function increaseTimeClass($dataJadwal, $currentClass, $currentId){
        $currentArray = $dataJadwal[$currentClass];
        for ($i=0; $i < count($dataJadwal[$currentClass]); $i++) { 
            if($currentArray[$i]['id'] === $currentId){
                $tmpCurrentArray = &$dataJadwal[$currentClass][$i];
                $tmpCurrentArray['jumlah_jam'] += 1;
            }
        }
    }

    static function decreaseTimeClass($dataJadwal, $familyClass, $keyIndex, $decrease){
        for ($i=0; $i < count($familyClass); $i++) { 
            $currentArray = &$dataJadwal[$familyClass[$i]][$keyIndex];
            if(isset($currentArray['jumlah_jam'])){
                $currentArray['jumlah_jam'] -= $decrease;
            }
        }
    }

    //fungsi untuk membuat jadwal
    static function createJadwal() : array {
        $model = new Jadwal();
        $rules = ['RECESS', 'MP', 'LUNCH', 'DISMISSAL', 'PRAY'];
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

        for ($a=0; $a < count($fullJadwal); $a++) {  //looping per hari
            $jadwalReady = [];
            for ($i=0; $i < $totalJam; $i++) {  //pembentukan jam belajar
                $tmp = [];
                for ($j=0; $j < $totalKelas; $j++) { //pembentukan jam belajar per kelas
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

            for ($u=0; $u < $totalJam; $u++) { //implementasi per jam belajar
                $incrementKelas = 0;

                if($u === 0){
                    continue;
                }else if($u === 5){
                    continue;
                }else if($u === 9){
                    continue;
                }
                for ($j=0; $j < count($kelasKey); $j++) { //implementasi per kelas
                    $tambahCheckStep = 0;
                    $currentIdArray = self::peelingIdFromArray($cleanData[$kelasData[$j]]);

                    if ($currentIdArray === false) {
                        $incrementKelas++;
                        continue;
                    }
                    if($incrementKelas >= count($kelasKey)){
                        break;
                    }
                    
                    if ($u + $tambahCheckStep >= $totalKelas) $tambahCheckStep = 0;
                    
                    $randomId = Jadwal::getRandomId($cleanData[$kelasData[$j]], $jadwalReady, ($u + $tambahCheckStep), $incrementKelas, $a);

                    if ($randomId === false) {
                        $incrementKelas++;
                        continue;
                    }

                    $randomKey = self::findIndexInArray($cleanData[$kelasData[$j]], $randomId['id']);
                    $currentArray = &$cleanData[$kelasData[$j]][$randomKey];
                    $penguranganJamKerja = min($currentArray['jumlah_jam'], 2);
                    $dataToEmbed = [
                        'id' => $currentArray['id'],
                        'mata_pelajaran_ref' => $currentArray['mata_pelajaran_ref'],
                        'nama_mata_pelajara' => $currentArray['nama_mata_pelajara'],
                        'nama_guru' => $currentArray['nama_guru'],
                        // 'id_guru' => $currentArray['id_guru'],
                    ];
                    
                    if ($currentArray['is_penjuruan'] == "1") {
                        $kelasdalamAngka = self::getKelas($kelas, $incrementKelas);
                        $tmpIncrementKelas = $incrementKelas;
                        for ($iii=0; $iii < $kelasdalamAngka['back']; $iii++) { 
                            for ($k=$u; $k < ($penguranganJamKerja + $u ); $k++) {
                                if ($k >= $totalKelas) {
                                    break;
                                }

                                if (in_array($jadwalReady[$k][$incrementKelas], $rules)) {
                                    continue;
                                }

                                self::increaseTimeClass($cleanData, $kelasdalamAngka['current'], $jadwalReady[$k][$incrementKelas]);
                                $jadwalReady[$k][$tmpIncrementKelas] = $dataToEmbed;
                            }
                            $tmpIncrementKelas--;
                        }
                        
                        $tmpIncrementKelas = $incrementKelas;
                        for ($iii=0; $iii < $kelasdalamAngka['forward']; $iii++) { 
                            for ($k=$u; $k < ($penguranganJamKerja + $u); $k++) {
                                if ($k >= $totalKelas) {
                                    break;
                                }

                                if (in_array($jadwalReady[$k][$incrementKelas], $rules)) {
                                    continue;
                                }

                                self::increaseTimeClass($cleanData, $kelasdalamAngka['current'], $jadwalReady[$k][$incrementKelas]);
                                $jadwalReady[$k][$tmpIncrementKelas] = $dataToEmbed;
                            }
                            $tmpIncrementKelas++;
                        }

                        self::decreaseTimeClass($cleanData, $kelasdalamAngka['family'], $randomKey, $penguranganJamKerja);
                        $incrementKelas += $kelasdalamAngka['forward'] + $kelasdalamAngka['back'];
                    }else{
                        for ($k=$u; $k < ($penguranganJamKerja + $u + $tambahCheckStep); $k++) {
                            if ($k >= $totalKelas) {
                                break;
                            }

                            if ($jadwalReady[$k][$incrementKelas] !== "BELAJAR") {
                                continue;
                            }

                            $jadwalReady[$k][$incrementKelas] = $dataToEmbed;
                            $currentArray['jumlah_jam'] -= 1;
                        }
                    }
                    $incrementKelas++;
                }
            }
            
            $sisaBelajar = self::checkIsCompleted($jadwalReady);

            if ($sisaBelajar !== true) {
                foreach ($sisaBelajar as $key => $value) {
                    $tambahCheckStep = 0;

                    if ($incrementKelas >= count($kelasKey)) {
                        break;
                    }
                    
                    if ($u + $tambahCheckStep >= $totalKelas) $tambahCheckStep = 0;
                    
                    $randomId = Jadwal::getRandomId($$cleanData[$kelasData[$j]], $jadwalReady, $value['Y'], $value['X'], $a);

                    if ($randomId === false) {
                        continue;
                    }
                    
                    $randomKey = self::findIndexInArray($cleanData[$kelasData[$value['X']]], $randomId);
                    $currentArray = &$cleanData[$kelasData[$value['X']]][$randomKey];
                    $jadwalReady[$value['Y']][$value['X']] = $currentArray;
                    $currentArray['jumlah_jam'] -= 1;
                }
            }

            $fullJadwal[$fullJadwalKeys[$a]] = $jadwalReady;
        }

        return $fullJadwal;
        // return ['jadwal' => $fullJadwal, 'sisa' => $cleanData];
    }

    //mengembalikan view dari hasil dari jadwal
    public function generateJadwal() {
        $jadwal = self::createJadwal();
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
