<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postulacion;
use App\Models\OfertasLaborales;
use App\Models\Usuario;

/**
 * Controlador de postulaciones
 * Autor: Charol Carrasco
 */
class PostulacionesController extends Controller
{
    // Validación básica RUT chileno
    private function isValidRut($rut)
    {
        return preg_match('/^[0-9]{7,8}-[0-9Kk]{1}$/', $rut);
    }

    private function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Postular a una oferta (candidato)
    public function store(Request $request)
    {
        $required = ['rut_cantidado', 'id_oferta', 'nombre', 'apellido', 'email', 'profesion'];
        foreach ($required as $campo) {
            if (!$request->has($campo)) {
                return response()->json([
                    'success' => false,
                    'code' => 422,
                    'message' => "El campo '$campo' es obligatorio"
                ], 422);
            }
        }

        // Validar formatos de campos
        if (!$this->isValidRut($request->input('rut_cantidado'))) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => "El rut_cantidado no es válido. Ejemplo válido: 12345678-9"
            ], 422);
        }

        if (!$this->isValidEmail($request->input('email'))) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => "El email no es válido"
            ], 422);
        }

        // Verificar oferta válida y activa
        $oferta = OfertasLaborales::find($request->input('id_oferta'));
        if (!$oferta || $oferta->estado !== 'activa') {
            return response()->json([
                'success' => false,
                'code' => 400,
                'message' => "La oferta indicada no existe o no está activa"
            ], 400);
        }

        // Verificar usuario válido y que sea candidato
        $usuario = Usuario::find($request->input('rut_cantidado'));
        if (!$usuario || $usuario->rol !== 'candidato') {
            return response()->json([
                'success' => false,
                'code' => 403,
                'message' => "El rut_cantidado no corresponde a un candidato registrado"
            ], 403);
        }

        // Verificar duplicidad de postulación
        $existe = Postulacion::where('id_oferta', $request->input('id_oferta'))
            ->where('rut_candidato', $request->input('rut_cantidado'))
            ->first();
        if ($existe) {
            return response()->json([
                'success' => false,
                'code' => 409,
                'message' => 'Ya existe una postulación para este candidato en esta oferta'
            ], 409);
        }

        // Guardar la postulación
        $postulacion = Postulacion::create([
            'id_oferta' => $request->input('id_oferta'),
            'rut_candidato' => $request->input('rut_cantidado'),
            'fecha_postulacion' => now(),
            'estado' => 'Postulando',
            'comentario' => '',
            'ultima_actualizacion' => now()
        ]);

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Postulación enviada'
        ], 200);
    }

    // Consultar estado y comentarios de postulaciones de un candidato
    public function porCandidato($rut_cantidado)
    {
        if (!$this->isValidRut($rut_cantidado)) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => "El rut_cantidado no es válido"
            ], 422);
        }

        $usuario = Usuario::find($rut_cantidado);
        if (!$usuario || $usuario->rol !== 'candidato') {
            return response()->json([
                'success' => false,
                'code' => 403,
                'message' => "El rut_cantidado no corresponde a un candidato registrado"
            ], 403);
        }

        $postulaciones = Postulacion::where('rut_candidato', $rut_cantidado)->with('oferta')->get();

        $resultado = [];
        foreach ($postulaciones as $p) {
            $resultado[] = [
                'id_oferta' => $p->id_oferta,
                'titulo_oferta' => $p->oferta ? $p->oferta->titulo : null,
                'estado' => $p->estado,
                'comentario' => $p->comentario,
                'ultima_actualizacion' => $p->ultima_actualizacion
            ];
        }

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Listado de postulaciones exitoso',
            'data' => $resultado
        ], 200);
    }

    // Actualizar estado y comentario de una postulación (reclutador)
    public function update(Request $request, $id_postulacion)
    {
        $required = ['estado', 'comentario'];
        foreach ($required as $campo) {
            if (!$request->has($campo)) {
                return response()->json([
                    'success' => false,
                    'code' => 422,
                    'message' => "El campo '$campo' es obligatorio"
                ], 422);
            }
        }

        $postulacion = Postulacion::find($id_postulacion);
        if (!$postulacion) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Postulación no encontrada'
            ], 404);
        }

        // Validar estado permitido
        $estadosPermitidos = ['Postulando', 'Revisando', 'Entrevista Psicológica', 'Entrevista Personal', 'Seleccionado', 'Descartado'];
        if (!in_array($request->input('estado'), $estadosPermitidos)) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => "El estado no es válido"
            ], 422);
        }

        $postulacion->estado = $request->input('estado');
        $postulacion->comentario = $request->input('comentario');
        $postulacion->ultima_actualizacion = now();
        $postulacion->save();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Estado actualizado'
        ], 200);
    }
}
