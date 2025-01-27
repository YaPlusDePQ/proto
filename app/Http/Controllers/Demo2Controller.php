<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\edu\V2\Exercice;
use App\edu\Generate;


class Demo2Controller extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    private static $client = null;
    private static $course = null;
    private static $exemple = null;
    private static $exercices = [];
    private static $all = [];

    public static function loadCourse(string $ExerciceName){

        $client = new Generate();

        $exercice = new Exercice($ExerciceName);

        Session::put('V2exercice', $exercice );

        return redirect('V2/print');
    }

    public static function correct(Request $request){
        $client = new Generate();

        $exercice = session('V2exercice');

        $exercice->correct($client, $request);

        return redirect('V2/print');
    }

    public static function print(){
        
        return view('defaultV2', [
            'exercices'=>session('V2exercice'),
        ]);
    }
}