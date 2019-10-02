<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;
use App\PembelianCourse;
use App\Course;
use App\User;
use App\TutorSaldoTransaction;

class Tutor extends Model
{
	protected $table = 'tutors';

	protected $fillable = [
		'id_user', 'name', 'profile_photo', 'nama_bank', 'no_rekening', 'nama_rekening', 'story'
	];

	public function users()
	{
		return $this->hasOne("App\User", "id", "id_user");
	}

	public function edit(Request $request)
	{
		$tutor = $this::where('id_user', Auth::user()->id)->first();
		$user = User::where('id', Auth::user()->id)->first();

		$fotoProfil     = $request->file('foto');
		$urlFoto       = "";

		if ($fotoProfil != null) {
			$destinationPath = 'user-poto';
			$fotoName   = $fotoProfil->getClientOriginalName();
			$move		= $fotoProfil->move($destinationPath, $fotoName);
			$urlFoto 	= "user-poto/{$fotoName}";
			$user->foto = $urlFoto;
		}

		$user->nama = $request->nama;


		$tutor->nama_bank = $request->nama_bank;
		$tutor->no_rekening = $request->no_rekening;
		$tutor->nama_rekening = $request->nama_rekening;

		$tutor->update();
		$user->update();

	}

	public function getTutorSaldo($idTutor)
	{
		$id_tutor = $idTutor;
		$list_courses = Course::where('id_tutor', $id_tutor)->get();
		$pembelian_courses = new PembelianCourse;
		$total_saldo = 0 ;
		$tutor_commission_percentage = 0.5;
		foreach ($list_courses as $course) {
				$total_saldo= $total_saldo + $pembelian_courses->getRevenuePerCourse($course->id , $tutor_commission_percentage);
		}

		$total_withdrawn_amount = TutorSaldoTransaction::where('id_tutor', $id_tutor)
						->where('withdraw_status', 2)
						->sum('withdraw_amount');


		return $total_saldo - $total_withdrawn_amount;
	}

}
