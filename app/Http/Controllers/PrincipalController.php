<?php

namespace App\Http\Controllers;

use App\Entities\ContratoDocente;
use App\Entities\Jefe;
use App\Entities\Kardex;
use App\Entities\Leader;
use App\Entities\Grade;
use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PrincipalController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grados = Grade::all();
        return view('director.inscribirCursante',compact('grados'));
    }

    public function insDocente()
    {
        $grados = Grade::all();
        return view('director.inscribirDocente',compact('grados'));
    }

    //registra un cursante
    public function store(Request $request)
    {
        $cursante = new User;
        $v = Validator::make($request->all(),[
            'nickname'  => 'required|unique:users',
            'nombres'   => 'required',
            'paterno'   => 'required',
            'materno'   => 'string',
            'email'     => 'required|email|unique:users',
            //'password ' => 'required',
            'sexo'      => 'string',
            'telefono'  => 'numeric',
            'fnac'      => 'date',
            'direccion' => 'string',
            'profesion' => 'string',
            'parentesco' => 'string',
            'nomYap'    => 'string',
            'tel'       =>'numeric'
        ]);
        if ($v ->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        $var = $request['profesion'];

        //$pass = Input::get('password');
        //$cursante->create($request->all());
        $cursante->id           = Input::get('id');
        $cursante->nickname     = Input::get('nickname');
        $cursante->password     = Input::get('password');
        $cursante->nombres      = strtoupper(Input::get('nombres'));
        $cursante->paterno      = strtoupper(Input::get('paterno'));
        $cursante->materno      = strtoupper(Input::get('materno'));
        $cursante->email        = Input::get('email');
        $cursante->telefono     = Input::get('telefono');
        $cursante->sexo         = Input::get('sexo');
        $cursante->fnac         = Input::get('fnac');
        if($var == 'militar'){
            $cursante->grade_id     = Input::get('grade_idm');
        }elseif( $var == 'policia'){
            $cursante->grade_id     = Input::get('grade_idp');
        }elseif($var == 'civil'){
            $cursante->grade_id     = Input::get('grade_idc');
        }
        $cursante->direccion    = strtoupper(Input::get('direccion'));
        $cursante->profesion    = $var;
        $cursante->parentesco   = Input::get('parentesco');
        $cursante->nomYap       = Input::get('nomYap');
        $cursante->tel          = Input::get('tel');
        $cursante->role = 'cursante';
        $cursante->save();
        //$cursantes = User::all();
        return redirect('nuevoCursante')->with('status', true);

    }
    public function mostrarCursantes()//lista a los cursantes
    {
        //$cursantes = User::all();
        $cursantes = DB::table('users')
            ->leftJoin('grades', 'users.grade_id','=','grades.id')
            ->select('users.id','users.nombres','users.paterno','users.materno','users.email','users.telefono','users.role','users.sexo','users.fnac','users.direccion','users.profesion','grades.grado','users.parentesco','users.nomYap','users.tel')
            ->get();
        return view('director.modificarCursante', compact('cursantes'));
        //return $cursantes;
    }
    public function editarCursante($id)
    {
        $cursante =User::find($id);
        $grados = Grade::all();
        //return $cursante;
        return view('director.editarCursante',compact('cursante','grados'));
    }

    public function actualizarCursante($id,Request $request )
    {
        $cursante =User::find($id);
        $var = $request['profesion'];
        //$cursante->fill($request->all());
        $cursante->id           = Input::get('id');
        $cursante->nickname     = Input::get('nickname');
        $cursante->password     = Input::get('password');
        $cursante->nombres      = strtoupper(Input::get('nombres'));
        $cursante->paterno      = strtoupper(Input::get('paterno'));
        $cursante->materno      = strtoupper(Input::get('materno'));
        $cursante->email        = Input::get('email');
        $cursante->telefono     = Input::get('telefono');
        $cursante->sexo         = Input::get('sexo');
        $cursante->fnac         = Input::get('fnac');
        if($var == 'militar'){
            $cursante->grade_id     = Input::get('grade_idm');
        }elseif( $var == 'policia'){
            $cursante->grade_id     = Input::get('grade_idp');
        }elseif($var == 'civil'){
            $cursante->grade_id     = Input::get('grade_idc');
        }
        $cursante->direccion    = strtoupper(Input::get('direccion'));
        $cursante->profesion    = $var;
        $cursante->parentesco   = Input::get('parentesco');
        $cursante->nomYap       = Input::get('nomYap');
        $cursante->tel          = Input::get('tel');
        $cursante->save();
        return redirect('modificarCursante')->with('update', true);
    }
    //crea el docente... y actualiza
    public function newDocente(Request $request)
    {
        $docente = new User;
        $v = Validator::make($request->all(),[
            'nickname'  => 'required|unique:users',
            'nombres'   => 'required',
            'paterno'   => 'required',
            'materno'   => 'string',
            'email'     => 'required|email|unique:users',
            //'password ' => 'required',
            'sexo'      => 'string',
            'telefono'  => 'numeric',
            'fnac'      => 'date',
            'direccion' => 'string',

        ]);
        if ($v ->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        $var = $request['profesion'];
       // $pass = Input::get('password');
        //$cursante->create($request->all());
        $docente->id            = Input::get('id');
        $docente->nickname      = Input::get('nickname');
        $docente->password      = Input::get('password');
        $docente->nombres       = strtoupper(Input::get('nombres'));
        $docente->paterno       = strtoupper(Input::get('paterno'));
        $docente->materno       = strtoupper(Input::get('materno'));
        $docente->email         = Input::get('email');
        $docente->telefono      = Input::get('telefono');
        $docente->sexo          = Input::get('sexo');
        $docente->fnac          = Input::get('fnac');
        if($var == 'militar'){
            $docente->grade_id     = Input::get('grade_idm');
        }elseif( $var == 'policia'){
            $docente->grade_id     = Input::get('grade_idp');
        }elseif($var == 'civil'){
            $docente->grade_id     = Input::get('grade_idc');
        }
        $docente->direccion    = strtoupper(Input::get('direccion'));
        $docente->profesion    = $var;
        $docente->parentesco   = Input::get('parentesco');
        $docente->nomYap       = Input::get('nomYap');
        $docente->tel          = Input::get('tel');
        $docente->role = 'docente';
        $docente->save();
    }
    public function mostrarDocentes()//lista a los docentes
    {
        //$cursantes = User::all();
        $docentes = DB::table('users')
            ->leftJoin('grades', 'users.grade_id','=','grades.id')
            ->select('users.id','users.nombres','users.paterno','users.materno','users.email','users.telefono','users.role','users.sexo','users.fnac','users.profesion','users.direccion','grades.grado','users.parentesco','users.nomYap','users.tel')
            ->get();
        return view('director.modificarDocente', compact('docentes'));
        //return $docentes;
    }
    public function editarDocente($id)
    {
        $docente = User::find($id);
        return view('director.editarDocente',compact('docente'));
    }
    public function actualizarDocente($id,Request $request )
    {
        $cursante = User::find($id);
        //$cursante->fill($request->all());
        $var = $request['profesion'];
        $cursante->id           = Input::get('id');
        $cursante->nickname     = Input::get('nickname');
        $cursante->password     = Input::get('password');
        $cursante->nombres      = strtoupper(Input::get('nombres'));
        $cursante->paterno      = strtoupper(Input::get('paterno'));
        $cursante->materno      = strtoupper(Input::get('materno'));
        $cursante->email        = Input::get('email');
        $cursante->telefono     = Input::get('telefono');
        $cursante->sexo         = Input::get('sexo');
        $cursante->fnac         = Input::get('fnac');
        if($var == 'militar'){
            $cursante->grade_id     = Input::get('grade_idm');
        }elseif( $var == 'policia'){
            $cursante->grade_id     = Input::get('grade_idp');
        }elseif($var == 'civil'){
            $cursante->grade_id     = Input::get('grade_idc');
        }
        $cursante->direccion    = strtoupper(Input::get('direccion'));
        $cursante->profesion    = $var;
        $cursante->parentesco   = Input::get('parentesco');
        $cursante->nomYap       = Input::get('nomYap');
        $cursante->tel          = Input::get('tel');
        $cursante->save();
        return redirect('modificarDocente')->with('update', true);
    }

    public function destroyCu($id)
    {
        User::destroy($id);
        Session::flash('message','Usuario Eliminado...');
        return redirect()->back();
    }
    public function destroyDo($id)
    {
        User::destroy($id);
        Session::flash('message','Usuario Eliminado...');
        return redirect()->back();
    }
    public function mostrarGroup()
    {
        return view('director.mostrarsorteo');
    }

    public function prueba()
    {
        $grupo = DB::table('users')
            ->where('role','cursante')
            ->leftJoin('kardexes','users.id','=','user')
            ->leftJoin('grades', 'users.grade_id','=','grades.id')
            ->where('materia_id',1)
            ->select('user','nombres','paterno','materno','grupo','grado','profesion')

            ->orderBy('grupo')
            ->orderBy('nombres')
            ->get();
        return $grupo;
    }
    public function sortearGrupos()
    {
        $numero = Input::get('numero');
        $materia = Input::get('materia_id');
        //$alumnos = User::where('role','cursante')->select('id','nombres','paterno','materno')->get();
        $alumnos = DB::table('users')
            ->where('role','cursante')
            ->leftJoin('kardexes','users.id','=','user')
            ->where('materia_id',$materia)
            ->select('users.id','nombres','paterno','materno')
            ->get();
        ;
        $alumnos = collect($alumnos);
        $leng = $alumnos->count();
        $shuffled = $alumnos->shuffle();
        foreach ($shuffled as $shu){
            $ii[] = $shu->id;
        }
        $cont =0;
        $gru = 1;
        for ($i = 0; $i < $leng ; ++$i) {
            if($cont == $numero){
                $cont =0;
                $gru = $gru + 1;
            }
            $cont = $cont + 1;
            DB::table('kardexes')
                ->where('user', $ii[$i])
                ->update(['grupo' => $gru]);
        }
        return view('director.sorteo')->with('shuffled',$shuffled)->with('numero',$numero)->with('materia',$materia);
    }

    public function asignarCursante()
    {
        $cursantes = DB::table('users')
            ->where('role','cursante')
            ->leftJoin('kardexes','users.id','=','user')
            ->select('users.id','nombres','paterno','materno','materia_id','gestion','grupo')
            ->orderBy('materia_id')
            ->get();
        return view('director.asignarCursante',compact('cursantes'));
    }
    public function asignaMateria($id)
    {
        $usrMa= DB::table('kardexes')
            ->where('user',$id)
            ->select('materia_id')
            ->get();

        $quu = DB::select('select * from materias where id not in (select kardexes.materia_id from kardexes where kardexes.user=?)',array($id));
        return view('director.nuevaMateria',compact('quu'))->with('id',$id)->with('usrMa',$usrMa);
    }
    public function asign($id)
    {
        $cursante = new Kardex();
        $cursante->user         = $id;
        $cursante->gestion      = Input::get('gestion');
        $cursante->materia_id   = Input::get('materia_id');
        $cursante->ua_id        = Input::get('ua_id');
        $cursante->activo       = 1;
        $cursante->save();
        Session::flash('message','Cursante Asignado Exitosamente');
        return redirect()->back();
    }
    public function asignarDocente()
    {
        $docentes = DB::table('users')
            ->where('role','docente')
            ->leftJoin('contrato_docentes','users.id','=','user')
            ->select('users.id','nombres','paterno','materno','materia_id','gestion')
            ->orderBy('nombres')
            ->orderBy('materia_id')
            ->get();
        return view('director.asignarDocente',compact('docentes'));
    }
    public function asignaContrado($id)
    {
        $quu = DB::select('select * from materias where id not in (select contrato_docentes.materia_id from contrato_docentes where contrato_docentes.user=?)',array($id));
        return view('director.nuevoContrado',compact('id','quu'));
    }
    public function asignaDo($id)
    {
        //echo date("r");

        $docente = new ContratoDocente();
        $docente->user         = $id;
        $docente->gestion      = Input::get('gestion');
        $docente->materia_id   = Input::get('materia_id');
        $docente->ua_id        = Input::get('ua_id');
        $docente->save();
        Session::flash('message','Docente Asignado Exitosamente');
        return redirect()->back();
    }
    public function calificarCursanteSelecMateria()
    {
        //dd($disciplinas);
        return view ('director.calificarCursanteSelecMateria');
    }

    public function calificarCursante(Request $request)
    {
        //Seleccionamos el id de la materia que selecciono
        $materiaId = \DB::table('materias')->where('nombreMateria',$request['materia'])->value('id');

        //Seleccionamos los cursantes que pasan esa materia
        $cursantes = \DB::table('kardexes')
                    ->join('users as u', 'user', '=', 'u.id')
                    ->select('u.nombres', 'u.paterno', 'u.materno', 'u.id')
                    ->where('materia_id', $materiaId)
                    ->where('activo', 1)
                    //Seleccionamos los que aun no califico
                    ->where('prom4JE',0)
                    //->where('ua_id', unidadDelDirector)
                    ->get();
        return view ('director.calificarCursante', compact('cursantes', 'materiaId'));
    }

    public function formCalifCursante(Request $request)
    {
        //dd($request['materia']);
        if($request['cursante'] != null)
        {
            //Seleccionamos id del cursante calificado
            $cursanteId = substr($request['cursante'], strpos($request['cursante'], '- ')+strlen('- '));

            //Insertamos valores
            \DB::table('kardexes')
                ->where('materia_id', $request['materia'])
                ->where('user', $cursanteId)
                ->where('activo', 1)
                ->update(
                    [
                        '41aJE' => $request['1califCursante'],
                        '41bJE' => $request['2califCursante'],
                        '41cJE' => $request['3califCursante'],
                        '41dJE' => $request['4califCursante'],
                        'prom4JE' => (($request['1califCursante']+
                                        $request['2califCursante']+
                                        $request['3califCursante']+
                                        $request['4califCursante'])/4)
                    ]);

            //3 Promedios del parametro 4
            $promedios = \DB::table('kardexes')
                ->where('materia_id', (int)$request['materia'])
                ->where('activo', 1)
                ->where('user', $cursanteId)
                ->select('prom4Cursante', 'prom4Facil', 'prom4JE')
                ->get();

            //Pomredio 4, para actulaizarlo
            $promedioGeneral = ($promedios[0]->{'prom4Cursante'})*0.1+
                ($promedios[0]->{'prom4JE'})*0.2+
                ($promedios[0]->{'prom4Facil'})*0.7;
            //dd($promedios);

            //Insertamos valores
            \DB::table('kardexes')
                ->where('materia_id', $request['materia'])
                ->where('user', $cursanteId)
                ->where('activo', 1)
                ->update(['prom4' => $promedioGeneral]);
        }
        return view('director.calificacionExitosa');
        //dd('exitoso');
    }

    public function reportePorMateria()
    {
        $disciplinas = \DB::table('materias')
                   ->select('nombreMateria')
                   ->get();

        $jefes = Jefe::all();
        return view('director.reportePorMateriaSelecMateria', compact('disciplinas','jefes'));
    }

    public function reportePorCursante()
    {
        $cursantes = DB::table('users')
            ->where('role','cursante')
            //->leftJoin('kardexes','users.id','=','user')
            ->select('users.id','nombres','paterno','materno')

            ->get();

        $jefes = Jefe::all();

        return view('director.reportePorCursante',compact('cursantes','directores','jefes'));
    }

    public function reporteCursantePdf(Request $request)
    {
        $id = $request['cursante'];

        $cursante = DB::table('users')
            ->where('users.id',$id)
            ->join('kardexes','users.id','=','user')
            ->get();
        $directores = Leader::all();
        $nombreJefe = $request['jefe'];
        $jefes = DB::table('jeves')
            ->where('jefe_est',$nombreJefe)
            ->get();

        $view = \View::make('director.RepdfCursante',compact('cursante','directores','jefes'))->render();

        $pdf= \PDF::loadHTML($view)->setPaper('letter');

        return $pdf->stream('Cursate-{users.paterno}.pdf');

    }
}
