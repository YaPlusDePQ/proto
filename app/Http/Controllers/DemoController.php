<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\edu\Course;
use App\edu\Generate;


class DemoController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    private static $client = null;
    private static $course = null;
    private static $exemple = null;
    private static $exercices = [];
    private static $all = [];

    public static function loadCourse(string $courseName){

        $client = new Generate();

        $course = new Course($courseName);

        $exemple = $course->getExemple('exo0', $client);

        $exercices = [];
        array_push( $exercices, $course->getExercice('exo1', $client));
        array_push( $exercices, $course->getExercice('exo2', $client));


        $all = $exercices;
        array_push( $all, $exemple);

        Session::put('course', $course );
        Session::put('exemple', $exemple );
        Session::put('exercices', $exercices );
        Session::put('all', $all);

        return redirect('/print');
    }

    public static function correct(Request $request){
        $client =new Generate();
        $all = session('all');

        foreach($all as $e){
            if(strcmp($e->name, $request->id) == 0){
                $e->correct($client, $request);
                break;
            }
        }

        return redirect('/print');
    }

    public static function print(){
        
        return view('default', [
            'course'=> session('course'),
            'exemple'=>session('exemple'),
            'exercices'=>session('exercices'),
        ]);
    }
}