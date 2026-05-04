<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfertasLaborales;
use App\Models\Postulacion;
use App\Models\Usuario;

/**
 * Controlador de ofertas laborales
 * Autor: Charol Carrasco
 */
class OfertasController extends Controller
{
    // Validación básica RUT chileno (solo formato, no dígito verificador)
    private function isValidRut($rut)
    {
        return preg_match('/^[0-9]{7,8}-[0-9Kk]{1}$/', $rut);
    }

    private function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Listar ofertas, por defecto solo activas
    public function index(Request $request)
    {
        $estado = $request->query('estado', 'activa');
        $ofertas = OfertasLaborales::where('estado', $estado)->get();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Listado de ofertas exitoso',
            'data' => $ofertas
        ], 200);
    }

    // Crear nueva oferta (reclutador)
    public function store(Request $request)
    {
        $required = ['titulo', 'descripcion', 'rut_usuario'];
        foreach ($required as $campo) {
            if (!$request->has($campo)) {
                return response()->json([
                    'success' => false,
                    'code' => 422,
                    'message' => "El campo '$campo' es obligatorio"
                ], 422);
            }
        }

        $rut = $request->input('rut_usuario');
        if (!$this->isValidRut($rut)) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => "El rut_usuario no tiene un formato válido (Ejemplo: 12345678-9)"
            ], 422);
        }

        $usuario = Usuario::find($rut);
        if (!$usuario || $usuario->rol !== 'reclutador') {
            return response()->json([
                'success' => false,
                'code' => 403,
                'message' => "rut_usuario no corresponde a un reclutador registrado"
            ], 403);
        }

        $oferta = OfertasLaborales::create([
            'titulo' => $request->input('titulo'),
            'descripcion' => $request->input('descripcion'),
            'fecha_publicacion' => now(),
            'estado' => 'activa',
            'rut_usuario' => $rut
        ]);

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Oferta creada exitosamente',
            'id_oferta' => $oferta->id_oferta
        ], 200);
    }

    // Editar oferta existente
    public function update(Request $request, $id)
    {
        $required = ['titulo', 'descripcion'];
        foreach ($required as $campo) {
            if (!$request->has($campo)) {
                return response()->json([
                    'success' => false,
                    'code' => 422,
                    'message' => "El campo '$campo' es obligatorio"
                ], 422);
            }
        }

        $oferta = OfertasLaborales::find($id);
        if (!$oferta) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Oferta no encontrada'
            ], 404);
        }

        $oferta->titulo = $request->input('titulo');
        $oferta->descripcion = $request->input('descripcion');
        $oferta->save();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Oferta actualizada'
        ], 200);
    }

    // Desactivar oferta (no borrado físico)
    public function desactivar($id)
    {
        $oferta = OfertasLaborales::find($id);
        if (!$oferta) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Oferta no encontrada'
            ], 404);
        }
        $oferta->estado = 'inactiva';
        $oferta->save();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Oferta desactivada'
        ], 200);
    }

    // Listar postulantes de una oferta (reclutador)
    public function postulantes($id)
    {
        $oferta = OfertasLaborales::find($id);
        if (!$oferta) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Oferta no encontrada'
            ], 404);
        }
        $postulaciones = Postulacion::where('id_oferta', $id)->get();

        $resultado = [];
        foreach ($postulaciones as $postulacion) {
            $usuario = Usuario::find($postulacion->rut_candidato);
            $resultado[] = [
                'id_postulacion' => $postulacion->id_postulacion,
                'nombre_candidato' => $usuario ? $usuario->nombre . ' ' . $usuario->apellido : null,
                'email' => $usuario ? $usuario->email : null,
                'estado' => $postulacion->estado,
                'comentario' => $postulacion->comentario
            ];
        }

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => "Listado de postulantes exitoso",
            'data' => $resultado
        ], 200);
    }
}
